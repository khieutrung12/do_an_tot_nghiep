<?php

namespace App\Repositories\OrderStatus;

use App\Models\OrderStatus;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;

class OrderStatusRepository extends BaseRepository implements OrderStatusRepositoryInterface
{
    public function getModel()
    {
        return OrderStatus::class;
    }
}
