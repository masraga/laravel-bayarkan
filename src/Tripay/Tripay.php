<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

use Koderpedia\LaravelBayarkan\Abstract\Transactions;
use Koderpedia\LaravelBayarkan\Abstract\Tripay\CloseTransaction;
use Koderpedia\LaravelBayarkan\Abstract\Tripay\Transactions as TripayTransactions;

class Tripay implements Transactions
{

  /**
   * Transaction payload
   */
  private array $payload;

  /**
   * Tripay transaction interface
   */
  private TripayTransactions $transaction;

  public function __construct(TripayTransactions $transaction)
  {
    $this->transaction = ($transaction) ? $transaction : new CloseTransaction();
    $this->payload = array(
      "orderId" => "",
      "customerDetail" => array(),
      "items" => array(),
      "paymentType" => "",
      "redirectUrl" => "",
      "notifUrl" => ""
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
    $this->payload["items"] =  $items;
    return $this;
  }

  public function setCustomerDetail(array $customer)
  {
    $this->payload["customerDetail"] = $customer;
    return $this;
  }

  /**
   * Generate tripay payment signature
   * 
   * @return void
   */
  private function generateSignature() {}

  public function createTransaction(): array
  {
    return $this->transaction->create($this->payload);
  }
}
