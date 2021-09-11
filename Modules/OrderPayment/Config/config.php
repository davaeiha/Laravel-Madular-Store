<?php

return [
    'name' => 'OrderPayment',

    'payping'=>[
        'token' =>env('PAYPING_TOKEN'),
    ],

    'kavenegar'=>[
        'api_key'=>env('KAVENEGAR_SMS_API_KEY'),
    ]
];

