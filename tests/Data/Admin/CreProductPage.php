<?php

namespace Tests\Data\Admin;

class CreProductPage
{
    public const Product_Top = [
        'login_url'    => '/Admin/products/create',
        'ch_name'      => 'descriptions[zh_cn][name]',
        'en_name'      => 'descriptions[en][name]',
        'sku'          => 'skus[0][sku]',
        'price'        => 'skus[0][price]',
        'origin_price' => 'skus[0][origin_price]',
        'cost_price'   => 'skus[0][cost_price]',
        'quantity'     => 'skus[0][quantity]',
        'Enable'       => '#active-1',
        'Disable'      => '#active-0',
        'save_btn'     => '#content > div.container-fluid.p-0 > div.page-bottom-btns > button.btn.w-min-100.btn-lg.btn-default.submit-form.ms-2',
    ];

    public const Product_Assert = [
        'Disable_text' => '.text-danger',
    ];
}
