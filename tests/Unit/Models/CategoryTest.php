<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $category;

    public function setup(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function tearDown(): void
    {
        unset($this->category);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->category->getKeyName());
    }

    public function testCategoryBelongsToManyProducts()
    {
        $relation = $this->category->products();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals('category_id', $relation->getForeignPivotKeyName());
    }

    public function testCategoryParentCategory()
    {
        $relation = $this->category->parentCategory();
        $this->assertInstanceOf(BelongsTo::class, $relation);
    }

    public function testCategoryChildCategories()
    {
        $relation = $this->category->childCategories();
        $this->assertInstanceOf(HasMany::class, $this->category->childCategories());
        $this->assertEquals('parent_id', $relation->getForeignKeyName());
    }


    public function testFillable()
    {
        $inputs = [
            'name',
            'slug',
            'parent_id',
        ];

        $this->assertEquals($inputs, $this->category->getFillable());
    }
}
