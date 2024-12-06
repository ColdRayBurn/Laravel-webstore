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
use Tests\Data\Admin\CreProduct;
use Tests\Data\Admin\CreProductPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\ProductPage;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;

////
class UnderstockOrderTest extends DuskTestCase
{
    public function testUnderstockOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])
                //1.
                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
            //5
                ->click(AdminPage::TOP['mg_product']);
            //
            $product1_text = $browser->text(ProductPage::Product_Top['get_name']);
            echo $product1_text;
            //
            $browser->press(ProductPage::Product_Top['edit_product'])
                ->scrollIntoView(CreProductPage::Product_Top['Enable'])
                ->pause(2000)
            //
                ->click(CreProductPage::Product_Top['Enable'])
            //5
                ->type(CreProductPage::Product_Top['quantity'], CreProduct::Alter['low_quantity'])
            //5.
                ->press(CreProductPage::Product_Top['save_btn'])
                ->pause(3000)

            //
                ->clickLink($product1_text)
                ->pause(2000)
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
            //
            $browser->pause(2000)
                ->type(ProductOne::Product['quantity'], CreProduct::Alter['low_quantity'])
            //+1  quantity_up
                ->click(ProductOne::Product['quantity_up'])
            //4.
                ->press(ProductOne::Product['product_1'])
                ->pause(2000)
            // understock_assert
                ->assertVisible(ProductOne::Product['understock_assert']);

        });
    }
}
