<?php
return [
    'ServerKey'     => env('MIDTRANS_SERVER_KEY'),
    'ClientKey'     => env('MIDTRANS_CLIENT_KEY'),
    'isProduction' => env('MIDTRANS_IS_PRODUCTION'),
    'isSanitized' => env('MIDTRANS_IS_SANITIZED'),
    'is3ds' => env('MIDTRANS_IS_3DS'),
];
