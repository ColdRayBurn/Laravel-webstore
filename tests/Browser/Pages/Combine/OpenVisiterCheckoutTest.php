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

namespace Tests\Browser\Pages\Combine;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\SystemSetPage;
use Tests\Data\Catalog\CheckoutPage;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;

//
class OpenVisiterCheckoutTest extends DuskTestCase
{
    public function testCancelOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])
                //1.
                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                //
                ->click(AdminPage::TOP['system_set'])
                //
                ->click(SystemSetPage::System_Set['pay_set'])
                ->pause(2000)
                //
                ->press(SystemSetPage::System_Set['open_visitor_checkout'])
                //
                ->press(SystemSetPage::Common['save_btn'])
                ->pause(2000)
        //
                ->click(AdminPage::TOP['root'])
                ->pause(3000)
                ->click(AdminPage::TOP['go_catalog'])
                ->pause(2000)
                //
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
            //
            $browser->pause(2000)
            //
                ->scrollIntoView(IndexPage::Index['product_img'])
                ->pause(2000)
            //
                ->press(IndexPage::Index['product_img'])
            //
                ->press(ProductOne::Product['product_1'])
                ->pause(5000)
        //：
                ->assertPathIs(CheckoutPage::Checkout['url']);

        });
    }
}
