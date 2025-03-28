<?php

namespace Koderpedia\LaravelBayarkan\Abstract\Tripay;

interface Transactions
{
  /**
   * Creating tripay transaction
   * 
   * @return mixed Callback signature after creating order
   */
  public function create(array $payload): array;

  /**
   * Get tripay transaction detail
   * 
   * @return mixed
   */
  public function detail(): array;
}
