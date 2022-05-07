<?php

namespace App\Repositories\Order;

use App\Repositories\BaseRepositoryInterface;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function findByVoucherId($voucher_id);

    public function getVoucherIdByUserId($user_id);

    public function getOrderWithUserId($user_id);

    public function getOrderWithUserIdAndStatusOrder($user_id, $order_status_id);

    public function findOrderByUserId($user_id);

    public function getOrderNotInStatusCancel();

    public function getOrderInStatusCancel();

    public function getTotalOrdersWeekForMonth($monday, $nextMonday);

    public function getRevenueMonth($year);

    public function getOrdersOnWeek($fromDate, $toDate);

    public function countOrderByYear($year);
}
