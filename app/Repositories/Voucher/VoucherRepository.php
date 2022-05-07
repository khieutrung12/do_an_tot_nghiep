<?php

namespace App\Repositories\Voucher;

use App\Models\Voucher;
use App\Repositories\BaseRepository;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    public function getModel()
    {
        return Voucher::class;
    }

    public function insertVoucher($attributes = [])
    {
        return $this->model->insert($attributes);
    }

    public function deleteListVoucher($attributes = [])
    {
        return $this->model->whereIn('id', $attributes)->delete();
    }

    public function findByCondition($attributes = [])
    {
        return $this->model->whereNotIn('id', $attributes)
            ->where([
                ['start_date', '<=', date('Y-m-d')],
                ['end_date', '>=', date('Y-m-d')],
                ['quantity', '>', 0],
            ])->get();
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)->first();
    }

    public function decrementVoucherWhenStoreOrder($voucher_id, $attributes = [])
    {
        $voucher = $this->model->find($voucher_id);
    }

    public function incrementVoucherWhenCancelOrder($voucher_id)
    {
        return $this->model->where('id', $voucher_id)
            ->increment('quantity', 1);
    }
}
