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
    return $payload;
  }
}
