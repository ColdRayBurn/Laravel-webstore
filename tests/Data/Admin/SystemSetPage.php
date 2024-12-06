<?php

namespace Tests\Data\Admin;

class SystemSetPage
{
    public const Common = [
        'save_btn' => '.btn.btn-lg.btn-primary.submit-form',
    ];

    public const System_Left = [
        'system_set'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(1)',
        'personal_center' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(2)',
        'admin_user'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(3)',
        'area_group'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(4)',
        'ta
    x_rate_set'           => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(5)',
        'tax_category'    => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(6)',
        'currency_mg'     => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(7)',
        'language_mg'     => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(8)',
        'state_mg'        => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(9)',
        'province_mg'     => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(10)',
    ];

    public const System_Set = [
        'basic_set'              => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(1)',
        'store_set'              => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(2)',
        'pay_set'                => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(3)',
        'images_set'             => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(4)',
        'express_set'            => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(5)',
        'advanced_filter'        => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(6)',
        'email_set'              => '.nav.nav-tabs.nav-bordered.mb-5 li:nth-child(7)',
        'close_visitor_checkout' => '#guest_checkout-0',
        'open_visitor_checkout'  => '#tab-checkout > div:nth-child(2) > div > div > div:nth-child(1)',
    ];

    public const System_Express

        = [
            'add_btn'         => '.bi.bi-plus-circle.cursor-pointer.fs-4',
            'express_company' => 'input[name="express_company[0][name]"]',
            'express_code'    => 'input[name="express_company[0][code]"]',
            'save_btn'        => '#content > div.container-fluid.p-0 > div.page-bottom-btns > button.btn.btn-lg.w-min-100.btn-primary.submit-form',

        ];

    public const Assert = [
        'assert_ful' => '更新成功!',
    ];
}
