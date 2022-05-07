<?php

namespace Tests\Unit\Broadcasting;

use App\Models\User;
use Tests\TestCase;
use App\Broadcasting\OrderChannel;

class OrderChannelTest extends TestCase
{
    protected $broadcast;

    public function setUp(): void
    {
        parent::setUp();
        $this->broadcast = new OrderChannel();
    }

    public function tearDown(): void
    {
        unset($this->broadcast);
        parent::tearDown();
    }

    public function testJoinAbilityTrue()
    {
        $auth_user = User::factory()->make();
        $auth_user->id = 1;

        $user_want_connect = User::factory()->make();
        $user_want_connect->id = 1;

        $result = $this->broadcast->join($auth_user, $user_want_connect);

        $this->assertTrue($result);
    }

    public function testJoinAbilityFalse()
    {
        $auth_user = User::factory()->make();
        $auth_user->id = 1;

        $user_want_connect = User::factory()->make();
        $user_want_connect->id = 2;

        $result = $this->broadcast->join($auth_user, $user_want_connect);

        $this->assertFalse($result);
    }
}
