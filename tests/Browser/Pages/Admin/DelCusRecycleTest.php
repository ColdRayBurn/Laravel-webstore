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

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\CustomerPage;
use Tests\Data\Admin\LoginData;
use Tests\DuskTestCase;

class DelCusRecycleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */



    public function testDelCusRecycle()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                ->click(AdminPage::TOP['mg_customers'])

                ->press(CustomerPage::Group_list['del_customer'])
                ->press(CustomerPage::Group_list['sure_btn'])
                ->pause(1000)

                ->click(CustomerPage::Left['re_station']);
            $customer_text = $browser->text(CustomerPage::Empty_Recycle['customer_text']);
            echo $customer_text;

            $browser->press(CustomerPage::Empty_Recycle['recycle_del'])
                ->pause(2000)
                ->press(CustomerPage::Empty_Recycle['sure_btn'])

                ->assertSee($customer_text)
                ->pause(5000);
        });
    }
}
