<?php

namespace App\Repositories\Image;

use App\Models\Image;
use App\Repositories\BaseRepository;
use App\Repositories\Image\ImageRepositoryInterface;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return Image::class;
    }

    public function createMultipleImage(array $images)
    {
        return $this->model->insert($images);
    }

    public function getImageByProductId($productId)
    {
        return $this->model->where('product_id', $productId)->get();
    }

    public function deleteMultipleImage($productId)
    {
        return $this->model->where('product_id', $productId)->delete();
    }
}
