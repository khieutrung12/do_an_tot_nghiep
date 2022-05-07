<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'shipping';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'note',
        'email'
    ];

    public function orders()
    {
        return $this->hasOne(Order::class);
    }
}
