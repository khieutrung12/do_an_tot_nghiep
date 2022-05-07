<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    public function getModel()
    {
        return Product::class;
    }

    public function decrementQuantityProduct($product_id, $quantity)
    {
        return $this->model->where('id', $product_id)->decrement('quantity', $quantity);
    }

    public function incrementQuantityProduct($product_id, $quantity)
    {
        return $this->model->where('id', $product_id)->increment('quantity', $quantity);
    }

    public function decrementSoldProduct($product_id, $quantity)
    {
        return $this->model->where('id', $product_id)->decrement('sold', $quantity);
    }

    public function incrementSoldProduct($product_id, $quantity)
    {
        return $this->model->where('id', $product_id)->increment('sold', $quantity);
    }

    public function getProductTopNew()
    {
        return $this->model
            ->orderby('created_at', 'DESC')
            ->take(config('app.limit_top_new'))->get();
    }

    public function search($key)
    {
        return $this->model
            ->where('name', 'LIKE', '%' . $key . '%')
            ->take(config('app.limit_search'))->get();
    }

    public function searchList($key)
    {
        return $this->model
            ->where('name', 'LIKE', '%' . $key . '%')
            ->with('brand')
            ->paginate(config('app.limit'));
    }

    public function findBySlug($slug)
    {
        return $this->model
            ->where('slug', $slug)
            ->with('brand')
            ->first();
    }

    public function storeImageProduct($getFile, $name)
    {
        $result = storeImage($getFile, $name);
        return $result;
    }

    public function deleteFileImage($destination)
    {
        if (File::exists($destination)) {
            File::delete($destination);
            return true;
        } else {
            return false;
        }
    }


    public function getProduct()
    {
        return $this->model->select('*')->with('brand', 'category')->orderby('created_at', 'DESC')->get();
    }

    public function createProduct(array $attributes, array $categoryIds)
    {
        $product = $this->create($attributes);
        $product->category()->sync($categoryIds);
        $product->save();

        return $product;
    }

    public function updateProduct(int $productId, array $attributes, array $categoryIds)
    {
        $product = $this->update($productId, $attributes);
        $product->category()->sync($categoryIds);
        $product->save();

        return $product;
    }
}
