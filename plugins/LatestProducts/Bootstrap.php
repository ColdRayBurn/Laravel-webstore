<?php
/**
 * bootstrap.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-20 15:35:59
 * @modified   2022-07-20 15:35:59
 */

namespace Plugin\LatestProducts;

class Bootstrap
{
    /**
     *
     */
    public function boot()
    {
        $this->addLatestProducts();

        // $this->modifyHeader();
        // $this->modifyProductDetail();

        // $this->modifyAdminProductEdit();
        // $this->modifySetting();
        // $this->handlePaidOrder();
    }

    /**
     *
     */
    private function addLatestProducts()
    {
        add_hook_filter('menu.content', function ($data) {
            $data[] = [
                'name' => trans('LatestProducts::header.latest_products'),
                'link' => shop_route('latest_products'),
            ];

            return $data;
        }, 0);
    }

    /**
     *  header
     */
    private function modifyHeader()
    {
        add_hook_blade('header.top.currency', function ($callback, $output, $data) {
            return '货币前' . $output;
        });

        add_hook_blade('header.top.language', function ($callback, $output, $data) {
            return $output . '语言后';
        });

        add_hook_blade('header.top.telephone', function ($callback, $output, $data) {
            return '电话前' . $output;
        });

        add_hook_blade('header.menu.logo', function ($callback, $output, $data) {
            return $output . 'Logo后';
        });

        add_hook_blade('header.menu.icon', function ($callback, $output, $data) {
            $view = view('LatestProducts::shop.header_icon')->render();

            return $output . $view;
        });
    }

    /**
     *
     * 1.  hook
     * 2.  hook  Hot
     * 3.  hook
     * 4.  hook
     */
    private function modifyProductDetail()
    {

        add_hook_filter('product.show.data', function ($product) {
            $product['product']['name'] = '[疯狂热销]' . $product['product']['name'];

            return $product;
        });


        add_hook_blade('product.detail.name', function ($callback, $output, $data) {
            $badge = '<span class="badge" style="background-color: #FF4D00; color: #ffffff; border-color: #FF4D00">Hot</span>';

            return $badge . $output;
        });


        add_hook_blade('product.detail.brand', function ($callback, $output, $data) {
            return $output . '<div class="d-flex"><span class="title text-muted">Brand 2:</span>品牌 2</div>';
        });


        add_hook_blade('product.detail.buy.after', function ($callback, $output, $data) {
            $view = '<button class="btn btn-dark ms-3 fw-bold"><i class="bi bi-bag-fill me-1"></i>新增按钮</button>';

            return $output . $view;
        });
    }

    /**
     *
     */
    private function modifyAdminProductEdit()
    {
        add_hook_blade('admin.product.edit.extra', function ($callback, $output, $data) {
            $view = view('LatestProducts::admin.product.edit_extra_field', $data)->render();

            return $output . $view;
        }, 1);
    }

    /**
     *  tab
     */
    private function modifySetting()
    {
        add_hook_blade('admin.setting.nav.after', function ($callback, $output, $data) {
            return view('LatestProducts::admin.setting.nav')->render();
        });

        add_hook_blade('admin.setting.after', function ($callback, $output, $data) {
            return view('LatestProducts::admin.setting.tab')->render();
        });
    }

    /**
     *
     */
    private function handlePaidOrder()
    {
        add_hook_filter('service.state_machine.machines', function ($data) {
            $data['machines']['unpaid']['paid'][] = function () {

            };

            return $data;
        }, 0);
    }
}
