<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $order;

    public function setup(): void
    {
        parent::setUp();
        $this->order = new Order();
    }

    public function tearDown(): void
    {
        unset($this->order);
        parent::tearDown();
    }

    public function testPrimaryKey()
    {
        $this->assertEquals('id', $this->order->getKeyName());
    }

    public function testOrderBelongsToManyProducts()
    {
        $relation = $this->order->products();
        $this->assertInstanceOf(BelongsToMany::class, $relation);
        $this->assertEquals('order_id', $relation->getForeignPivotKeyName());
    }

    public function testOrderBelongsToOrderStatus()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->orderStatus());
    }

    public function testOrderBelongsToVoucher()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->voucher());
    }

    public function testOrderBelongsToUser()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->user());
    }

    public function testOrderBelongsToShipping()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->shipping());
    }

    public function testFillable()
    {
        $inputs = [
            'user_id',
            'voucher_id',
            'order_status_id',
            'code',
            'sum_price',
            'shipping_id',
        ];

        $this->assertEquals($inputs, $this->order->getFillable());
    }
}
