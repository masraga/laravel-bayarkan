<?php

namespace Koderpedia\LaravelBayarkan\Midtrans\PaymentMethod;

use Error;
use Koderpedia\LaravelBayarkan\Abstract\PaymentMethod;

/**
 * Setup cardless payment method
 */
class Cardless implements PaymentMethod
{
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string
  {
    $validType = ["akulaku"];
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
    unset($payload["paymentType"]);
    return $payload;
  }
}
