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
use Tests\Data\Admin\CreProduct;
use Tests\Data\Admin\CreProductPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\ProductPage;
use Tests\DuskTestCase;

class EditProductTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */


    public function testEditProduct()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['mg_product'])

                ->press(ProductPage::Product_Top['edit_product'])

                ->type(CreProductPage::Product_Top['ch_name'], CreProduct::Puoduct_Info['ch_name'])
                ->type(CreProductPage::Product_Top['en_name'], CreProduct::Puoduct_Info['en_name'])
                ->type(CreProductPage::Product_Top['sku'], CreProduct::Puoduct_Info['sku'])
                ->type(CreProductPage::Product_Top['price'], CreProduct::Puoduct_Info['price'])
                ->type(CreProductPage::Product_Top['origin_price'], CreProduct::Puoduct_Info['origin_price'])
                ->type(CreProductPage::Product_Top['cost_price'], CreProduct::Puoduct_Info['cost_price'])
                ->type(CreProductPage::Product_Top['quantity'], CreProduct::Puoduct_Info['quantity'])

                ->press(CreProductPage::Product_Top['save_btn'])
                ->pause(3000)
                ->assertSee(ProductPage::Assert['alter_ful_assert']);
        });
    }
}
