<?php

namespace Koderpedia\LaravelBayarkan\Midtrans;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;
use Koderpedia\LaravelBayarkan\Abstract\Transactions;

class Midtrans implements Transactions
{
  /**
   * Midtrans default payload
   */
  private array $payload;

  /**
   * Transaction payment method
   */
  private PaymentMethod $paymentMethod;

  /**
   * Midtrans base url
   */
  public string $baseUrl;

  /**
   * Default midtrans http header
   */
  private array $httpHeaders;

  public function __construct()
  {
    $this->httpHeaders = [
      "Authorization" => "Basic " . Str::toBase64(config("midtrans.midtrans_server_key") . ":"),
      "Content-Type" => "application/json",
      "Accept" => "application/json"
    ];

    $this->baseUrl = (config("midtrans.midtrans_api_production")) ?
      "https://api.midtrans.com/v2" :
      "https://api.sandbox.midtrans.com/v2";

    $this->payload = [
      "paymentType" => "",
      "transactionDetail" => [],
      "creditCard" => [], // for credit card payment
      "items" => [],
      "customerDetail" => [],
      "expiryTime" => [],
      "orderId" => "",
    ];
  }

  /**
   * Define payment method for transaction
   * 
   * @param PaymentMethod $paymentMethod Payment method for transaction
   * @return 
   */
  public function use(PaymentMethod $paymentMethod)
  {
    $this->paymentMethod = $paymentMethod;
    $this->paymentMethod->baseUrl = $this->baseUrl;
    return $this;
  }

  /**
   * Define payment order id
   * @param string $orderId
   * @return
   */
  public function setOrderId(string $orderId)
  {
    $this->payload["orderId"] = $orderId;
    return $this;
  }

  /**
   * Define payment type or order
   * 
   * @param string $type
   * @return
   */
  public function setPaymentType(string $type)
  {
    $this->payload["paymentType"] = $this->paymentMethod->setPaymentType($type);
    return $this;
  }

  /**
   * Define purchase item
   * 
   * @param mixed $items
   * @return
   */
  public function setItems(array $items)
  {
    $this->payload["items"] = $items;
    return $this;
  }

  /**
   * Define customer detail for payment
   */
  public function setCustomerDetail(array $customer)
  {
    $this->payload["customerDetail"] = $customer;
    return $this;
  }

  /**
   * Define expired time for invoice
   * 
   * Example:
   * 
   * ```php
   * $time = [
   *  "expiry_duration": 60,
   *  "unit: "minute"
   * ]
   * 
   * @param string|int|mixed $time Expired time
   */
  public function setExpiredTime(string|int|array $time)
  {
    $this->payload["expiryTime"] = $time;
    $this->payload["custom_expiry"] = [
      "expiry_duration" => $time["duration"],
      "unit" => $time["unit"]
    ];
    unset($this->payload["expiryTime"]);
    return $this;
  }

  /**
   * Generate payment invoice
   * @return mixed
   */
  public function createTransaction(): array
  {
    $this->paymentMethod->setPayload($this->payload);
    $endpoint = $this->baseUrl . "/charge";
    $response = Http::withHeaders($this->httpHeaders)->post($endpoint, $this->payload);
    return $response->json();
  }

  /**
   * Get transaction detail
   * 
   * @param string $orderRef Transaction order ID / reference id
   * @return mixed
   */
  public function detailTransaction(string $orderRef): array
  {
    $endpoint = $this->baseUrl . "/" . $orderRef . "/status";
    $response = Http::withHeaders($this->httpHeaders)->get($endpoint);
    return $response->json();
  }

  /**
   * Get payment channel of payment gateway
   * 
   * @return mixed
   */
  public function getPaymentChannel(): array
  {
    return [];
  }
}
