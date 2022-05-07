<?php

namespace App\Http\Controllers;

use Exception;
use Faker\Factory;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productRepo;
    protected $imageRepo;
    protected $brandRepo;
    protected $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ImageRepositoryInterface $imageRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo
    ) {
        $this->productRepo = $productRepo;
        $this->imageRepo = $imageRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    public function index()
    {
        $all_product = $this->productRepo->getProduct();

        return view('admin.product.all_product')->with(compact('all_product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getCategoryWhereNull();

        return view('admin.product.add_product')->with(compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $new_image_name = $this->productRepo->storeImageProduct($request->image_thumbnail, $request->name);
        $slug = createSlug($request->name);
        $product = $request->all();
        $product['slug'] = $slug;
        $product['image_thumbnail'] = $new_image_name;
        $product = $this->productRepo->createProduct($product, $request->input('categories', []));
        if ($request->has('images')) {
            $data = [];
            $files = $request->images;
            foreach ($files as $key => $file) {
                $imageName = $this->productRepo->storeImageProduct($file, $request->name);
                $data[$key] = [
                    'product_id' => $product['id'],
                    'image' => $imageName,
                ];
            }
            $this->imageRepo->createMultipleImage($data);
        }

        return Redirect::route('products.create')->with('mess', __(
            'messages.add-success',
            ['name' => __('titles.category')]
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit_product = $this->productRepo->find($id);
        $brands = $this->brandRepo->getAll();
        $categories = $this->categoryRepo->getCategoryWithParent();

        return view('admin.product.edit_product')->with(compact('edit_product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $product = $this->productRepo->find($id);
        $productNew = $request->all();
        $slug = createSlug($request->name);
        if ($request->has('image_thumbnail')) {
            $destination = config('path.PRODUCT_UPLOAD_PATH') . $product->image_thumbnail;
            $this->productRepo->deleteFileImage($destination);
            $filename = $this->productRepo->storeImageProduct($request->image_thumbnail, $request->name);
        } else {
            $filename = $request->image_thumbnail_save;
        }
        $productNew['slug'] = $slug;
        $productNew['image_thumbnail'] = $filename;
        $this->productRepo->updateProduct($id, $productNew, $request->input('categories', []));
        if ($request->has('images')) {
            $data = [];
            $images = $this->imageRepo->getImageByProductId($product->id);
            foreach ($images as $image) {
                $destination = config('path.PRODUCT_UPLOAD_PATH') . $image->image;
                $this->productRepo->deleteFileImage($destination);
            }
            $this->imageRepo->deleteMultipleImage($product->id);
            $files = $request->images;
            foreach ($files as $key => $file) {
                $imageName = $this->productRepo->storeImageProduct($file, $request->name);
                $data[$key] = [
                    'product_id' => $product->id,
                    'image' => $imageName,
                ];
            }
            $this->imageRepo->createMultipleImage($data);
        }

        return Redirect::to(route('products.index'))->with('mess', __(
            'messages.update-success',
            ['name' => __('titles.category')]
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->find($id);
        $destination =  config('path.PRODUCT_UPLOAD_PATH') . $product->image_thumbnail;
        $this->productRepo->deleteFileImage($destination);
        $images = $this->imageRepo->getImageByProductId($product->id);
        foreach ($images as $image) {
            $destination =  config('path.PRODUCT_UPLOAD_PATH') . $image->image;
            $this->productRepo->deleteFileImage($destination);
        }
        $this->productRepo->delete($id);

        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.product')]));

        return Redirect::to(route('products.index'));
    }

    public function deleteimage($id)
    {
        $images = $this->imageRepo->find($id);
        $destination =  config('path.PRODUCT_UPLOAD_PATH') . $images->image;
        $this->productRepo->deleteFileImage($destination);
        $images->delete();

        Session::flash('mess', __('messages.delete-success', ['name' => __('titles.product')]));
        return back();
    }
}
