<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Voucher\ApplyRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class CartController extends Controller
{
    protected $productRepo;
    protected $voucherRepo;
    protected $orderRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        VoucherRepositoryInterface $voucherRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->productRepo = $productRepo;
        $this->voucherRepo = $voucherRepo;
        $this->orderRepo = $orderRepo;
    }

    public function index()
    {
        $data = session()->get('data');

        return view('user.cart.cart')->with(compact('data'));
    }

    public function addToCart($id)
    {
        $product = $this->productRepo->find($id);
        if (!$product) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $data = session()->get('data');
        if (isset($data['carts'][$id]['quantity'])) {
            $data['carts'][$id]['quantity'] = $data['carts'][$id]['quantity'] + 1;
        } else {
            $data['carts'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'total_product' => $product->quantity,
                'quantity' => 1,
                'image_thumbnail' => $product->image_thumbnail,
            ];
        }
        if (!isset($data['discount'])) {
            $data['discount'] = 0;
            $data['percent'] = 0;
        }

        session()->put('data', $data);

        return response()->json([
            'code' => 200,
            'message' => 'success',
            'messageCart' =>  trans('messages.add-success', ['name' => __('titles.product')]),
        ], 200);
    }

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $data = session()->get('data');
            $data['carts'][$request->id]['quantity'] = $request->quantity;
            session()->put('data', $data);
            $data = session()->get('data');

            $cartComponent = view('user.cart.cart_components.cart_components', compact('data'))->render();

            return response()->json([
                'cart_component' => $cartComponent,
                'code' => 200,
                'messageCart' =>  trans('messages.update-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }

    public function deleteCart(Request $request)
    {
        if ($request->id) {
            $data = session()->get('data');
            unset($data['carts'][$request->id]);
            session()->put('data', $data);
            $data = session()->get('data');

            $cartComponent = view('user.cart.cart_components.cart_components', compact('data'))->render();

            return response()->json([
                'cart_component' => $cartComponent,
                'code' => 200,
                'messageCart' =>  trans('messages.delete-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }

    public function countProduct()
    {
        $data = session()->get('data');
        session()->put('data', $data);
        $data = session()->get('data');
        $count_product = view('user.cart.cart_components.count_product')->render();

        return response()->json([
            'count_product' => $count_product,
            'code' => 200,
        ], 200);
    }

    public function addMoreProduct(Request $request, $id)
    {
        if ($request->quantity) {
            $product = $this->productRepo->find($id);
            $data = session()->get('data');
            if (isset($data['carts'][$id]['quantity'])) {
                $data['carts'][$id]['quantity'] = $data['carts'][$id]['quantity'] + $request->quantity;
            } else {
                $data['carts'][$id] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'total_product' => $product->quantity,
                    'quantity' => $request->quantity,
                    'image_thumbnail' => $product->image_thumbnail,
                ];
            }
            if (!isset($data['discount'])) {
                $data['discount'] = 0;
                $data['percent'] = 0;
            }
            session()->put('data', $data);

            return response()->json([
                'code' => 200,
                'messageCart' =>  trans('messages.add-success', ['name' => __('titles.product')]),
            ], 200);
        }
    }

    public function applyVoucher(ApplyRequest $request)
    {
        if (Session()->get('code')) {
            Session()->forget('code');
        }

        $voucher = $this->voucherRepo->findByCode($request->coupon);

        if ($voucher == null) {
            return redirect()->route('carts.index')
                ->withErrors(['coupon' => __('messages.voucher-doesnt-exist')])
                ->withInput();
        }

        if ($voucher->discount($request->total) == null) {
            return redirect()->route('carts.index')
                ->withErrors(['coupon' => __('messages.condition-not-satisfied')])
                ->withInput();
        }

        $orders = $this->orderRepo->findOrderByUserId(auth()->user()->id);

        foreach ($orders as $order) {
            if ($order['voucher_id'] == $voucher->id) {
                return redirect()->route('carts.index')
                    ->withErrors(['coupon' => __('messages.voucher-used')])
                    ->withInput();
            }
        }

        $discount = ($voucher->discount($request->total)) * (-1);
        $percent = $voucher->value;

        $data = session()->get('data');

        $data['discount'] = $discount;
        $data['percent'] = $percent;
        $data['voucher'] = $voucher;

        session()->put('data', $data);

        return redirect()->route('carts.index');
    }

    public function deleteVoucher(Request $request)
    {
        $data = Session()->get('data');

        unset($data['voucher']);
        $data['discount'] = 0;
        $data['percent'] = 0;
        session()->put('data', $data);

        return redirect()->route('carts.index');
    }
}
