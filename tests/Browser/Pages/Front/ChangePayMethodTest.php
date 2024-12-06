<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-06-06 17:17:04
 * @modified   2023-06-06 17:17:04
 */

namespace Tests\Browser\Pages\Front;

use Laravel\Dusk\Browser;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\CataLoginData;
use Tests\Data\Catalog\CheckoutPage;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;


class ChangePayMethodTest extends DuskTestCase
{
    public function testChangePayMethod()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(5000)

                ->assertPathIs(AccountPage::Account['url'])

                ->click(AccountPage::Account['go_index'])

                ->scrollIntoView(IndexPage::Index['product_img'])
                ->pause(2000)

                ->press(IndexPage::Index['product_img'])

                ->press(ProductOne::Product['product_1'])
                ->pause(5000)
//
                ->elements(CheckoutPage::Checkout['method_pay'])[1]->click();
            $browser->pause(5000)
            //5.
                ->press(CheckoutPage::Checkout['submit'])
                ->pause(5000)
             //6.
                ->assertSee(CheckoutPage::Checkout['assert']);
        });
    }
}
