<?php

namespace Tests\Unit\Http\Controllers;

use DB;
use Mockery;
use Tests\TestCase;
use App\Models\Brand;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
// use Illuminate\Http\Testing\File;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Testing\FileFactory;
use App\Http\Controllers\ProductController;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\FileBag;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class ProductControllerTest extends TestCase
{
    protected $controller;
    protected $brandRepo;
    protected $productRepo;
    protected $categoryRepo;
    protected $formrequest;
    protected $imageRepo;
    protected $productFactory;
    protected $dataWithImage;
    protected $dataWithNoImage;
    protected $product;

    public function setup(): void
    {
        parent::setUp();
        $this->brandRepo =  Mockery::mock($this->app->make(BrandRepositoryInterface::class))->makePartial();
        $this->categoryRepo = Mockery::mock($this->app->make(CategoryRepositoryInterface::class))->makePartial();
        $this->productRepo = Mockery::mock($this->app->make(ProductRepositoryInterface::class))->makePartial();
        $this->imageRepo = Mockery::mock($this->app->make(ImageRepositoryInterface::class))->makePartial();
        $this->controller = new ProductController(
            $this->productRepo,
            $this->imageRepo,
            $this->brandRepo,
            $this->categoryRepo
        );
        $this->product = Product::factory()->make();
        $this->dataWithNoImage = [
            'brand_id' =>    $this->product->brand_id,
            'name' =>   $this->product->name,
            'quantity' =>   $this->product->quantity,
            'price' =>   $this->product->price,
            'description' =>   $this->product->description,
            'categories' => [0 => 34],
        ];
        $this->dataWithImage = [
            'brand_id' =>    $this->product->brand_id,
            'name' =>   $this->product->name,
            'quantity' =>   $this->product->quantity,
            'price' =>   $this->product->price,
            'description' =>   $this->product->description,
            'image_thumbnail' => UploadedFile::fake()->image('book.png'),
            'images' => [UploadedFile::fake()->image('file0.png'), UploadedFile::fake()->image('file1.png'),],
            'categories' => [0 => 34],
        ];
    }

    public function tearDown(): void
    {
        Mockery::close();
        unset($this->controller);
        unset($this->brandRepo);
        unset($this->productRepo);
        unset($this->imageRepo);
        unset($this->categoryRepo);
        unset($this->product);
        unset($this->dataWithNoImage);
        unset($this->dataWithImage);
        parent::tearDown();
    }

    public function testIndexProduct()
    {
        $this->productRepo->shouldReceive('getProduct')->once()->andReturn(new Collection([new Product()]));
        $view = $this->controller->index();
        $this->assertEquals('admin.product.all_product', $view->getName());
        $this->assertArrayHasKey('all_product', $view->getData());
    }

    public function testCreateProduct()
    {
        $this->brandRepo->shouldReceive('getAll')->once()->andReturn(new Collection([new Brand()]));
        $this->categoryRepo->shouldReceive('getCategoryWhereNull')->once()
            ->andReturn(new Collection([new Category()]));
        $view = $this->controller->create();
        $this->assertEquals('admin.product.add_product', $view->getName());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('categories', $view->getData());
    }

    public function testStoreProductFalse()
    {
        $request = new StoreRequest($this->dataWithNoImage);
        $this->productRepo->shouldReceive('storeImageProduct')->andReturn('a.png');
        $this->productRepo->shouldReceive('createProduct')->andReturn($this->product);
        $this->imageRepo->shouldReceive('createMultipleImage')->andReturn(false);
        $response = $this->controller->store($request);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function testStoreProductSuccess()
    {
        $request = new StoreRequest($this->dataWithImage);
        $this->productRepo->shouldReceive('storeImageProduct')->andReturn('a.png');
        $this->productRepo->shouldReceive('createProduct')->andReturn($this->product);
        $this->imageRepo->shouldReceive('createMultipleImage')->andReturn(true);
        $response = $this->controller->store($request);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('products.create'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }


    public function testEditProduct()
    {
        $product = Product::factory()->make();
        $this->productRepo->shouldReceive('find')->andReturn($product);
        $this->brandRepo->shouldReceive('getAll')->andReturn(new Collection([new Brand()]));
        $this->categoryRepo->shouldReceive('getCategoryWithParent')->andReturn(new Collection([new Category()]));
        $view = $this->controller->edit($product->id);
        $this->assertEquals('admin.product.edit_product', $view->getName());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('categories', $view->getData());
        $this->assertArrayHasKey('edit_product', $view->getData());
    }

    public function testUpdateProductFalse()
    {
        $request = new UpdateRequest($this->dataWithNoImage);
        $this->productRepo->shouldReceive('find')->andReturn($this->product);
        $this->productRepo->shouldReceive('updateProduct')->andReturn(false);
        $this->productRepo->shouldReceive('storeImageProduct')->andReturn(false);
        $response = $this->controller->update($request, $this->product->id);
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    public function testUpdateProductSuccess()
    {
        $image = Image::factory(1)->make();
        $request = new UpdateRequest($this->dataWithImage);
        $this->productRepo->shouldReceive('find')->andReturn($this->product);
        $this->productRepo->shouldReceive('updateProduct')->andReturn($this->product);
        $this->productRepo->shouldReceive('storeImageProduct')->andReturn('a.png');
        $this->imageRepo->shouldReceive('getImageByProductId')->andReturn($image);
        $this->productRepo->shouldReceive('deleteFileImage')->andReturn(true);
        $this->imageRepo->shouldReceive('deleteMultipleImage')->andReturn(true);
        $this->imageRepo->shouldReceive('createMultipleImage')->andReturn(true);
        $response = $this->controller->update($request, $this->product->id);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('products.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testDeleteProductSuccess()
    {
        $image = Image::factory(3)->make();
        $this->productRepo->shouldReceive('find')->andReturn($this->product);
        $this->imageRepo->shouldReceive('getImageByProductId')->andReturn($image);
        $this->productRepo->shouldReceive('delete')->andReturn(true);
        $this->productRepo->shouldReceive('deleteFileImage')->andReturn('a.png');
        $response = $this->controller->destroy($this->product->id);
        $this->assertEquals(route('products.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testDeleteProductFalse()
    {
        $image = Image::factory(3)->make();
        $this->productRepo->shouldReceive('find')->andReturn($this->product);
        $this->imageRepo->shouldReceive('getImageByProductId')->andReturn($image);
        $this->productRepo->shouldReceive('delete')->andReturn(false);
        $response = $this->controller->destroy($this->product->id);
        $this->assertEquals(route('products.index'), $response->headers->get('Location'));
    }

    public function testDeleteImageProductSuccess()
    {
        $image = Mockery::mock(Image::class)->makePartial();
        $image->id = 1;
        $this->imageRepo->shouldReceive('find')->andReturn($image);
        $this->imageRepo->shouldReceive('deleteFileImage')->andReturn('a.png');
        $response = $this->controller->deleteimage($image->id);
        $this->assertArrayHasKey('mess', session()->all());
    }
}
