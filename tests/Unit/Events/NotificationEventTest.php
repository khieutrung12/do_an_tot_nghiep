<?php

namespace Tests\Unit\Events;

use Mockery;
use Tests\TestCase;
use App\Models\Order;
use App\Events\NotificationEvent;
use Illuminate\Broadcasting\PrivateChannel;

class NotificationEventTest extends TestCase
{
    public $data;
    protected function setUp(): void
    {
        parent::setUp();
        $this->data = Mockery::mock(Order::class)->makePartial();
    }

    public function testBroadcastOn()
    {
        $this->data->user_id = 1;
        $event = new NotificationEvent($this->data);

        $response = $event->broadcastOn();
        $this->assertSame($this->data, $event->order);
        $this->assertInstanceOf(PrivateChannel::class, $response);
        $this->assertEquals('private-order.1', $response->name);
    }
}
