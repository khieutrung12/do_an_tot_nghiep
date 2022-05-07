<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $product;

    public function setup(): void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function tearDown(): void
    {
        unset($this->product);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->product->getKeyName());
    }

    public function testProductHasManyImages()
    {
        $relation =  $this->product->images();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('product_id', $relation->getForeignKeyName());
    }

    public function testProductBeLongsToManyCategory()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->product->category());
    }

    public function testProductBeLongsToManyOrders()
    {
        $relation = $this->product->orders();
        $this->assertInstanceOf(BelongsToMany::class, $this->product->orders());
        $this->assertEquals('product_id', $relation->getForeignPivotKeyName());
    }

    public function testProductBeLongsToBrand()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->product->brand());
    }

    public function testFillable()
    {
        $inputs = [
            'brand_id',
            'category_id',
            'name',
            'slug',
            'quantity',
            'price',
            'description',
            'image_thumbnail',
        ];

        $this->assertEquals($inputs, $this->product->getFillable());
    }
}
