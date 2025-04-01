<?php

namespace Koderpedia\LaravelBayarkan\Midtrans\PaymentMethod;

use Error;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

/**
 * Set payment for over the counter payment
 */
class OTC implements PaymentMethod
{
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string
  {
    $validType = ["alfamart", "indomaret"];
    if (!in_array($type, $validType)) {
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
    $payload["payment_type"] = $payload["paymentType"];
    if ($payload["paymentType"] == "indomaret") {
      $payload["cstore"] = [
        "store" => "indomaret",
        "message" => "Midtrans indomaret payment",
        "indomaret_free_text_1" => "indomaret",
      ];
    } else if ($payload["paymentType"] == "alfamart") {
      $payload["cstore"] = [
        "store" => "alfamart",
        "message" => "Midtrans alfamart payment",
        "alfamart_free_text_1" => "alfamart",
      ];
    }
    unset($payload["paymentType"]);
    return $payload;
  }
}
