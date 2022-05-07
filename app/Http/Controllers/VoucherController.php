<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Voucher\StoreRequest;
use App\Http\Requests\Voucher\UpdateRequest;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class VoucherController extends Controller
{
    protected $voucherRepo;
    protected $orderRepo;

    public function __construct(
        VoucherRepositoryInterface $voucherRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->voucherRepo = $voucherRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = $this->voucherRepo->getAll();

        return view('admin.voucher.index', [
            'vouchers' => $vouchers,
        ]);
    }

    public function fetch()
    {
        $vouchers = $this->voucherRepo->getAll();

        return Datatables::of($vouchers)
            ->addIndexColumn()
            ->addColumn('actions', function ($row) {
                return view('components.action_voucher', ['id' => $row['id']]);
            })
            ->addColumn('checkbox', function ($row) {
                return view('components.checkbox_voucher', ['id' => $row['id']]);
            })
            ->rawColumns(['actions', 'checkbox'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $result = $this->voucherRepo->insertVoucher([
            'code' => createCode($request->name),
            'name' => $request->name,
            'quantity' => $request->quantity,
            'value' => $request->value,
            'condition_min_price' => $request->condition_min_price,
            'maximum_reduction' => $request->maximum_reduction,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        if (!$result) {
            return response()->json([
                'message' => __('messages.something-wrong'),
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => __('messages.add-success', ['name' => __('titles.voucher')]),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $voucher = $this->voucherRepo->find($request->voucher_id);

        if ($voucher) {
            return response()->json([
                'code' => 200,
                'voucher' => $voucher,
            ], 200);
        }

        return response()->json([
            'message' => __('messages.No Results Found'),
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $voucher = $this->voucherRepo->find($request->cid);
        if (!$voucher) {
            return response()->json([
                'message' => __('messages.No Results Found'),
            ]);
        }
        if ($voucher->name == $request->name) {
            $code = $voucher->code;
        } else {
            $code = createCode($request->name);
        }

        $result = $this->voucherRepo->update($request->cid, [
                'code' => $code,
                'name' => $request->name,
                'quantity' => $request->quantity,
                'value' => $request->value,
                'condition_min_price' => $request->condition_min_price,
                'maximum_reduction' => $request->maximum_reduction,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
        ]);
        if ($result) {
            return response()->json([
                'code' => 200,
                'message' => __('messages.update-success', ['name' => __('titles.voucher')]),
            ], 200);
        }
        
        return response()->json([
            'message' => __('messages.something-wrong'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $order = $this->orderRepo->findByVoucherId($request->voucher_id);

        if ($order == null) {
            $result = $this->voucherRepo->delete($request->voucher_id);

            if ($result) {
                return response()->json([
                    'code' => 200,
                    'message' => __('messages.delete-success', ['name' => __('titles.voucher')]),
                ], 200);
            }

            return response()->json([
                'message' => __('messages.something-wrong'),
            ]);
        }

        return response()->json([
            'code' => 403,
            'message' => __('messages.cant-delete'),
        ], 403);
    }

    public function deleteList(Request $request)
    {
        foreach ($request->voucher_id as $id) {
            if ($this->orderRepo->findByVoucherId($request->voucher_id) != null) {
                return response()->json([
                    'code' => 403,
                    'message' => __('messages.cant-delete'),
                ], 403);
            }
        }

        $result = $this->voucherRepo->deleteListVoucher($request->voucher_id);

        if ($result) {
            return response()->json([
                'code' => 200,
                'message' => __('messages.delete-success', ['name' => __('titles.voucher')]),
            ], 200);
        }

        return response()->json([
            'message' => __('messages.something-wrong'),
        ]);
    }

    public function walletVoucher()
    {
        $orders = $this->orderRepo->getVoucherIdByUserId(Auth()->user()->id);

        $array = [];
        if ($orders != null) {
            foreach ($orders as $order) {
                array_push($array, $order->voucher_id);
            }
        }

        $vouchers = $this->voucherRepo->findByCondition($array);

        return view('user.profile.voucher.index', [
            'vouchers' => $vouchers,
        ]);
    }

    public function useVoucher($code)
    {
        if (Session()->get('code')) {
            Session()->forget('code');
        }
        Session()->put('code', $code);

        return redirect()->route('shop');
    }

    public function showVoucher(Request $request)
    {
        $voucher = $this->voucherRepo->findByCode($request->code);

        return view('user.profile.voucher.show', [
            'voucher' => $voucher,
        ]);
    }
}
