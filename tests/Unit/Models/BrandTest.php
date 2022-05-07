<?php

namespace Tests\Unit\Models;

use App\Models\Brand;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $brand;

    public function setup(): void
    {
        parent::setUp();
        $this->brand = new Brand();
    }

    public function tearDown(): void
    {
        unset($this->brand);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->brand->getKeyName());
    }

    public function testBrandHasManyProducts()
    {
        $relation = $this->brand->products();
        $this->assertInstanceOf(HasMany::class, $this->brand->products());
        $this->assertEquals('brand_id', $relation->getForeignKeyName());
    }

    public function testFillable()
    {
        $inputs = [
            'name',
            'slug',
        ];

        $this->assertEquals($inputs, $this->brand->getFillable());
    }
}
