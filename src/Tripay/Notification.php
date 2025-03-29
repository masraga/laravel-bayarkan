<?php

namespace Koderpedia\LaravelBayarkan\Tripay;

class Notification
{

  public $response;

  public function __construct($response = "php://input")
  {
    $this->response = json_decode(file_get_contents($response), true);
  }

  public function __get($name)
  {
    if ($this->response[$name]) {
      return $this->response[$name];
    }
  }
}
