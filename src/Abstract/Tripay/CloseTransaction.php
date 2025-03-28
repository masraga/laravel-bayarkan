<?php

namespace Koderpedia\LaravelBayarkan\Abstract\Tripay;

class CloseTransaction implements Transactions
{
  public function create(array $payload): array
  {
    return [];
  }

  public function detail(): array
  {
    return [];
  }
}
