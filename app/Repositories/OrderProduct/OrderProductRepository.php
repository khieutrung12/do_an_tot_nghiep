<?php

namespace App\Repositories\OrderProduct;

use App\Models\OrderProduct;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    public function getModel()
    {
        return OrderProduct::class;
    }

    public function insertOrderProduct($attributes = [])
    {
        return $this->model->insert($attributes);
    }
}
