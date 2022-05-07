<?php

namespace App\Repositories\Image;

use App\Repositories\BaseRepositoryInterface;

interface ImageRepositoryInterface extends BaseRepositoryInterface
{
    public function createMultipleImage(array $images);

    public function getImageByProductId($productId);

    public function deleteMultipleImage($productId);
}
