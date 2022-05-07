<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class HomeController extends Controller
{
    protected $productRepo;
    protected $brandRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topNew = $this->productRepo->getProductTopNew();

        return view('home', [
            'topNew' => $topNew,
        ]);
    }

    public function search(Request $request)
    {
        $products = $this->productRepo->search($request->name);

        return view('layouts.search', [
            'products' => $products,
            'key' => request('name'),
        ]);
    }

    public function searchList($key)
    {
        $products = $this->productRepo->searchList($key);

        if (count($products) == 0) {
            return view('error_search');
        }

        $brands = [];
        foreach ($products as $product) {
            if (isset($brands[$product->brand->name])) {
                $brands[$product->brand->name] += 1;
            } else {
                $brands[$product->brand->name] = 1;
            }
        }

        return view('shop', [
            'products' => $products,
            'brands' => $brands,
            'key' => $key,
            'action' => 'search',
        ]);
    }

    public function searchByCategory($category, Category $childCategory = null, $childCategory2 = null)
    {
        $ids  = collect();
        $brands = $this->brandRepo->getAll();
        if ($childCategory2) {
            $subCategory = $childCategory->where('slug', $childCategory2)->firstOrFail();
            $ids = collect($subCategory->id);
        } elseif ($childCategory) {
            $ids = $childCategory->childCategories->pluck('id');
        } elseif ($category) {
            $category = Category::where('slug', $category)->with('childCategories.childCategories')->get();
            foreach ($category as $subCategory) {
                foreach ($subCategory->childCategories as $subSubCategory) {
                    $ids = $ids->merge($subSubCategory->childCategories->pluck('id'));
                }
            }
        }
        $products = Product::whereHas('category', function ($query) use ($ids) {
            $query->whereIn('category_id', $ids);
        })
            ->get();

        return view('shop')->with(compact('products', 'brands'));
    }
}
