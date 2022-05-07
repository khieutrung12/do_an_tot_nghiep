<?php

namespace Tests\Unit\Models;

use App\Models\OrderStatus;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatusTest extends TestCase
{
    protected $order_status;

    public function setUp(): void
    {
        parent::setUp();
        $this->order_status = new OrderStatus();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->order_status);
    }

    public function testHasManyRelation()
    {
        $relation = $this->order_status->orders();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('order_status_id', $relation->getForeignKeyName());
    }
}
