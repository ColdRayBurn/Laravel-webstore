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
use Tests\Data\Admin\CustomerData;
use Tests\Data\Admin\CustomerPage;
use Tests\Data\Admin\LoginData;
use Tests\DuskTestCase;

class AddCustomerTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */
    public function testAddCustomer()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['mg_customers'])

                ->press(CustomerPage::Group_list['cre_customer'])

                ->type(CustomerPage::Create['name'], CustomerData::Customer_Info['name'])
                ->type(CustomerPage::Create['email'], CustomerData::Customer_Info['email'])
                ->type(CustomerPage::Create['pwd'], CustomerData::Customer_Info['pwd'])


                ->press(CustomerPage::Create['save_btn'])
                ->pause(5000)
                ->assertSee(CustomerData::Customer_Info['email']);

        });
    }
}
