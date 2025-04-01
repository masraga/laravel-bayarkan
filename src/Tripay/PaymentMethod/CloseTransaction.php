<?php

namespace Koderpedia\LaravelBayarkan\Tripay\PaymentMethod;

use Error;
use Illuminate\Support\Facades\Http;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

class CloseTransaction implements PaymentMethod
{
  /**
   * Tripay base url
   */
  private string $baseUrl;

  /**
   * Close transaction construction
   */
  public function __construct()
  {
    $this->baseUrl = (config("tripay.tripay_api_production")) ? "https://tripay.co.id/api" : "https://tripay.co.id/api-sandbox";
  }
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string
  {
    $validType = [
      "PERMATAVA",
      "BNIVA",
      "BRIVA",
      "MANDIRIVA",
      "BCAVA",
      "MUAMALATVA",
      "CIMBVA",
      "BSIVA",
      "OCBCVA",
      "DANAMONVA",
      "OTHERBANKVA",
      "ALFAMART",
      "INDOMARET",
      "ALFAMIDI",
      "OVO",
      "QRIS",
      "QRISC",
      "QRIS2",
      "DANA",
      "SHOPEEPAY"
    ];
    if (!in_array($type, $validType)) {
      throw new Error("$type not supported in tripay");
    }
    return $type;
  }
  /**
   * Map transaction payload based on payment criteria
   * 
   * @param mixed $payload Transaction paylaod
   * @return mixed
   */
  public function setPayload(array &$payload): array
  {
    return $payload;
  }
  public function create(array $payload): array
  {
    $payload = [
      "method" => $payload["paymentType"],
      "merchant_ref" => $payload["orderId"],
      "amount" => $payload["amount"],
      "customer_name" => $payload["customerDetail"]["name"],
      "customer_email" => $payload["customerDetail"]["email"],
      "customer_phone" => $payload["customerDetail"]["phone"],
      "order_items" => $payload["items"],
      "returnUrl" => $payload["returnUrl"] ?? config("tripay.tripay_return_url"),
      "callbackUrl" => $payload["notifUrl"] ?? config("tripay.tripay_notification_url"),
      "expired_time" => $payload["expiredTime"],
      "signature" => $payload["signature"]
    ];
    $response = Http::withHeaders([
      "Authorization" => "Bearer " . config("tripay.tripay_api_key")
    ])->post(
      $this->baseUrl . "/transaction/create",
      $payload
    );
    return $response->json();
  }

  public function detail(string $orderRef): array
  {
    $response = Http::withHeaders([
      "Authorization" => "Bearer " . config("tripay.tripay_api_key")
    ])->get(
      $this->baseUrl . "/transaction/detail",
      ["reference" => $orderRef]
    );
    return $response->json();
  }
}
