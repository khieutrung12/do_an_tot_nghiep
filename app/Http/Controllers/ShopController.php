<?php

namespace App\Http\Controllers;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class ShopController extends Controller
{
    protected $brandRepo;
    protected $productRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $brands = $this->brandRepo->getBrands();
        $products = $this->productRepo->getProduct();

        return view('shop', [
            'brands' => $brands,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = $this->productRepo->findBySlug($slug);

        return view('show', [
            'product' => $product,
        ]);
    }
}
