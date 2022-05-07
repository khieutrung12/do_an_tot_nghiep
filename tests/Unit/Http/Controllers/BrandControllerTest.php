<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\Brand;
use Illuminate\Http\Response;
use App\Http\Requests\Brand\StoreRequest;
use App\Http\Requests\Brand\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\BrandController;
use App\Repositories\Brand\BrandRepositoryInterface;

class BrandControllerTest extends Testcase
{
    protected $brandRepo;
    protected $brandController;

    public function setUp(): void
    {
        parent::setUp();
        $this->brandRepo = m::mock(BrandRepositoryInterface::class)->makePartial();
        $this->brandController = new BrandController($this->brandRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->brandRepo);
        unset($this->brandController);
        parent::tearDown();
    }

    public function testIndexBrand()
    {
        $this->brandRepo->shouldReceive('getAll');
        $view = $this->brandController->index();

        $this->assertEquals('admin.brand.all_brand', $view->getName());
        $this->assertArrayHasKey('all_brand', $view->getData());
    }

    public function testCreateBrand()
    {
        $view = $this->brandController->create();

        $this->assertEquals('admin.brand.add_brand', $view->getName());
    }

    public function testStoreBrand()
    {
        $brand = Brand::factory()->make();
        $input = [
            'name' => $brand->name,
            'slug' => $brand->slug,
        ];

        $this->brandRepo->shouldReceive('create');
        $request = new StoreRequest($input);
        $response = $this->brandController->store($request);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('brands.create'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testEditBrandSuccess()
    {
        $brand = Brand::factory()->make();
        $this->brandRepo->shouldReceive('find')
            ->andReturn($brand);
        $view = $this->brandController->edit($brand->id);

        $this->assertEquals('admin.brand.edit_brand', $view->getName());
        $this->assertArrayHasKey('edit_brand', $view->getData());
    }

    public function testEditBrandFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $brand = Brand::factory()->make();
            $this->brandRepo->shouldReceive('find')
            ->andReturn(false);
            $this->brandController->edit($brand->id);
        });
    }

    public function testUpdateBrandSuccess()
    {
        $brand = Brand::factory()->make();
        $input = [
            'id' => $brand->id,
            'name' => $brand->name,
            'slug' => $brand->slug,
        ];
        $this->brandRepo->shouldReceive('update')
            ->andReturn($brand);
        $request = new UpdateRequest($input);
        $response = $this->brandController->update($request, $brand->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('brands.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testUpdateBrandFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $brand = Brand::factory()->make();
            $input = [
                'id' => $brand->id,
                'name' => $brand->name,
                'slug' => $brand->slug,
            ];
            $this->brandRepo->shouldReceive('update')
                ->andReturn(false);
            $request = new UpdateRequest($input);
            $this->brandController->update($request, $brand->id);
        });
    }

    public function testDestroyBrandSuccess()
    {
        $brand = Brand::factory()->make();
        $this->brandRepo->shouldReceive('delete')
            ->andReturn(true);
        $response = $this->brandController->destroy($brand->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('brands.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testDestroyBrandFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $brand = Brand::factory()->make();
            $this->brandRepo->shouldReceive('delete')
                ->andReturn(false);
            $this->brandController->destroy($brand->id);
        });
    }
}
