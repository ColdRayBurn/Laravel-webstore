<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-07-13 15:17:04
 * @modified   2023-07-13 15:17:04
 */

namespace Tests\Browser\Pages\Combine;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\ProductPage;
use Tests\DuskTestCase;


class DelCategoriesTest extends DuskTestCase
{
    public function testDelCategories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['mg_product'])

                ->click(ProductPage::Product_Left['product_cate'])
                ->pause(5000);

            $cata_name  = $browser->text(ProductPage::Cre_class['del_cate_text']);
            echo $cata_name;

            $browser->press(ProductPage::Cre_class['del_cate_btn'])
                ->press(ProductPage::Cre_class['sure_del_btn'])
                ->pause(2000)
                ->assertDontSee($cata_name);

        });
    }
}
