<?php

namespace Tests\Data\Admin;

class ArticlePage
{
    public const  Left = [
        'url'             => '/Admin/pages',
        'mg_article'      => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(1)',
        'catalog_article' => '.list-unstyled.navbar-nav:nth-child(2) li:nth-child(2)',
    ];

    public const Common = [
        'add_btn'            => '#content > div.container-fluid.p-0 > div.content-info > div > div > div.d-flex.justify-content-between.mb-4 > a',
        'edit_btn'           => '#content > div.container-fluid.p-0 > div.content-info > div > div > div.table-push > table > tbody > tr:nth-child(1) > td.text-end > a',
        'del_btn'            => '#content > div.container-fluid.p-0 > div.content-info > div > div > div.table-push > table > tbody > tr:nth-child(1) > td.text-end > button',
        'cata_title_Text'    => '#app > div > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(2) > div > a',
        'artice_title_Text'  => '#content > div.container-fluid.p-0 > div.content-info > div > div > div.table-push > table > tbody > tr:nth-child(1) > td:nth-child(2) > div > a',
        'save_btn'           => '#content > div.container-fluid.p-0 > div.page-bottom-btns > button.w-min-100.btn.btn-primary.submit-form.btn-lg',
        'sure_btn'           => '#layui-layer1 > div.layui-layer-btn.layui-layer-btn- > a.layui-layer-btn1',
        'del_sure_btn'       => '.layui-layer-btn1',

    ];

    public const Top = [
        'Cn'  => '#tab-content > ul > li:nth-child(1) > button',
        'En'  => '#tab-content > ul > li:nth-child(2) > button',
    ];

    public const Cn_info = [
        'title'    => '#tab-zh_cn > div:nth-child(1) > div > input',
        'summary'  => '#tab-zh_cn > div:nth-child(2) > div > div > textarea',
        'content'  => '#tinymce > p',

    ];

    public const En_info = [
        'title'    => '#tab-en > div:nth-child(1) > div > input',
        'summary'  => '#tab-en > div:nth-child(2) > div > div > textarea',
        'content'  => '#tinymce > p',

    ];
}
