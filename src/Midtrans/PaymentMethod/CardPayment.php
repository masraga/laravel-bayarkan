<?php

namespace Koderpedia\LaravelBayarkan\Midtrans\PaymentMethod;

use Error;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

class CardPayment implements PaymentMethod
{

  /**
   * customer card info
   */
  private array $cardInfo;
  /**
   * Default midtrans http header
   */
  private array $httpHeaders;
  /**
   * Midtrans base url
   */
  public string $baseUrl;

  /**
   * Class card payment constructor
   * 
   * @param string $number Card number
   * @param string $expMonth Card expired month
   * @param string $expYear Card expired year
   * @param string $cvv Card cvv
   */
  public function __construct(string $number, string $expMonth, string $expYear, string $cvv)
  {
    $this->cardInfo = [
      "number" => $number,
      "expMonth" => $expMonth,
      "expYear" => $expYear,
      "cvv" => $cvv,
    ];
    $this->httpHeaders = [
      "Authorization" => "Basic " . Str::toBase64(config("midtrans.midtrans_server_key") . ":"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];
  }

  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string
  {
    $validPayment = [
      "credit_card"
    ];
    if (!in_array($type, $validPayment)) {
      throw new Error("$type not supported in midtrans");
    }
    return $type;
  }
  /**
   * Get card payment token
   * 
   * @return mixed
   */
  private function getToken(): array
  {
    $endpoint = $this->baseUrl . "/token";
    $payload = [
      "client_key" => config("midtrans.midtrans_client_key"),
      "card_number" => $this->cardInfo["number"],
      "card_exp_month" => $this->cardInfo["expMonth"],
      "card_exp_year" => $this->cardInfo["expYear"],
      "card_cvv" => $this->cardInfo["cvv"],
    ];
    $response = Http::withHeaders($this->httpHeaders)->get($endpoint, $payload);
    return $response->json();
  }
  /**
   * Map transaction payload based on payment criteria
   * 
   * @param mixed $payload Transaction paylaod
   * @return mixed
   */
  public function setPayload(array &$payload): array
  {
    $this->baseUrl = $payload["baseUrl"];

    $token = $this->getToken();
    $payload["credit_card"] = [
      "token_id" => $token["token_id"],
      "authentication" => true
    ];

    if ($payload["paymentType"] == "credit_card") {
      $payload["payment_type"] = $payload["paymentType"];
    }
    unset($payload["paymentType"]);
    return $payload;
  }
}
