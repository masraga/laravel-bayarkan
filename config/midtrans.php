<?php

return [
  /*
  |--------------------------------------------------------------------------
  | MIDTRANS MODE
  |--------------------------------------------------------------------------
  |
  | Use midtrans sandbox mode by default, but variable can be change to `true`
  | if you want to go production.
  */
  'midtrans_api_production' => env('MIDTRANS_API_PRODUCTION', false),
  /*
  |--------------------------------------------------------------------------
  | MIDTRANS CLIENT KEY
  |--------------------------------------------------------------------------
  |
  | Midtrans client key
  */
  'midtrans_client_key' => env('MIDTRANS_CLIENT_KEY', ''),
  /*
  |--------------------------------------------------------------------------
  | MIDTRANS SERVER KEY
  |--------------------------------------------------------------------------
  |
  | Midtrans server key
  */
  'midtrans_server_key' => env('MIDTRANS_SERVER_KEY', ''),
  /*
  |--------------------------------------------------------------------------
  | MIDTRANS MERCHANT CODE
  |--------------------------------------------------------------------------
  |
  | Midtrans merchant code
  */
  'midtrans_merchant_code' => env('MIDTRANS_MERCHANT_CODE', ''),
];
