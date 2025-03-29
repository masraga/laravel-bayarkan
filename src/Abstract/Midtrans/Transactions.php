<?php

namespace Koderpedia\LaravelBayarkan\Abstract\Midtrans;

interface Transactions
{
  /**
   * Charging transaction and get unpaid invoice
   * 
   * @param mixed $payload Payload from Midtrans instance
   * @return mixed
   */
  public function create(array $payload): array;
}
