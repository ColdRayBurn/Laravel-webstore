<?php
/**
 * StateMachineService.php
 *
 * @copyright  2022 beikeshop.com - All Rights Reserved
 * @link       https://beikeshop.com
 * @author     Edward Yang <yangjin@guangda.work>
 * @created    2022-08-08 18:21:47
 * @modified   2022-08-08 18:21:47
 */

namespace Beike\Services;

use Beike\Models\Order;
use Beike\Models\OrderHistory;
use Beike\Models\OrderShipment;
use Beike\Models\Product;
use Beike\Repositories\OrderPaymentRepo;
use Throwable;

class StateMachineService
{
    private Order $order;

    private int $orderId;

    private string $comment;

    private bool $notify;

    private array $shipment;

    private array $payment;

    public const CREATED = 'created';

    public const UNPAID = 'unpaid';

    public const PAID = 'paid';

    public const SHIPPED = 'shipped';

    public const COMPLETED = 'completed';

    public const CANCELLED = 'cancelled';

    public const ORDER_STATUS = [
        self::CREATED,
        self::UNPAID,
        self::PAID,
        self::SHIPPED,
        self::COMPLETED,
        self::CANCELLED,
    ];

    public const MACHINES = [
        self::CREATED => [
            self::UNPAID => ['updateStatus', 'addHistory', 'notifyNewOrder'],
        ],
        self::UNPAID  => [
            self::PAID      => ['updateStatus', 'addHistory', 'updateSales', 'subStock', 'notifyUpdateOrder'],
            self::CANCELLED => ['updateStatus', 'addHistory', 'notifyUpdateOrder'],
        ],
        self::PAID    => [
            self::CANCELLED => ['updateStatus', 'addHistory', 'notifyUpdateOrder'],
            self::SHIPPED   => ['updateStatus', 'addHistory', 'addShipment', 'notifyUpdateOrder'],
            self::COMPLETED => ['updateStatus', 'addHistory', 'notifyUpdateOrder'],
        ],
        self::SHIPPED => [
            self::COMPLETED => ['updateStatus', 'addHistory', 'notifyUpdateOrder'],
        ],
    ];

    public function __construct(Order $order)
    {
        $this->order   = $order;
        $this->orderId = $order->id;
    }

    public static function getInstance($order): self
    {
        return new self($order);
    }

    /**
     *
     * @param $comment
     * @return $this
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     *
     * @param $flag
     * @return $this
     */
    public function setNotify($flag): self
    {
        $this->notify = (bool) $flag;

        return $this;
    }

    /**
     *
     *
     * @param array $shipment
     * @return $this
     */
    public function setShipment(array $shipment = []): self
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     *
     *
     * @param array $payment
     * @return $this
     */
    public function setPayment(array $payment = []): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     *
     *
     * @return array
     * @throws \Exception
     */
    public static function getAllStatuses(): array
    {
        $result   = [];
        $statuses = self::ORDER_STATUS;
        foreach ($statuses as $status) {
            if ($status == self::CREATED) {
                continue;
            }
            $result[] = [
                'status' => $status,
                'name'   => trans("order.{$status}"),
            ];
        }

        return hook_filter('service.state_machine.all_statuses', $result);
    }

    /**
     * ()
     * @return string[]
     */
    public static function getValidStatuses(): array
    {
        $statuses = [
            self::PAID,
            self::SHIPPED,
            self::COMPLETED,
        ];

        return $statuses;
    }

    /**
     *
     *
     * @return array
     * @throws \Exception
     */
    public function nextBackendStatuses(): array
    {
        $machines = $this->getMachines();

        $currentStatusCode = $this->order->status;
        $nextStatus        = $machines[$currentStatusCode] ?? [];

        if (empty($nextStatus)) {
            return [];
        }
        $nextStatusCodes = array_keys($nextStatus);
        $result          = [];
        foreach ($nextStatusCodes as $status) {
            $result[] = [
                'status' => $status,
                'name'   => trans("order.{$status}"),
            ];
        }

        return $result;
    }

