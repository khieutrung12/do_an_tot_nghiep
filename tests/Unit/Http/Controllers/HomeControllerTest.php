<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\HomeController;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class HomeControllerTest extends Testcase
{
    protected $brandRepo;
    protected $productRepo;
    protected $homeController;

    public function setUp(): void
    {
        parent::setUp();
        $this->brandRepo = m::mock(BrandRepositoryInterface::class)->makePartial();
        $this->productRepo = m::mock(ProductRepositoryInterface::class)->makePartial();
        $this->homeController = new HomeController($this->brandRepo, $this->productRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->brandRepo);
        unset($this->productRepo);
        unset($this->homeController);
        parent::tearDown();
    }

    public function testIndexHome()
    {
        $this->productRepo->shouldReceive('getProductTopNew');
        $view = $this->homeController->index();

        $this->assertEquals('home', $view->getName());
        $this->assertArrayHasKey('topNew', $view->getData());
    }

    public function testSearchHome()
    {
        $input = [
            'name' => 'n',
        ];
        $this->productRepo->shouldReceive('search');
        $request = new Request($input);
        $view = $this->homeController->search($request);

        $this->assertEquals('layouts.search', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('key', $view->getData());
    }

    public function testSearchListHomeErrorSearch()
    {
        $key = 'n';
        $this->productRepo->shouldReceive('searchList')
            ->andReturn([]);
        $view = $this->homeController->searchList($key);

        $this->assertEquals('error_search', $view->getName());
    }

    public function testSearchListHomeSuccess()
    {
        $key = 'n';
        $products = Product::factory()->count(3)->make();
        $brand = Brand::factory()->make();
        foreach ($products as $product) {
            $product->setRelation('brand', $brand);
            $product->id = $brand->id;
        }
        $this->productRepo->shouldReceive('searchList')
            ->andReturn($products);
        $view = $this->homeController->searchList($key);

        $this->assertEquals('shop', $view->getName());
        $this->assertArrayHasKey('products', $view->getData());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('key', $view->getData());
        $this->assertArrayHasKey('action', $view->getData());
    }
}
