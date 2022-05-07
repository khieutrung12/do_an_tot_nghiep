<?php

namespace Tests\Unit\Http\Controllers;

use Mockery as m;
use Tests\TestCase;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\CategoryController;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryControllerTest extends Testcase
{
    protected $categoryRepo;
    protected $categoryController;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryRepo = m::mock(CategoryRepositoryInterface::class)->makePartial();
        $this->categoryController = new CategoryController($this->categoryRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->categoryRepo);
        unset($this->categoryController);
        parent::tearDown();
    }

    public function testIndexCategory()
    {
        $this->categoryRepo->shouldReceive('getCategoryWhereNull');
        $view = $this->categoryController->index();

        $this->assertEquals('admin.category.all_category', $view->getName());
        $this->assertArrayHasKey('allCategory', $view->getData());
    }

    public function testCreateCategory()
    {
        $this->categoryRepo->shouldReceive('getCategoryWhereNullWithChild');
        $view = $this->categoryController->create();

        $this->assertEquals('admin.category.add_category', $view->getName());
        $this->assertArrayHasKey('categories', $view->getData());
    }

    public function testStoreCategory()
    {
        $category = Category::factory()->make();
        $input = [
            'name' => $category->name,
            'slug' => $category->slug,
        ];

        $this->categoryRepo->shouldReceive('create');
        $request = new StoreRequest($input);
        $response = $this->categoryController->store($request);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('categories.create'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testEditCategorySuccess()
    {
        $category = Category::factory()->make();
        $this->categoryRepo->shouldReceive('find')
            ->andReturn($category);
        $category->id = 1;
        $category->parent_id = null;
        $this->categoryRepo->shouldReceive('getCategoryWhereNullWithChild');
        $view = $this->categoryController->edit($category->id);

        $this->assertEquals('admin.category.edit_category', $view->getName());
        $this->assertArrayHasKey('productCategory', $view->getData());
        $this->assertArrayHasKey('categories', $view->getData());
    }

    public function testEditCategoryFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $category = Category::factory()->make();
            $this->categoryRepo->shouldReceive('find')
                ->andReturn(false);
            $this->categoryController->edit($category->id);
        });
    }

    public function testUpdateCategorySuccess()
    {
        $category = Category::factory()->make();
        $input = [
            'name' => $category->name,
            'slug' => $category->slug,
        ];
        $this->categoryRepo->shouldReceive('update')
            ->andReturn($category);
        $request = new UpdateRequest($input);
        $response = $this->categoryController->update($request, $category->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('categories.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testUpdateCategoryFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $category = Category::factory()->make();
            $input = [
                'name' => $category->name,
                'slug' => $category->slug,
            ];
            $this->categoryRepo->shouldReceive('update')
                ->andReturn(false);
            $request = new UpdateRequest($input);
            $this->categoryController->update($request, $category->id);
        });
    }

    public function testDestroyCategorySuccess()
    {
        $category = Category::factory()->make();
        $this->categoryRepo->shouldReceive('delete')
            ->andReturn(true);
        $response = $this->categoryController->destroy($category->id);

        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('categories.index'), $response->headers->get('Location'));
        $this->assertArrayHasKey('mess', session()->all());
    }

    public function testDestroyCategoryFail()
    {
        $this->assertHTTPExceptionStatus(Response::HTTP_NOT_FOUND, function () {
            $category = Category::factory()->make();
            $this->categoryRepo->shouldReceive('delete')
                ->andReturn(false);
            $this->categoryController->destroy($category->id);
        });
    }
}
