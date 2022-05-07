<?php

namespace App\Repositories\OrderProduct;

use App\Repositories\BaseRepositoryInterface;

interface OrderProductRepositoryInterface extends BaseRepositoryInterface
{
    public function insertOrderProduct($attributes = []);
}