    /**
     * @param             $status
     * @param  string     $comment
     * @param  bool       $notify
     * @throws \Exception
     */
    public function changeStatus($status, string $comment = '', bool $notify = false)
    {
        $order         = $this->order;
        $oldStatusCode = $order->status;
        $newStatusCode = $status;

        $this->setComment($comment)->setNotify($notify);

        $this->validStatusCode($status);
        $functions = $this->getFunctions($oldStatusCode, $newStatusCode);
        if ($functions) {
            foreach ($functions as $function) {
                if ($function instanceof \Closure) {
                    $function();

                    continue;
                }

                if (! method_exists($this, $function)) {
                    throw new \Exception("{$function} not exist in StateMachine!");
                }
                $this->{$function}($oldStatusCode, $status);
            }
        }

        hook_filter('service.state_machine.change_status.after', ['order' => $order, 'status' => $status, 'comment' => $comment, 'notify' => $notify]);

        if (! $order->shipping_method_code && $status == self::PAID) {
            $this->changeStatus(self::COMPLETED, $comment, $notify);
        }
    }

    /**
     *
     *
     * @param             $statusCode
     * @throws \Exception
     */
    private function validStatusCode($statusCode)
    {
        $orderId           = $this->orderId;
        $orderNumber       = $this->order->number;
        $currentStatusCode = $this->order->status;

        $nextStatusCodes = collect($this->nextBackendStatuses())->pluck('status')->toArray();
        if (! in_array($statusCode, $nextStatusCodes)) {
            throw new \Exception("Order {$orderId}({$orderNumber}) is {$currentStatusCode}, cannot be changed to $statusCode");
        }
    }

    /**
     * ,  filter hook
     * @return mixed
     */
    private function getMachines()
    {
        $data = [
            'order'    => $this->order,
            'machines' => self::MACHINES,
        ];

        $data = hook_filter('service.state_machine.machines', $data);

        return $data['machines'] ?? [];
    }

    /**
     *
     *
     * @param $oldStatus
     * @param $newStatus
     * @return array
     */
    private function getFunctions($oldStatus, $newStatus): array
    {
        $machines = $this->getMachines();

        return $machines[$oldStatus][$newStatus] ?? [];
    }

    /**
     *
     *
     * @param             $oldCode
     * @param             $newCode
     * @throws \Throwable
     */
    private function updateStatus($oldCode, $newCode)
    {
        $this->order->status = $newCode;
        $this->order->saveOrFail();
    }

    /**
     *
     * @return void
     */
    private function updateSales()
    {
        $this->order->loadMissing([
            'orderProducts',
        ]);
        $orderProducts = $this->order->orderProducts;
        foreach ($orderProducts as $orderProduct) {
            Product::query()->where('id', $orderProduct->product_id)->increment('sales', $orderProduct->quantity);
        }
    }

    /**
     *
     *
     * @param            $oldCode
     * @param            $newCode
     * @throws Throwable
     */
    private function addHistory($oldCode, $newCode)
    {
        $history = new OrderHistory([
            'order_id' => $this->orderId,
            'status'   => $newCode,
            'notify'   => (int) $this->notify,
            'comment'  => (string) $this->comment,
        ]);
        $history->saveOrFail();
    }

    /**
     *
     *
     * @param $oldCode
     * @param $newCode
     */
    private function subStock($oldCode, $newCode)
    {
        $this->order->loadMissing([
            'orderProducts.productSku',
        ]);
        $orderProducts = $this->order->orderProducts;
        foreach ($orderProducts as $orderProduct) {
            $productSku = $orderProduct->productSku;
            if (empty($productSku)) {
                continue;
            }
            $productSku->decrement('quantity', $orderProduct->quantity);
        }
    }

    /**
     *
     */
    private function addShipment($oldCode, $newCode)
    {
        $shipment       = $this->shipment;
        $expressCode    = $shipment['express_code']    ?? '';
        $expressCompany = $shipment['express_company'] ?? '';
        $expressNumber  = $shipment['express_number']  ?? '';
        if ($expressCode && $expressCompany && $expressNumber) {
            $orderShipment = new OrderShipment([
                'order_id'        => $this->orderId,
                'express_code'    => $expressCode,
                'express_company' => $expressCompany,
                'express_number'  => $expressNumber,
            ]);
            $orderShipment->saveOrFail();
        }
    }

    /**
     *
     * @throws Throwable
     */
    private function addPayment($oldCode, $newCode)
    {
        if (empty($this->payment)) {
            return;
        }
        OrderPaymentRepo::createOrUpdatePayment($this->orderId, $this->payment);
    }

    /**
     *
     */
    private function notifyNewOrder($oldCode, $newCode)
    {
        if (! $this->notify) {
            return;
        }
        $this->order->notifyNewOrder();
    }

    /**
     *
     */
    private function notifyUpdateOrder($oldCode, $newCode)
    {
        if (! $this->notify) {
            return;
        }
        $this->order->notifyUpdateOrder($oldCode);
    }

    /**
     *
     */
    private function revertStock($oldCode, $newCode)
    {

    }
}
