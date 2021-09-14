<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Constants
    |--------------------------------------------------------------------------
    |
    | Here you may configure your application specific constants that will define the functioning
    | of various business logic of this applicaion.
    */

    'payout' => [
        'default_transaction_max_amount' => env('TRANSACTION_MAX_AMOUNT', 100),
        'supported_currencies' => ['EUR', 'GBP', 'USD', 'eur', 'gbp', 'usd']
    ]
];
