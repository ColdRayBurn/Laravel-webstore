<?php

namespace Tests\Data\Admin;

class AdminOrderPage
{
    public const Right = [
        'url'          => '/Admin/orders',
        'search_order' => '#orders-app > div > div.bg-light.p-4.mb-3 > form > div:nth-child(1) > div:nth-child(1) > div > div > input',
        'search_bth'   => '#orders-app > div > div.bg-light.p-4.mb-3 > div > div > button:nth-child(1)',
        'view_btn'     => '#orders-app > div > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(10) > a',
    ];

    public const Child = [
        'mg_order'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(1)',
        'mg_sale_after' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(2)',
        'ca_sale_after' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(3)',
        'add_rma_btn'   => '#tax-classes-app > div.card-body.h-min-600 > div > button',
        'zh_name'       => '#tax-classes-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div.el-form-item.language-inputs.is-required > div > div:nth-child(1) > div > div > input',
        'en_name'       => '#tax-classes-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div.el-form-item.language-inputs.is-required > div > div:nth-child(2) > div > div > input',
        'save_btn'      => '#tax-classes-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div.el-form-item.mt-5 > div > button.el-button.el-button--primary > span',
    ];

    public const Details = [
        'pull_btn' => '#app > form > div.el-form-item.is-required > div > div > div > span > span > i',

        'paid'        => '.el-scrollbar__view.el-select-dropdown__list li:nth-child(1)',
        'cancel'      => '.el-scrollbar__view.el-select-dropdown__list li:nth-child(2)',
        'alter_btn'   => '.el-button.el-button--primary',
        'Shipped'     => '.el-scrollbar__view.el-select-dropdown__list li:nth-of-type(2)',
        'express_btn' => '#app > form > div:nth-child(3) > div > div > div > span > span > i',
        'Completed'   => '.el-scrollbar__view.el-select-dropdown__list li:nth-child(1)',

        'express_1'    => '.el-scrollbar__view.el-select-dropdown__list',
        'order_number' => '#app > form > div:nth-child(4) > div > div > input',
        'submit'       => '#app > form > div:nth-child(7) > div > button',
        'submit_btn2'  => '#app > form > div:nth-child(5) > div > button',
        //#app > form > div:nth-child(5) > div > button

    ];

    public const Rams = [
        'Check_btn'  => '#customer-app > div > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(9) > a',
        'Pull_btn'   => '#app > form > div.el-form-item.is-required > div > div > div > span > span',
        'Completed'  => '.el-scrollbar__view.el-select-dropdown__list li:nth-child(5)',
        'Update_btn' => '#app > form > div:nth-child(4) > div > button',

    ];
}
