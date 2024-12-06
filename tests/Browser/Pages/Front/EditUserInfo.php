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
use Tests\Data\Catalog\AccountData;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\RegisterData;
use Tests\DuskTestCase;


class EditUserInfo extends DuskTestCase
{
    public function testEditInfo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], RegisterData::True_Register['email'])
                ->type(LoginPage::Login['login_pwd'], RegisterData::True_Register['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(2000)

                ->click(AccountPage::Account['go_Edit'])
                ->pause(1000)

//                ->press(AccountPage::Edit['upload_btn'])
//                ->pause(3000)



//                ->attach(AccountPage::Edit['upload_btn'],realpath('.tests/Browser/dusktest/data/Images/Headpicture/Headpicture.jpeg'))
//                ->press(AccountPage::Edit['Confirm_btn'])
//                ->pause(3000)
                //3.1  name
                ->type(AccountPage::Edit['user_name'], AccountData::User_Edit['user_name'])
                //3.2 phone
                ->type(AccountPage::Edit['user_email'], AccountData::User_Edit['user_email'])
                //3.3 save
                ->press((AccountPage::Edit['Submit']))
                ->pause(3000)
                ->assertSee(AccountPage::Edit['assert']);


        });
    }
}
