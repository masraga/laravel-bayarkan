<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

use Illuminate\Support\Facades\Http;
use Koderpedia\LaravelBayarkan\Abstract\Tripay\Transactions;

class CloseTransaction implements Transactions
{
  /**
   * Tripay base url
   */
  private string $baseUrl;

  /**
   * Close transaction construction
   * 
   * @param string $baseUrl Tripay endpoint baseUrl
   */
  public function __construct(string $baseUrl)
  {
    $this->baseUrl = $baseUrl;
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
