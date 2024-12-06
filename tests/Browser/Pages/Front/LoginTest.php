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
use Tests\Data\Catalog\LoginPage;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */


    public function testEmailIllegal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                ->type(LoginPage::Login['login_email'], CataLoginData::False_Login['illegal_email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->assertSee(CataLoginData::False_Login['illegal_assert']);
        });
    }


    public function testEmailFalse()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                ->type(LoginPage::Login['login_email'], CataLoginData::False_Login['false_email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->assertSee(CataLoginData::False_Login['false_assert']);
        });
    }


    public function testPwdFalse()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::False_Login['false_password'])
                ->press(LoginPage::Login['login_btn'])
                ->assertSee(CataLoginData::False_Login['false_assert']);
        });
    }


    public function testOnlyEmail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->press(LoginPage::Login['login_btn'])
                ->assertSee(CataLoginData::False_Login['false_assert']);
        });
    }


    public function testOnlyPwd()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['email'])
                ->press(LoginPage::Login['login_btn'])
                ->assertSee(CataLoginData::False_Login['false_assert']);
        });
    }


    public function testLoginFul()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])

                ->pause(5000)
                ->assertPathIs(AccountPage::Account['url']);
        });
    }
}
