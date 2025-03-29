<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

use Illuminate\Support\Facades\Http;
use Koderpedia\LaravelBayarkan\Abstract\Tripay\Transactions;

class OpenTransaction implements Transactions
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
