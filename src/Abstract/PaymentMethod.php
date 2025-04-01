<?php

namespace Koderpedia\LaravelBayarkan\Abstract;

interface PaymentMethod
{
  /**
   * Create payment type of transaction
   * 
   * @param string $type Valid payment type
   * @return string PaymentType
   */
  public function setPaymentType(string $type): string;
  /**
   * Map transaction payload based on payment criteria
   * 
   * @param mixed $payload Transaction paylaod
   * @return mixed
   */
  public function setPayload(array &$payload): array;
  /**
   * Creating transaction signature if each payment have difference method to create signature
   * 
   * @param mixed $payload Transaction payload
   */
  public function create(array $payload): array;
  /**
   * Getting transaction detail
   */
  public function detail(string $orderRef);
}
