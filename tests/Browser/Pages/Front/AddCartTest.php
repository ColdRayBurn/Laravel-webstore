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
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;


class AddCartTest extends DuskTestCase
{
    public function testAddCart()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(5000)

                ->click(AccountPage::Account['go_index'])

                ->scrollIntoView(IndexPage::Index['product_img'])

                ->pause(2000)

                ->press(IndexPage::Index['product_img'])
                ->pause(2000);


            $product_description = $browser->text(ProductOne::Product['product1_name']);
            $ProductUrl          = $browser->driver->getCurrentURL();

            $browser->visit($ProductUrl)

                ->press(ProductOne::Product['add_cart'])
                ->pause(3000)

                ->click(IndexPage::Index_Cart['cart_icon'])
                ->pause(10000);

            $browser->assertSeeIn(IndexPage::Index_Cart['product_text'], $product_description);
        });
    }
}
