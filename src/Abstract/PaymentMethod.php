<?php

namespace Koderpedia\LaravelBayarkan\Abstract;

interface PaymentMethod
{
  /**
   * Create transaction order
   * 
   * @param mixed $payload Payload for creating payment
   * @return mixed
   */
  public function createTransaction(array $payload): array;
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
}
