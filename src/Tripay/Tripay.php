<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

use Illuminate\Support\Facades\Http;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;
use Koderpedia\LaravelBayarkan\Abstract\Transactions;
use Koderpedia\LaravelBayarkan\Utils;

class Tripay implements Transactions
{

  /**
   * Transaction payload
   */
  private array $payload;

  /**
   * Tripay transaction interface
   */
  private PaymentMethod $transaction;

  /**
   * define tripay base url
   */
  private string $baseUrl;

  public function __construct()
  {
    $this->setDefaultVariable();
  }

  /**
   * Setup default payload for generate transaction
   */
  private function setDefaultVariable()
  {
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
  /**
   * Define payment method for transaction
   * 
   * @param PaymentMethod $paymentMethod Payment method for transaction
   * @return 
   */
  public function use(PaymentMethod $paymentMethod)
  {
    $this->transaction = $paymentMethod;
    return $this;
  }
  public function setOrderId(string $orderId)
  {
    $this->payload["orderId"] = $orderId;
    return $this;
  }

  public function setPaymentType(string $type)
  {
    $this->payload["paymentType"] = $this->transaction->setPaymentType($type);
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

  public function setExpiredTime(array $time)
  {
    $unixTime = Utils::unixTime($time["duration"], $time["unit"]);
    $this->payload["expiredTime"] = $unixTime;
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

  public function getPaymentChannel(): array
  {
    $endpoint = $this->baseUrl . "/merchant/payment-channel";
    $response = Http::withHeaders([
      "Authorization" => "Bearer " . config("tripay.tripay_api_key")
    ])->get($endpoint);
    return $response->json();
  }
}
