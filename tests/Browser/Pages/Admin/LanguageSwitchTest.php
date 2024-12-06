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
use Tests\Data\Admin\LoginData;
use Tests\DuskTestCase;

class LanguageSwitchTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */
    public function testLanguageSwitch()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['sw_language'])

                ->click(AdminPage::TOP['en_language'])
                ->pause(4000)
                ->assertSee(AdminPage::Assert['en_assert'])

                ->click(AdminPage::TOP['sw_language'])
                ->click(AdminPage::TOP['ch_language'])
                ->assertSee(AdminPage::Assert['ch_assert']);
        });
    }
}
