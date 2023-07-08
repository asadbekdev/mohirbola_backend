<?php

return [
    'payme' => [
        'key' => 'parent_id',
        'login' => env('PAYME_MERCHANT_ID', ''),
        'password' => env('PAYME_SECRET', '')
    ]
];
