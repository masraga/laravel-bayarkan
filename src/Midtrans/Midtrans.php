<?php

namespace Koderpedia\LaravelBayarkan\Midtrans;

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

  public function __construct()
  {
    $this->baseUrl = (config("midtrans.midtrans_api_production")) ?
      "https://api.midtrans.com/v2" :
      "https://api.sandbox.midtrans.com/v2";

    $this->payload = [
      "paymentType" => "",
      "transactionDetail" => [],
      "creditCard" => [], // for credit card payment
      "items" => [],
      "customerDetails" => [],
      "customerExpiry" => [],
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
  public function setCustomerDetail(array $customer) {}

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
  public function setExpiredTime(string|int|array $time) {}

  /**
   * Generate payment invoice
   * @return mixed
   */
  public function createTransaction(): array
  {
    return $this->paymentMethod->createTransaction($this->payload);
  }

  /**
   * Get transaction detail
   * 
   * @param string $orderRef Transaction order ID / reference id
   * @return mixed
   */
  public function detailTransaction(string $orderRef): array
  {
    return [];
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
