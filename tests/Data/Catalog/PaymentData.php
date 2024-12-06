<?php

namespace Tests\Data\Catalog;

class PaymentData
{
    public const Payment_Paypal = [

        'Paypal_Email' => 'test acount',
        'Paypal_Pwd'   => 'W123456',

    ];

    public const Payment_Stripe = [

        'Cardholder_Name' => 'licy',
        'Card_Number'     => '4242424242424242',
        'Expiration_Date' => '1230',
        'CVV'             => '123',

    ];
}
