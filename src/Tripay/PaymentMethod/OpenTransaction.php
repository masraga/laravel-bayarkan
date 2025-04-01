<?php

namespace Koderpedia\LaravelBayarkan\Tripay\PaymentMethod;

use Illuminate\Support\Facades\Http;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

class OpenTransaction implements PaymentMethod
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
    $this->baseUrl = (config("tripay.tripay_api_production")) ? "https://tripay.co.id/api" : "https://tripay.co.id/api";
  }
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string
  {
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
      "customer_name" => $payload["customerDetail"]["name"],
      "signature" => $payload["signature"]
    ];
    $response = Http::withHeaders([
      "Authorization" => "Bearer " . config("tripay.tripay_api_key")
    ])->post(
      $this->baseUrl . "/open-payment/create",
      $payload
    );
    return $response->json();
  }

  public function detail(string $orderRef): array
  {
    $response = Http::withHeaders([
      "Authorization" => "Bearer " . config("tripay.tripay_api_key")
    ])->get(
      $this->baseUrl . "/open-payment/$orderRef/detail",
      ["reference" => $orderRef]
    );
    return $response->json();
  }
}
