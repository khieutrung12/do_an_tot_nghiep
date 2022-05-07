<?php

namespace App\Repositories\Shipping;

use App\Models\Shipping;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\Shipping\ShippingRepositoryInterface;

class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface
{
    public function getModel()
    {
        return Shipping::class;
    }
}
