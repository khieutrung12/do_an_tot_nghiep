<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\ShopController;
use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;

class ShopControllerTest extends Testcase
{
    protected $brandRepo;
    protected $productRepo;
    protected $shopController;

    public function setUp(): void
    {
        parent::setUp();
        $this->brandRepo = m::mock(BrandRepositoryInterface::class)->makePartial();
        $this->productRepo = m::mock(ProductRepositoryInterface::class)->makePartial();
        $this->shopController = new ShopController($this->brandRepo, $this->productRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->brandRepo);
        unset($this->productRepo);
        unset($this->shopController);
        parent::tearDown();
    }

    public function testIndexShop()
    {
        $this->brandRepo->shouldReceive('getBrands');
        $this->productRepo->shouldReceive('getProduct');
        $view = $this->shopController->index();

        $this->assertEquals('shop', $view->getName());
        $this->assertArrayHasKey('brands', $view->getData());
        $this->assertArrayHasKey('products', $view->getData());
    }

    public function testShowShopSuccess()
    {
        $product = Product::factory()->make();
        $this->productRepo->shouldReceive('findBySlug')
            ->andReturn($product);
        $view = $this->shopController->show($product->slug);

        $this->assertEquals('show', $view->getName());
        $this->assertArrayHasKey('product', $view->getData());
    }
}
