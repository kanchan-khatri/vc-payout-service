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
        'transaction_limit' => env('PAYOUT_TRANSACTION_LIMIT', 100)
    ]
];
