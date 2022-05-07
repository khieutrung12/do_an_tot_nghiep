<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Shipping;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ShippingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $shipping;

    public function setup(): void
    {
        parent::setUp();
        $this->shipping = new Shipping();
    }

    public function tearDown(): void
    {
        unset($this->shipping);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->shipping->getKeyName());
    }

    public function testShippingHasOneOrder()
    {
        $relation =  $this->shipping->orders();
        $this->assertInstanceOf(HasOne::class, $this->shipping->orders());
        $this->assertEquals('shipping_id', $relation->getForeignKeyName());
    }

    public function testFillable()
    {
        $inputs = [
            'name',
            'address',
            'phone',
            'note',
            'email'
        ];

        $this->assertEquals($inputs, $this->shipping->getFillable());
    }
}
