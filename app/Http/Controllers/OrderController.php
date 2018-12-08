<?php

namespace App\Http\Controllers;

use App\Partner;
use App\Product;
use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Input;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $overdueOrders = Order::with('partner', 'order_products.product')
            ->where('delivery_dt', '<', self::getDateTime())
            ->where('status', Order::ORDER_CONFIRMED)
            ->orderBy('delivery_dt', 'desc')
            ->limit(50)
            ->get();
        $overdueOrders = self::setOrderCost($overdueOrders);
        $overdueOrders = self::setOrderProductsNames($overdueOrders);
        $overdueOrders = self::setOrderStatusName($overdueOrders);

        $currentOrders = Order::with('partner', 'order_products.product')
            ->where('delivery_dt', '>', self::getDateTime())
            ->where('delivery_dt', '<', self::getDateTime(24))
            ->where('status', Order::ORDER_CONFIRMED)
            ->orderBy('delivery_dt', 'asc')
            ->get();
        $currentOrders = self::setOrderCost($currentOrders);
        $currentOrders = self::setOrderProductsNames($currentOrders);
        $currentOrders = self::setOrderStatusName($currentOrders);

        $newOrders = Order::with('partner', 'order_products.product')
            ->where('delivery_dt', '>', self::getDateTime())
            ->where('status', Order::ORDER_NEW)
            ->orderBy('delivery_dt', 'asc')
            ->limit(50)
            ->get();
        $newOrders = self::setOrderCost($newOrders);
        $newOrders = self::setOrderProductsNames($newOrders);
        $newOrders = self::setOrderStatusName($newOrders);

        $completedOrders = Order::with('partner', 'order_products.product')
            ->where('delivery_dt', '<', self::getDateTime())
            ->where('delivery_dt', '>', self::getDateTime(-24))
            ->where('status', Order::ORDER_COMPLETED)
            ->orderBy('delivery_dt', 'desc')
            ->limit(50)
            ->get();
        $completedOrders = self::setOrderCost($completedOrders);
        $completedOrders = self::setOrderProductsNames($completedOrders);
        $completedOrders = self::setOrderStatusName($completedOrders);

        $orders = [
            'overdueOrders' => $overdueOrders,
            'currentOrders' => $currentOrders,
            'newOrders' => $newOrders,
            'completedOrders' => $completedOrders
        ];

        return view('orders')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $orderProductRequestData = self::getOrderProductsFromRequest($data);

        $order = Order::with('order_products')->find($data['id']);

        $order->client_email = $data['email'];
        $order->partner_id = $data['partner'];
        $order->status = $data['status'];

        $productIds = [];
        foreach ($order->order_products as $orderProduct) {
            $orderProduct->quantity = $orderProductRequestData[$orderProduct->product_id];
            $orderProduct->save();

            $productIds[] = $orderProduct->product_id;
        }
        $order->save();

        $order = self::setOrderCost([$order])[0];

        if ($order->status = Order::ORDER_COMPLETED) {

            $partnersEmails = self::getVendorsEmailsByProductIds($productIds);

            $partnersEmails[] = $order->client_email;

            Mail::to($partnersEmails)->send(new OrderShipped($order));
        }

        return redirect()->route('orders.edit', $data['id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::with('partner', 'order_products.product')->where('id', $id)->first();

        $order = self::setOrderCost([$order])[0];
        $order = self::setOrderStatusName([$order])[0];

        $partners = Partner::all();

        $statuses = [
            Order::ORDER_NEW => 'новый',
            Order::ORDER_CONFIRMED => 'подтвержден',
            Order::ORDER_COMPLETED => 'завершен'
        ];

        return view('order')
            ->with('order', $order)
            ->with('partners', $partners)
            ->with('statuses', $statuses);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Возвращает текущее дату/время по Москве
     * @return false|string
     */
    public static function getDateTime($addhours = null)
    {
        $nowGreenwich = date("Y-m-d H:i:s");

        $addhours ? $addseconds = $addhours * 3600 : $addseconds = 0;
        $nowMoscow = strtotime($nowGreenwich) + 10800 + $addseconds;

        $nowMoscowFormatted = date("Y-m-d H:i:s", $nowMoscow);

        return $nowMoscowFormatted;
    }

    /**
     * Добавляет стоимость заказа в заказы
     * @param $orders
     * @return mixed
     */
    public static function setOrderCost($orders)
    {
        foreach ($orders as $order) {

            $ordercost = 0;

            foreach ($order->order_products as $orderproducts) {
                $ordercost += $orderproducts->quantity * $orderproducts->price;
            }
            $order->ordercost = $ordercost;
        }

        return $orders;
    }

    /**
     * Добавляет список товаров в заказы
     * @param $orders
     * @return mixed
     */
    public static function setOrderProductsNames($orders)
    {
        foreach ($orders as $order) {

            $productsNames = [];

            foreach ($order->order_products as $orderproducts) {
                $productsNames[] = $orderproducts->product->name;
            }
            $order->productsNames = implode(",", $productsNames);
        }

        return $orders;
    }

    public static function setOrderStatusName($orders)
    {
        foreach ($orders as $order) {

            switch ($order->status) {
                case Order::ORDER_NEW:
                    $statusName = 'новый';
                    break;
                case Order::ORDER_CONFIRMED:
                    $statusName = 'подтвержден';
                    break;
                case Order::ORDER_COMPLETED:
                    $statusName = 'завершен';
                    break;
            }

            $order->statusName = $statusName;
        }

        return $orders;
    }

    /**
     * пересчет суммы заказа
     * @return int
     */
    public function getOrderSum()
    {
        $data = Input::all();

        $orderProducts = self::getOrderProductsFromRequest($data);

        $productsIds = array_keys($orderProducts);

        $products = Product::whereIn('id', $productsIds)->get();

        $orderSumm = 0;
        foreach ($products as $product) {
            $orderSumm += $product->price * $orderProducts[$product->id];
        }

        return $orderSumm;
    }

    public static function getOrderProductsFromRequest($data)
    {
        $orderProducts = [];

        $substr = 'product-';

        foreach ($data as $key => $item) {

            if (strpos($key, $substr) !== false && !empty($item)) {

                $orderProducts[substr($key, strlen($substr))] = $item;
            }
        }

        return $orderProducts;
    }


    public static function getVendorsEmailsByProductIds($productIds)
    {
        $products = Product::with('vendor')->whereIn('id', $productIds)->get();

        $emails = [];
        foreach ($products as $product) {
            $emails[] = $product->vendor->email;
        }

        return array_unique($emails);
    }
}
