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
use Tests\Data\Admin\AdminOrderPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\RmaData;
use Tests\DuskTestCase;

class AddRmaReasonsTest extends DuskTestCase
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

                ->click(AdminPage::TOP['mg_order'])

                ->press(AdminOrderPage::Child['ca_sale_after'])
                ->press(AdminOrderPage::Child['add_rma_btn'])
                ->pause(1000)

                ->type(AdminOrderPage::Child['zh_name'], RmaData::Zh_reason['titie'])
                ->type(AdminOrderPage::Child['en_name'], RmaData::En_reason['title'])


                ->press(AdminOrderPage::Child['save_btn'])
                ->pause(5000)
                ->assertSee(RmaData::Zh_reason['titie']);
        });
    }
}
