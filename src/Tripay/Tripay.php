<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

use Koderpedia\LaravelBayarkan\Abstract\Transactions;
use Koderpedia\LaravelBayarkan\Tripay\CloseTransaction;
use Koderpedia\LaravelBayarkan\Abstract\Tripay\Transactions as TripayTransactions;

class Tripay implements Transactions
{

  /**
   * Close payment method for tripay
   */
  const CLOSE_PAYMENT = "close";

  /**
   * Open payment method for tripay
   */
  const OPEN_PAYMENT = "open";

  /**
   * Transaction payload
   */
  private array $payload;

  /**
   * Tripay transaction interface
   */
  private TripayTransactions $transaction;

  /**
   * define tripay base url
   */
  private string $baseUrl;

  public function __construct(string $useMethod = self::CLOSE_PAYMENT)
  {
    $this->setDefaultVariable();
    $this->transaction = ($useMethod == self::CLOSE_PAYMENT) ? new CloseTransaction($this->baseUrl) : "";
  }

  /**
   * Setup default payload for generate transaction
   */
  private function setDefaultVariable()
  {
    $this->baseUrl = (config("tripay.tripay_api_production")) ? "https://tripay.co.id/api" : "https://tripay.co.id/api-sandbox";
    $this->payload = array(
      "orderId" => "",
      "customerDetail" => array(),
      "items" => array(),
      "paymentType" => "",
      "redirectUrl" => "",
      "notifUrl" => "",
      "signature" => "",
      "amount" => 0,
      "expiredTime" => 0,
    );
  }

  public function setOrderId(string $orderId)
  {
    $this->payload["orderId"] = $orderId;
    return $this;
  }

  public function setPaymentType(string $type)
  {
    $this->payload["paymentType"] = $type;
    return $this;
  }

  public function setItems(array $items)
  {
    $this->payload["items"] = $items;
    foreach ($items as $item) {
      $this->payload["amount"] += ($item["quantity"] * $item["price"]);
    }
    return $this;
  }

  public function setCustomerDetail(array $customer)
  {
    $this->payload["customerDetail"] = $customer;
    return $this;
  }

  public function setExpiredTime(string|int $time)
  {
    $this->payload["expiredTime"] = $time;
    return $this;
  }

  public function createTransaction(): array
  {
    $this->payload["signature"] = hash_hmac(
      'sha256',
      config("tripay.tripay_merchant_code") . $this->payload["orderId"] . $this->payload["amount"],
      config("tripay.tripay_private_key")
    );
    return $this->transaction->create($this->payload);
  }

  public function detailTransaction(string $orderRef): array
  {
    return $this->transaction->detail($orderRef);
  }
}
