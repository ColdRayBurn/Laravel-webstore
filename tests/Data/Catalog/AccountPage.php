<?php

namespace Tests\Data\Catalog;

class AccountPage
{
    public const Account = [
        'url'                 => '/account',
        'go_index'            => '.logo',
        'go_account'          => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(1)',
        'go_Edit'             => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(2)',
        'change_password'     => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(3)',
        'go_order'            => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(4)',
        'go_address'          => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(5)',
        'go_Wishlist'         => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(6)',
        'go_rma'              => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(8)',
        'SignOut'             => '.list-group-item.d-flex.justify-content-between.align-items-center:nth-child(8)',
    ];

    public const Address = [
        'login_url'    => '/account/addresses',
        'add_btn'      => '.btn.btn-dark.mb-3',

        'add_name'     => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(1) > div:nth-child(1) > div > div > input',
        'add_phone'    => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div.d-flex.dialog-address > div:nth-child(1) > div > div > input',
        'add_country'  => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(4) > div:nth-child(1) > div > div > div.el-input.el-input--suffix > span > span',
        'add_address'  => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div.d-flex.dialog-address > div.el-form-item.w-50.ms-3.is-required > div > div > input',
        'add_province' => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(4) > div.el-form-item.w-50.ms-3.is-required > div > div > div.el-input.el-input--suffix > span',
        'add_code'     => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(2) > div.el-form-item.w-50.ms-3 > div > div > input',

        'add_address1' => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(1) > div.el-form-item.w-50.ms-3.is-required > div > div > input',
        'add_address2' => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(2) > div:nth-child(1) > div > div > input',
        'default'      => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(5) > div > div > span',
        'save'         => '#address-app > div.address-dialog > div > div > div.el-dialog__body > form > div:nth-child(6) > div > button.el-button.el-button--primary',
        'assert'       => 'Default',

    ];

    public const Edit = [
        'login_url'   => '/account/edit',
        'upload_btn'  => '#address-app > div > div.col-12.col-md-9 > div > div.card-body.h-600 > form > div.bg-light.rounded-3.p-4.mb-4 > div > div > label',
        'Confirm_btn' => 'Confirm',
        'user_name'   => '#address-app > div > div.col-12.col-md-9 > div > div.card-body.h-600 > form > div.row.gx-4.gy-3 > div:nth-child(1) > input',
        'user_email'  => '#address-app > div > div.col-12.col-md-9 > div > div.card-body.h-600 > form > div.row.gx-4.gy-3 > div:nth-child(2) > input',
        'Submit'      => '.btn.btn-primary.mt-sm-0',
        'assert'      => 'Modify Success!',
    ];

    public const Order = [
        'check_btn' => '.btn.btn-outline-secondary.btn-sm',
        'rma-btn'   => '.btn.btn-outline-primary.btn-sm',
    ];

    public const Wishlist = [
        'login_url'       => '/account/edit',
        'go_Wishlist'     => 'Wishlist',
        'Check_Details'   => '.btn.btn-outline-secondary.btn-sm',
        'remove_Wishlist' => '.btn.btn-outline-danger.btn-sm.remove-wishlist',

        'no_data' => '.d-flex.flex-column.align-center.align-items-center.mb-4',

    ];
}
