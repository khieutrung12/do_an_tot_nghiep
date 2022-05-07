<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Image;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $image;

    public function setup(): void
    {
        parent::setUp();
        $this->image = new Image();
    }

    public function tearDown(): void
    {
        unset($this->image);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->image->getKeyName());
    }

    public function testImageBelongsToProduct()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->image->product());
    }

    public function testFillable()
    {
        $inputs = [
            'product_id',
            'image',
        ];

        $this->assertEquals($inputs, $this->image->getFillable());
    }
}
