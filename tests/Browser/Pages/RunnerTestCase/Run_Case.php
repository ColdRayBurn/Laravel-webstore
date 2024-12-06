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
require_once __DIR__ . '/../../../../vendor/autoload.php';

use PHPUnit\Framework\TestSuite;
use PHPUnit\TextUI\DefaultResultPrinter;

$suite = new TestSuite();


$suite->addTestFile('.\tests\Browser\Pages\front\RegisterFirst.php');
$suite->addTestFile('.\tests\Browser\Pages\front\RegisterTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\LoginTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\SignOutTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\AddressTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\AddCartTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\RemoveCartTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\RemoveWishlistTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\WishlistTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\AscPriceTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\DescPriceTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\AscNameTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\DescNameTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\EditUserInfo.php');
$suite->addTestFile('.\tests\Browser\Pages\front\CartCheckoutTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\ChangePayMethodTest.php');
$suite->addTestFile('.\tests\Browser\Pages\front\OrderTest.php');


$suite->addTestFile('.\tests\Browser\Pages\admin\AdminLoginTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AdminSignOutTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\GoCatalogTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\GopLuginsTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddProductTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelProductTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\EditProductTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\GoCopyrightAndServiceTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\LanguageSwitchTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddExpressTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddProductBrandsTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\EditProductBrandsTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelProductBrandsTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddArticleCataTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AlterArticleCataTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelArticleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddArticleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AlterArticleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelArticleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddRmaReasonsTest.php');

$suite->addTestFile('.\tests\Browser\Pages\combine\AlterOrderStationTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\OrderRmaTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\CancelOrderTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\CloseVisiterCheckoutTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\OpenVisiterCheckoutTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\DisableProductTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\EnableProductTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\UnderstockOrderTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\CustomerGroupDiscountTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\CreateCategoriesTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\AlterCategoriesTest.php');
$suite->addTestFile('.\tests\Browser\Pages\combine\DelCategoriesTest.php');


$suite->addTestFile('.\tests\Browser\Pages\admin\AddCustomerTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\EditCustomerTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelCustomerTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\AddCusGroupTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\EditCusGroupTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelCusGroupTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\CustomerRecycleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelCustomerTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\CusEmptyRecycleTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelCustomerTest.php');
$suite->addTestFile('.\tests\Browser\Pages\admin\DelCusRecycleTest.php');






$result = $suite->run();

$printer = new DefaultResultPrinter();

$printer->printResult($result);
