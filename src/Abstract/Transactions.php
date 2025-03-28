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
   * Define expired time for invoice
   * 
   * @param string|int $time Expired time
   */
  public function setExpiredTime(string|int $time);

  /**
   * Generate payment invoice
   * @return mixed
   */
  public function createTransaction(): array;

  /**
   * Get transaction detail
   * 
   * @param string $orderRef Transaction order ID / reference id
   * @return mixed
   */
  public function detailTransaction(string $orderRef): array;
}
