<?php

namespace Tests\Data\Admin;

class DesignPage
{
    public const Article_Left = [
        'url'           => '/Admin/themes',
        'temp_set'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(1)',
        'navigate_set'  => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(2)',
        'home_decorate' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(3)',
        'end_decorate'  => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(4)',
    ];

    public const Article_Common = [
        'add_btn'  => '#content > div.container-fluid.p-0 > div > div > div.d-flex.justify-content-between.mb-4 > a',
        'edit_btn' => '#content > div.container-fluid.p-0 > div > div > div.table-push > table > tbody > tr:nth-child(1) > td.text-end > a',
        'del_btn'  => '#content > div.container-fluid.p-0 > div > div > div.table-push > table > tbody > tr:nth-child(1) > td.text-end > button',

    ];
}
