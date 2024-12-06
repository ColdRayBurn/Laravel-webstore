<?php

namespace Tests\Data\Catalog;

class CheckoutPage
{
    public const Checkout = [
        'url'    => '/checkout',
        'submit' => '#submit-checkout',

        'assert' => 'Order placed successfully, please pay',

        'order_num'         => '.fw-bold',
        'product_price'     => '.price.text-end',
        'quantity'          => '.quantity',
        'product_total'     => '.totals li:nth-child(1) span:nth-child(2)',
        'shipping_fee'      => '.totals li:nth-child(2) span:nth-child(2)',
        'customer_discount' => '.totals li:nth-child(3) span:nth-child(2)',
        'order_total'       => '.totals li:nth-child(4) span:nth-child(2)',
        'view_order'        => '.table.table-borderless tbody tr:nth-of-type(2) td:nth-of-type(2) a',
        'method_pay'        => '.radio-line-item',

    ];
}
