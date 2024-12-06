<?php

namespace Tests\Data\Admin;

class ProductPage
{
    public const Product_Top = [
        'login_url'      => '/Admin/products',
        'create_product' => '#product-app > div > div > div.d-flex.justify-content-between.my-4 > a > button',
        'edit_product'   => '#product-app > div > div > div.table-push > table > tbody > tr:nth-child(2) > td.text-end > a.btn.btn-outline-secondary.btn-sm',
        'del_product'    => '#product-app > div > div > div.table-push > table > tbody > tr:nth-child(2) > td.text-end > a.btn.btn-outline-danger.btn-sm',
        'sure_btn'       => '确定',
        'get_name'       => '#product-app > div > div > div.table-push > table > tbody > tr:nth-child(2) > td:nth-child(4) > a',
    ];

    public const Product_Left = [
        'product_mg'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(1)',
        'product_cate'    => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(2)',
        'product_brand'   => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(3)',
        'attribute_group' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(4)',
        'attribute'       => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(5)',
        'advanced_filter' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(5)',
        'Recy_station'    => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(7)',
    ];

    public const Cre_class = [
        'cre_cate_btn'  => '#category-app > div > a',
        'edit_cate_btn' => '.btn.btn-outline-secondary.btn-sm',
        'del_cate_btn'  => '.btn.btn-outline-danger.btn-sm',
        'del_cate_text' => '#category-app > div > div > div > div:nth-child(1) > div > div > div:nth-child(1) > span',
        'sure_del_btn'  => '.el-button.el-button--default.el-button--small.el-button--primary ',
    ];

    public const Cre_brand = [
        'cre_brand_btn'      => '#customer-app > div.card-body > div.d-flex.justify-content-between.mb-4 > button',
        'edit_brand_btn'     => '#customer-app > div.card-body > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(7) > button.btn.btn-outline-secondary.btn-sm',
        'del_brand_btn'      => '#customer-app > div.card-body > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(7) > button.btn.btn-outline-danger.btn-sm.ml-1',
        'brand_name'         => '#customer-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div:nth-child(1) > div > div > input',
        'brand_img'          => '.bi.bi-plus.fs-1.text-muted',
        'brand_first_letter' => '#customer-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div:nth-child(3) > div > div > input',
        'save_btn'           => '#customer-app > div.el-dialog__wrapper > div > div.el-dialog__body > form > div:nth-child(6) > div > button.el-button.el-button--primary',
        'del_sure_btn'       => '.el-button.el-button--default.el-button--small.el-button--primary ',
    ];

    public const Mg_Images = [

        'first_img'    => '#filemanager-wrap-app > div.filemanager-content > div.content-center > div:nth-child(2)',
        'choose_btn'   => '#filemanager-wrap-app > div.filemanager-content > div.content-head > div.left.d-lg-flex > button',
    ];

    public const Assert = [
        'cre_ful_assert'   => '创建成功!',
        'alter_ful_assert' => '更新成功!',
        'del_ful_assert'   => '删除成功!',

    ];
}
