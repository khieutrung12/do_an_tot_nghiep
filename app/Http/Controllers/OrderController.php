<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Shipping;
use App\Models\Statistic;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Notifications\UpdateOrderStatus;
use App\Http\Requests\Order\StoreRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\Shipping\ShippingRepositoryInterface;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;

class OrderController extends Controller
{
    protected $productRepo;
    protected $voucherRepo;
    protected $orderRepo;
    protected $shippingRepo;
    protected $orderProductRepo;
    protected $orderStatusRepo;
    protected $userRepo;


    public function __construct(
        ProductRepositoryInterface $productRepo,
        VoucherRepositoryInterface $voucherRepo,
        OrderRepositoryInterface $orderRepo,
        ShippingRepositoryInterface $shippingRepo,
        OrderProductRepositoryInterface $orderProductRepo,
        OrderStatusRepositoryInterface $orderStatusRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->voucherRepo = $voucherRepo;
        $this->orderRepo = $orderRepo;
        $this->shippingRepo = $shippingRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->orderStatusRepo = $orderStatusRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getOrderNotInStatusCancel();

        return view('admin.order.all_order')->with(compact('orders'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Session::has('cart')) {
            $order_status = config('app.startOrderStatus');
            $code = Str::random(config('app.limitRandomString'));
            $data = Session::get('data');
            $carts = session()->get('cart');
            $order_product = [];

            if (!isset($data['voucher'])) {
                $voucher_id  = null;
            } else {
                $voucher_id  = $data['voucher']->id;
                $quantity = ['quantity' => $data['voucher']->quantity - 1];
                $this->voucherRepo->update($voucher_id, $quantity);
            }

            $sum_price = Session::get('subTotal');
            $dataShipping = $request->all();
            $shipping = $this->shippingRepo->create($dataShipping);
            $dataOrder = [
                'user_id' => $request->user_id,
                'order_status_id' => $order_status,
                'code' => $code,
                'sum_price' => $sum_price,
                'shipping_id' => $shipping->id,
                'voucher_id' => $voucher_id,
            ];

            $orders = $this->orderRepo->create($dataOrder);
            foreach ($carts as $key => $cart) {
                $prd = $this->productRepo->find($key);
                if ($prd['quantity'] >= $cart['quantity']) {
                    $order_product[$key] = [
                        'order_id' => $orders->id,
                        'product_id' => $key,
                        'product_sales_quantity' => $cart['quantity'],
                    ];
                } else {
                    session()->forget('cart');
                    session()->forget('data');
                    session()->forget('subTotal');
                    $orders->delete();
                    $shipping->delete();
                    Session::flash('mess', __('messages.error'));

                    return back();
                }
            }
            $this->orderProductRepo->insertOrderProduct($order_product);

            session()->forget('cart');
            session()->forget('data');
            session()->forget('subTotal');

            return view('user.checkout.order_complete');
        } else {
            Session::flash('mess', __('messages.cart-empty'));

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = $this->orderRepo->find($id);
        $order_status = $this->orderStatusRepo->getAll();
        return view('admin.order.view_order')->with(compact('order', 'order_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = $this->orderRepo->find($id);
        $order_status_id = $request->order_status_id;

        if ($order->order_status_id != $order_status_id) {
            if ($order_status_id == config('app.confirmed')) {
                foreach ($order->products as $key => $product) {
                    $product->pivot->product_sales_quantity;
                    $this->productRepo->decrementQuantityProduct($product->id, $product->pivot->product_sales_quantity);
                    $this->productRepo->incrementSoldProduct($product->id, $product->pivot->product_sales_quantity);
                }
            } elseif ($order_status_id != config('app.confirmed') && $order_status_id != config('app.canceled')) {
                foreach ($order->products as $key => $product) {
                    $this->productRepo->incrementQuantityProduct($product->id, $product->pivot->product_sales_quantity);
                    $this->productRepo->decrementSoldProduct($product->id, $product->pivot->product_sales_quantity);
                }
            }
            if ($order_status_id == config('app.canceled')) {
                if ($order->voucher != null) {
                    $this->voucherRepo->incrementVoucherWhenCancelOrder($order->voucher->id);
                }
            }
            $order->update([
                'order_status_id' => $request->order_status_id,
            ]);
            $eventNotify = new UpdateOrderStatus($order);
            $this->userRepo->sendNotify($order->user_id, $eventNotify);

            $request->session()->flash('mess', __('messages.update-success', ['name' => __('titles.order')]));
        }

        return redirect()->route('orders.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function infoCheckout()
    {
        $carts = [];
        $discount = 0;
        $percent = 0;

        if (Session::has('data')) {
            $data = session()->get('data');
            $carts = $data['carts'];
            $discount = $data['discount'];
            $percent = $data['percent'];
            session()->put('cart', $carts);
        }

        return view('user.checkout.checkout', [
            'carts' => $carts,
            'discount' => $discount,
            'percent' => $percent,
        ]);
    }

    public function allCancelOrder()
    {
        $orders = $this->orderRepo->getOrderInStatusCancel();

        return view('admin.order.all_cancel_order')->with(compact('orders'));
    }

    public function viewCancelOrder($id)
    {
        $order = $this->orderRepo->find($id);
        $order_status = $this->orderStatusRepo->getAll();

        return view('admin.order.view_cancel_order')->with(compact('order'));
    }
}
