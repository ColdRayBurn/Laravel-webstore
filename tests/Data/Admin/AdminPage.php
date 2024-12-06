<?php

namespace Tests\Data\Admin;

class AdminPage
{
    public const TOP = [
        'login_url'                 => '/admin',
        'root'                      => '.ml-2',
        'mg_index'                  => '.list-unstyled.navbar-nav li:nth-child(1)',
        'mg_order'                  => '.list-unstyled.navbar-nav li:nth-child(2)',
        'mg_product'                => '.list-unstyled.navbar-nav li:nth-child(3)',
        'mg_customers'              => '.list-unstyled.navbar-nav li:nth-child(4)',
        'mg_article'                => '.list-unstyled.navbar-nav li:nth-child(5)',
        'mg_report'                 => '.list-unstyled.navbar-nav li:nth-child(6)',
        'mg_design'                 => '.list-unstyled.navbar-nav li:nth-child(7)',
        'mg_plugin'                 => '.list-unstyled.navbar-nav li:nth-child(8)',
        'system_set'                => '.list-unstyled.navbar-nav li:nth-child(9)',
        'go_catalog'                => '.dropdown-menu.dropdown-menu-end.show li:nth-child(1)',
        'personal_center'           => '.dropdown-menu.dropdown-menu-end.show li:nth-child(2)',
        'sign_out'                  => '.dropdown-menu.dropdown-menu-end.show li:nth-child(4)',
        'Alter'                     => '.navbar.navbar-right li:nth-child(1)',
        'buy_copyright'             => '.navbar.navbar-right li:nth-child(3)',
        'plugins_market'            => '.navbar.navbar-right li:nth-child(4)',
        'sw_language'               => '.navbar.navbar-right li:nth-child(5)',
        //'sw_language'     => '.navbar.navbar-right li:nth-child(5)', //
        'en_language'     => '.dropdown-menu.dropdown-menu-end.show li:nth-child(2)',
        'ch_language'     => '.dropdown-menu.dropdown-menu-end.show li:nth-child(10)',
    ];

    public const Assert = [
        'vip_assert'     => 'License',
        'plugins_assert' => '/admin/marketing',
        'en_assert'      => 'Admin Panel',
        'ch_assert'      => '后台管理',
    ];
}
