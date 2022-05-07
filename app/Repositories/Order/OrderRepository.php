<?php

namespace App\Repositories\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Repositories\Order\OrderRepositoryInterface;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function findByVoucherId($voucher_id)
    {
        $this->model->where('voucher_id', $voucher_id)->first();
    }

    public function getVoucherIdByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)
            ->whereNotNull('voucher_id')->get();
    }

    public function getOrderWithUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));
    }

    public function getOrderWithUserIdAndStatusOrder($user_id, $order_status_id)
    {
        return $this->model->where([
            ['user_id', $user_id],
            ['order_status_id', $order_status_id],
        ])->with('products', 'orderStatus')
            ->orderby('created_at', 'DESC')
            ->paginate(config('app.limit'));
    }

    public function findOrderByUserId($user_id)
    {
        return $this->model
            ->where('user_id', $user_id)->get();
    }

    public function getOrderNotInStatusCancel()
    {
        return $this->model->whereNotIn('order_status_id', [config('app.canceled')])
            ->with('orderStatus')->orderby('created_at', 'DESC')->get();
    }

    public function getOrderInStatusCancel()
    {
        return $this->model->whereIn('order_status_id', [config('app.canceled')])
            ->orderby('created_at', 'DESC')->paginate(config('app.limit'));
    }

    public function getRevenueMonth($year)
    {
        return $this->model->where('order_status_id', '1')->whereYear('created_at', $year)
            ->selectRaw('month(created_at) as m, year(created_at) as y,sum(sum_price) as sum')
            ->groupBy(DB::raw('month(created_at),year(created_at)'))
            ->pluck('sum', 'm')->toArray();
    }

    public function getTotalOrdersWeekForMonth($monday, $nextMonday)
    {
        return $this->model->where('order_status_id', '1')->whereBetween('created_at', [$monday, $nextMonday])
            ->selectRaw('year(created_at) as y,count(id) as countId')
            ->groupBy(DB::raw('year(created_at)'))
            ->pluck('countId');
    }

    public function getOrdersOnWeek($fromDate, $toDate)
    {
        return $this->model->with('user')
            ->whereBetween('updated_at', [$fromDate, $toDate])
            ->where('order_status_id', config('app.confirmed'))
            ->get();
    }

    public function countOrderByYear($year)
    {
        $data = $this->model->whereYear('updated_at', '=', $year)->get();

        return count($data) > 0;
    }
}
