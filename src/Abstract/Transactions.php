<?php

namespace Koderpedia\LaravelBayarkan\Abstract;

interface Transactions
{
  /**
   * Define payment order id
   * @param string $orderId
   * @return
   */
  public function setOrderId(string $orderId);

  /**
   * Define payment type or order
   * 
   * @param string $type
   * @return
   */
  public function setPaymentType(string $type);

  /**
   * Define purchase item
   * 
   * @param mixed $items
   */
  public function setItems(array $items);

  /**
   * Define customer detail for payment
   */
  public function setCustomerDetail(array $customer);

  /**
   * Generate payment invoice
   */
  public function createTransaction(): array;
}
