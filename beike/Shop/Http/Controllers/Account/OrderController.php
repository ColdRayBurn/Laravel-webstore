<?php
/**
 * OrderController.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-07-05 10:29:07
 * @modified   2022-07-05 10:29:07
 */

namespace Beike\Shop\Http\Controllers\Account;

use Beike\Repositories\OrderRepo;
use Beike\Services\StateMachineService;
use Beike\Shop\Http\Controllers\Controller;
use Beike\Shop\Http\Resources\Account\OrderSimpleList;
use Beike\Shop\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     *
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filters = [
            'customer' => current_customer(),
            'status'   => $request->get('status'),
        ];
        $orders = OrderRepo::filterOrders($filters);
        $data   = [
            'orders' => OrderSimpleList::collection($orders),
        ];

        return view('account/order', $data);
    }

    /**
     *
     *
     * @param Request $request
     * @param         $number
     * @return View
     */
    public function show(Request $request, $number): View
    {
        $customer = current_customer();
        $order    = OrderRepo::getOrderByNumber($number, $customer);
        $data     = hook_filter('account.order.show.data', ['order' => $order, 'html_items' => []]);

        return view('account/order_info', $data);
    }

    /**
     *
     *
     * @param Request $request
     * @param         $number
     * @return mixed
     * @throws \Exception
     */
    public function pay(Request $request, $number)
    {
        try {
            $customer = current_customer();
            $order    = OrderRepo::getOrderByNumber($number, $customer);
            hook_action('account.order.pay.before', ['order' => $order]);

            return (new PaymentService($order))->pay();
        } catch (\Exception $e) {
            return redirect(shop_route('account.order.show', $number))->withErrors($e->getMessage());
        }
    }

    /**
     *
     *
     * @param Request $request
     * @param         $number
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function complete(Request $request, $number)
    {
        $customer = current_customer();
        $order    = OrderRepo::getOrderByNumber($number, $customer);
        if (empty($order)) {
            throw new \Exception(trans('shop/order.invalid_order'));
        }
        $comment = trans('shop/order.confirm_order');
        StateMachineService::getInstance($order)->changeStatus(StateMachineService::COMPLETED, $comment);

        return json_success(trans('shop/account/order.completed'));
    }

    /**
     *
     *
     * @param Request $request
     * @param         $number
     * @return array
     * @throws \Exception
     */
    public function cancel(Request $request, $number)
    {
        $customer = current_customer();
        $order    = OrderRepo::getOrderByNumber($number, $customer);
        if (empty($order)) {
            throw new \Exception(trans('shop/order.invalid_order'));
        }
        $comment = trans('shop/order.cancel_order');
        StateMachineService::getInstance($order)->changeStatus(StateMachineService::CANCELLED, $comment);

        return json_success(trans('shop/account/order.cancelled'));
    }
}
