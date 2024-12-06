<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-10-24 10:17:04
 * @modified   2023-06-06 10:17:04
 */

namespace Tests\Browser\Pages\Combine;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminOrderPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\CataLoginData;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\RmasData;
use Tests\Data\Catalog\RmasPage;
use Tests\DuskTestCase;


class OrderRmaTest extends DuskTestCase
{
    public function testOrderRma()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                ->click(AdminPage::TOP['root'])
                ->pause(3000)
                ->click(AdminPage::TOP['go_catalog'])
                ->pause(2000)

                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);


            $browser->click(IndexPage::Index_Login['login_icon'])
                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(5000)
                ->click(AccountPage::Account['go_order'])

                ->click(AccountPage::Account['go_order'])
                ->click(AccountPage::Order['check_btn'])
            //
                ->click(AccountPage::Order['rma-btn'])
            //
                ->type(RmasPage::Rmas['Remark'], RmasData::Rmas['Remark_text'])
                ->press(RmasPage::Rmas['Submit'])
            //,
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[0]);
            //
            $browser->click(AdminPage::TOP['mg_order'])
                ->press(AdminOrderPage::Child['mg_sale_after'])
                ->pause(3000)
            //-
                ->click(AdminOrderPage::Rams['Check_btn'])
                ->click(AdminOrderPage::Rams['Pull_btn'])
                ->click(AdminOrderPage::Rams['Completed'])
                ->press(AdminOrderPage::Rams['Update_btn'])
                ->pause(10000)
            //
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
            $browser->pause(3000)
                ->click(RmasPage::Rmas['Checkout-btn'])
            //
                ->assertSee(RmasData::Rmas['Asser_text']);

        });
    }
}
