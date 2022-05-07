<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepositoryInterface;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProduct();

    public function getProductTopNew();

    public function search($key);

    public function searchList($key);

    public function findBySlug($slug);

    public function storeImageProduct($getFile, $name);

    public function deleteFileImage($destination);

    public function createProduct(array $attributes, array $categoryIds);

    public function updateProduct(int $productId, array $attributes, array $categoryIds);

    public function decrementQuantityProduct($product_id, $quantity);

    public function incrementQuantityProduct($product_id, $quantity);

    public function decrementSoldProduct($product_id, $quantity);

    public function incrementSoldProduct($product_id, $quantity);
}
