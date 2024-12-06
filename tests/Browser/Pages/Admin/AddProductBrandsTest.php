<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-07-04 15:01:04
 * @modified   2023-07-04 15:01:04
 */

namespace Tests\Browser\Pages\Admin;

use Laravel\Dusk\Browser;
use Tests\Data\Admin\AdminLoginPage;
use Tests\Data\Admin\AdminPage;
use Tests\Data\Admin\CreBrandsData;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\ProductPage;
use Tests\DuskTestCase;

class AddProductBrandsTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     * @return void
     */


    public function testAddProductBrands()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])

                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)

                ->click(AdminPage::TOP['mg_product'])

                ->click(ProductPage::Product_Left['product_brand'])

                ->press(ProductPage::Cre_brand['cre_brand_btn'])

                ->type(ProductPage::Cre_brand['brand_name'], CreBrandsData::Brands_Info['brand_name'])

                ->press(ProductPage::Cre_brand['brand_img'])
                ->pause(6000)

                ->withinFrame('#layui-layer-iframe1', function ($brower) {
                    $brower->click(ProductPage::Mg_Images['first_img'])
                        ->press(ProductPage::Mg_Images['choose_btn']);
                })
                ->driver->switchTo()->defaultContent();
            $browser->pause(2000)
                ->type(ProductPage::Cre_brand['brand_first_letter'], CreBrandsData::Brands_Info['brand_first_letter'])

                ->press(ProductPage::Cre_brand['save_btn'])
                ->pause(3000)
                ->assertSee(CreBrandsData::Brands_Info['brand_name']);
        });
    }
}
