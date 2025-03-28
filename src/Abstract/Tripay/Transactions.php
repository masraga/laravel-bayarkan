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
   * @param  string $orderRef Reference order from tripay
   * @return mixed
   */
  public function detail(string $orderRef): array;
}
