<?php

return [
  /*
  |--------------------------------------------------------------------------
  | TRIPAY MODE
  |--------------------------------------------------------------------------
  |
  | Use tripay development mode by default, but variable can be change to `true`
  | if you want to go production.
  */
  'tripay_api_production' => env('TRIPAY_API_PRODUCTION', false),
  /*
  |--------------------------------------------------------------------------
  | TRIPAY API KEY
  |--------------------------------------------------------------------------
  |
  | Tripay api key configuration
  */
  'tripay_api_key' => env('TRIPAY_API_KEY', ""),
  /*
  |--------------------------------------------------------------------------
  | TRIPAY PRIVATE KEY
  |--------------------------------------------------------------------------
  |
  | Tripay private key configuration
  */
  'tripay_private_key' => env('TRIPAY_PRIVATE_KEY', ""),
  /*
  |--------------------------------------------------------------------------
  | TRIPAY MERCHANT CODE
  |--------------------------------------------------------------------------
  |
  | Tripay merchant configuration
  */
  'tripay_merchant_code' => env('TRIPAY_MERCHANT_CODE', ""),
  /*
  |--------------------------------------------------------------------------
  | TRIPAY RETURN URL
  |--------------------------------------------------------------------------
  |
  | Redirect URL after creating invoice
  */
  'tripay_return_url' => env('TRIPAY_RETURN_URL', "http://localhost:8000"),
  /*
  |--------------------------------------------------------------------------
  | TRIPAY NOTIFICATION URL
  |--------------------------------------------------------------------------
  |
  | Notification URL if transaction status is change from tripay.
  | Note: endpoint must be a post method
  */
  'tripay_notification_url' => env('TRIPAY_NOTIFICATION_URL', "http://localhost:8000/api/callback/tripay"),
];
