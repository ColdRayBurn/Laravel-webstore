<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-08-17 14:37:04
 * @modified   2023-08-17 15:47:04
 */

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\ArticlePage;
use Tests\Data\Admin\LoginData;
use Tests\DuskTestCase;

class DelArticleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */
    public function testDelArticle()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['mg_article'])

                ->press(ArticlePage::Left['mg_article']);

            $artice_title = $browser->text(ArticlePage::Common['artice_title_Text']);
            echo $artice_title;

            $browser->press(ArticlePage::Common['del_btn'])
                ->pause(3000)
                ->click(ArticlePage::Common['del_sure_btn'])
                ->pause(3000)
                ->assertDontSee($artice_title);

        });
    }
}
