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
use Tests\Data\Admin\CreCategories;
use Tests\Data\Admin\CreCategoriesPage;
use Tests\Data\Admin\LoginData;
use Tests\Data\Admin\ProductPage;
use Tests\Data\Catalog\IndexPage;
use Tests\DuskTestCase;

//
class CreateCategoriesTest extends DuskTestCase
{
    public function testCreateCategories()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(AdminLoginPage::Admin_Login['login_url'])
                //1.
                ->type(AdminLoginPage::Admin_Login['login_email'], LoginData::Ture_Data['email'])
                ->type(AdminLoginPage::Admin_Login['login_pwd'], LoginData::Ture_Data['password'])
                ->press(AdminLoginPage::Admin_Login['login_btn'])
                ->pause(2000)
                //
                ->click(AdminPage::TOP['mg_product'])
                //
                ->click(ProductPage::Product_Left['product_cate'])
                ->pause(5000)
                //
                ->press(ProductPage::Cre_class['cre_cate_btn'])
                //
                ->type(CreCategoriesPage::Cate_Page['ch_name'], CreCategories::Cate_Data['ch_name'])
                ->type(CreCategoriesPage::Cate_Page['en_name'], CreCategories::Cate_Data['en_name'])
                ->type(CreCategoriesPage::Cate_Page['ch_content'], CreCategories::Cate_Data['ch_content'])
                ->type(CreCategoriesPage::Cate_Page['en_content'], CreCategories::Cate_Data['en_content'])
                ->select(CreCategoriesPage::Cate_Page['parent_cate'], 2)
                ->type(CreCategoriesPage::Cate_Page['ch_title'], CreCategories::Cate_Data['ch_title'])
                ->type(CreCategoriesPage::Cate_Page['en_title'], CreCategories::Cate_Data['en_title'])
                ->type(CreCategoriesPage::Cate_Page['ch_keywords'], CreCategories::Cate_Data['ch_keywords'])
                ->type(CreCategoriesPage::Cate_Page['en_keywords'], CreCategories::Cate_Data['en_keywords'])
                ->type(CreCategoriesPage::Cate_Page['ch_description'], CreCategories::Cate_Data['ch_description'])
                ->type(CreCategoriesPage::Cate_Page['en_description'], CreCategories::Cate_Data['en_description'])
                //
                ->click(CreCategoriesPage::Cate_Page['status_enable'])
                //
                ->press(CreCategoriesPage::Cate_Page['save_btn'])
            //
                ->click(AdminPage::TOP['root'])
                ->pause(3000)
                ->click(AdminPage::TOP['go_catalog'])
                ->pause(2000)
                ->driver->switchTo()->window($browser->driver->getWindowHandles()[1]);
            $browser->click(IndexPage::Index['top_Sports'])
                ->pause(4000)
                ->assertSee(CreCategories::Cate_Data['ch_name']);

        });
    }
}
