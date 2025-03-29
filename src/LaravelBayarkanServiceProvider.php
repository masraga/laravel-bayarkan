<?php

namespace Koderpedia\LaravelBayarkan;

use Illuminate\Support\ServiceProvider;

class LaravelBayarkanServiceProvider extends ServiceProvider
{
  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->publishes([
        __DIR__ . "/../config/tripay.php" => config_path("tripay.php"),
        __DIR__ . "/../config/midtrans.php" => config_path("midtrans.php"),
      ], "config");;
    }
  }

  public function register()
  {
    $this->mergeConfigFrom(__DIR__ . "/../config/tripay.php", 'tripay');
    $this->mergeConfigFrom(__DIR__ . "/../config/midtrans.php", 'midtrans');
  }
}
