<?php

namespace Tests\Data\Admin;

class CreProduct
{
    public const Puoduct_Info = [
        'ch_name'      => 'test',
        'en_name'      => 'test',
        'sku'          => '123',
        'price'        => '500',
        'origin_price' => '50',
        'cost_price'   => '5',
        'quantity'     => '3',
    ];

    public const Alter = [
        'ch_name'      => 'alter_test',
        'en_name'      => 'alter_test',
        'sku'          => '456',
        'price'        => '5000',
        'origin_price' => '500',
        'cost_price'   => '50',
        'quantity'     => '30',
        'low_quantity' => '5',
    ];
}
