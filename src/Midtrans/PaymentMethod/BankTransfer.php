<?php

namespace Koderpedia\LaravelBayarkan\Midtrans\PaymentMethod;

use Error;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

class BankTransfer implements PaymentMethod
{
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string Payment type
   */
  public function setPaymentType(string $type): string
  {
    $validPayment = [
      "BCA",
      "BNI",
      "BRI",
      "MANDIRI",
      "PERMATA",
      "CIMB"
    ];
    if (!in_array($type, $validPayment)) {
      throw new Error("$type not supported in midtrans");
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
    /**
     * setup payment type
     */
    if ($payload["paymentType"] == "BCA") {
      $payload["payment_type"] = "bank_transfer";
      $payload["bank_transfer"] = [
        "bank" => "bca"
      ];
    } else if ($payload["paymentType"] == "BNI") {
      $payload["payment_type"] = "bank_transfer";
      $payload["bank_transfer"] = [
        "bank" => "bni"
      ];
    } else if ($payload["paymentType"] == "BRI") {
      $payload["payment_type"] = "bank_transfer";
      $payload["bank_transfer"] = [
        "bank" => "bri"
      ];
    } else if ($payload["paymentType"] == "MANDIRI") {
      $payload["payment_type"] = "echannel";
      $payload["echannel"] = [
        "bill_info1" => "Midtrans: ",
        "bill_info2" => "Online purchase"
      ];
    } else if ($payload["paymentType"] == "PERMATA") {
      $payload["payment_type"] = "permata";
    } else if ($payload["paymentType"] == "CIMB") {
      $payload["payment_type"] = "bank_transfer";
      $payload["bank_transfer"] = [
        "bank" => "bri"
      ];
    }
    unset($payload["paymentType"]);
    /**
     * setup transaction detail
     */
    if (!isset($payload["items"])) {
      throw new Error("items is required");
    }
    if (!is_array($payload["items"])) {
      throw new Error("items must be array");
    }
    $payload["item_details"] = [];
    $payload["transaction_details"] = [
      "order_id" => $payload["orderId"],
      "gross_amount" => 0
    ];
    foreach ($payload['items'] as $item) {
      $payload["item_details"][] = [
        "name" => $item["name"],
        "price" => $item["price"],
        "quantity" => $item["quantity"],
      ];
      $payload["transaction_details"]["gross_amount"] += intval($item["quantity"]) * intval($item["price"]);
    }
    unset($payload["items"]);
    unset($payload["orderId"]);
    /**
     * setup customer detail
     */
    $payload["customer_details"]["first_name"] = $payload["customerDetail"]["firstName"];
    $payload["customer_details"]["last_name"] = $payload["customerDetail"]["lastName"];
    $payload["customer_details"]["email"] = $payload["customerDetail"]["email"];
    $payload["customer_details"]["phone"] = $payload["customerDetail"]["phone"];
    $payload["customer_details"]["billing_address"]["address"] = $payload["customerDetail"]["address"];
    unset($payload["customerDetail"]);
    return $payload;
  }
  /**
   * Create transaction order
   * 
   * @param mixed $payload Payload for creating payment
   * @return mixed
   */
  public function createTransaction(array $payload): array
  {
    $this->setPayload($payload);

    return $payload;
  }
}
