<?php

namespace App\Repositories\Voucher;

use App\Repositories\BaseRepositoryInterface;

interface VoucherRepositoryInterface extends BaseRepositoryInterface
{
    public function insertVoucher($attributes = []);
    public function deleteListVoucher($attributes = []);
    public function findByCondition($attributes = []);
    public function findByCode($code);
    public function decrementVoucherWhenStoreOrder($voucher_id, $attributes = []);
    public function incrementVoucherWhenCancelOrder($voucher_id);
}
