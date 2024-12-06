<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-10-11 11:17:04
 * @modified   2023-10-11 11:17:04
 */

namespace Tests\Browser\Pages\Front;

use Laravel\Dusk\Browser;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\CataLoginData;
use Tests\Data\Catalog\CategoriesPage;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\LoginPage;
use Tests\DuskTestCase;


class DescPriceTest extends DuskTestCase
{
    public function testAscName()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(5000)

                ->click(AccountPage::Account['go_index'])

                ->click(IndexPage::Index['top_Sports'])
                ->click(CategoriesPage::Categories['sort_button'])
                ->click(CategoriesPage::Categories['desc_price']);
            $product       = $browser->elements(CategoriesPage::Categories['product_price']);
            $product_1     = $product[1]->getText();
            $first_letter1 = substr($product_1, 1);
            $product_2     = $product[2]->getText();
            $first_letter2 = substr($product_2, 1);
            $product_3     = $product[3]->getText();
            $first_letter3 = substr($product_3, 1);

            echo $first_letter1;
            echo $first_letter2;
            echo $first_letter3;

            assert(ord($first_letter1) >= ord($first_letter2) && ord($first_letter2) >= ord($first_letter3), '变量未倒序排列');
            $browser->pause(10000);

        });
    }
}
