<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'value',
        'condition_min_price',
        'maximum_reduction',
        'start_date',
        'end_date',
    ];

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function discount($total)
    {
        $current = date('Y-m-d');
        if (strtotime($current) >= strtotime($this->start_date) &&
            strtotime($current) <= strtotime($this->end_date) &&
            $total >= $this->condition_min_price &&
            $this->quantity > 0) {
            $discount = ($this->value / 100) * $total;
            if ($discount > $this->maximum_reduction) {
                return $this->maximum_reduction;
            } else {
                return $discount;
            }
        }

        return null;
    }
}
