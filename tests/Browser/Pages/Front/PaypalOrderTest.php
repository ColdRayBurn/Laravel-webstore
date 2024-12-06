<?php
/**
 * BrandController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     licy <licy@guangda.work>
 * @created    2023-07-20 17:17:04
 * @modified   2023-07-25 10:10:04
 */

namespace Tests\Browser\Pages\Front;

use Laravel\Dusk\Browser;
use Tests\Data\Catalog\AccountPage;
use Tests\Data\Catalog\CataLoginData;
use Tests\Data\Catalog\CheckoutPage;
use Tests\Data\Catalog\IndexPage;
use Tests\Data\Catalog\LoginPage;
use Tests\Data\Catalog\OrderPage;
use Tests\Data\Catalog\PaymentData;
use Tests\Data\Catalog\ProductOne;
use Tests\DuskTestCase;


class PaypalOrderTest extends DuskTestCase
{
    public function testPaypalOrder()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(LoginPage::Login['login_url'])

                ->type(LoginPage::Login['login_email'], CataLoginData::True_Login['email'])
                ->type(LoginPage::Login['login_pwd'], CataLoginData::True_Login['password'])
                ->press(LoginPage::Login['login_btn'])
                ->pause(5000)

                ->assertPathIs(AccountPage::Account['url'])

                ->click(AccountPage::Account['go_index'])

                ->scrollIntoView(IndexPage::Index['product_img'])
                ->pause(2000)

                ->press(IndexPage::Index['product_img'])

                ->press(ProductOne::Product['product_1'])
                ->pause(3000)

                ->press(CheckoutPage::Checkout['submit'])
                ->pause(5000)
                ->waitFor(OrderPage::Paypal_Plugin['Paypal_iframe'], 10)

                ->click(OrderPage::Paypal_Plugin['Paypal_iframe']);

            $popupWindowHandle = null;
            $mainWindowHandle  = $browser->driver->getWindowHandle();


            foreach ($browser->driver->getWindowHandles() as $windowHandle) {
                //
                $browser->driver->switchTo()->window($windowHandle);

                // ，、URL
                if (strpos($browser->driver->getTitle(), 'PayPal') !== false) {
                    $popupWindowHandle = $windowHandle;

                    break;
                }
            }

            //
            $browser->driver->switchTo()->window($mainWindowHandle);

            //
            if ($popupWindowHandle) {
                $browser->driver->switchTo()->window($popupWindowHandle);
                $currentUrl = $browser->driver->getCurrentURL();
                echo $currentUrl;
                $browser->waitFor(OrderPage::Paypal_Plugin['Paypal_foot'], 30000) //
                    ->scrollIntoView(OrderPage::Paypal_Plugin['Paypal_foot'])
                    ->pause(1000) //
                    ->clickLink(OrderPage::Paypal_Plugin['Paypal_Login'])//
                    ->type(OrderPage::Paypal_Plugin['Paypal_Email'], PaymentData::Payment_Paypal['Paypal_Email'])//
                    ->press(OrderPage::Paypal_Plugin['Next_Btn'])    //
                    ->pause(5000)
                    ->type(OrderPage::Paypal_Plugin['Paypal_Pwd'], PaymentData::Payment_Paypal['Paypal_Pwd'])//
                    ->press(OrderPage::Paypal_Plugin['Paypal_Login'])//
                    ->pause(5000)
                    ->click(OrderPage::Paypal_Plugin['Payment_Method'])//
                    ->press(OrderPage::Paypal_Plugin['Submit_Btn'])//
                    ->pause(5000);
            }

            //
            $browser->driver->switchTo()->window($mainWindowHandle);
            $browser->pause(5000)
                ->assertSeeIn(OrderPage::Get_Order_Status['status_text'], OrderPage::Order_Status['Paid']);

        });
    }
}
