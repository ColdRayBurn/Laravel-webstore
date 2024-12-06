<?php

namespace Tests\Data\Catalog;

class CategoriesPage
{
    public const Categories = [
        'sort_button' => '.form-select.order-select.ms-2',

        'asc_name'      => '.form-select.order-select.ms-2 option:nth-child(4)',
        'desc_name'     => '.form-select.order-select.ms-2 option:nth-child(5)',
        'asc_price'     => '.form-select.order-select.ms-2 option:nth-child(6)',
        'desc_price'    => '.form-select.order-select.ms-2 option:nth-child(7)',
        'product_name'  => '.product-name',
        'product_price' => '.price-new',
    ];
}
