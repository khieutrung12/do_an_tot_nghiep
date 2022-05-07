<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    public function testFillable()
    {
        $this->assertEquals([
            'name',
            'email',
            'password',
            'phone',
            'address',
            'gender_id',
            'birthday',
            'avatar',
        ], $this->user->getFillable());
    }

    public function testHidden()
    {
        $this->assertEquals([
            'password',
            'remember_token',
            'role_id',
        ], $this->user->getHidden());
    }

    public function testHasManyOrder()
    {
        $relation = $this->user->orders();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    public function testHasManyVoucher()
    {
        $relation = $this->user->vouchers();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    public function testBelongsToRole()
    {
        $relation = $this->user->role();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('role_id', $relation->getForeignKeyName());
    }

    public function testBelongsToGender()
    {
        $relation = $this->user->gender();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertEquals('gender_id', $relation->getForeignKeyName());
    }

    public function testReceivesBroadcastNotificationsChannel()
    {
        $user = User::factory()->make();
        $user->id = 1;

        $this->assertEquals('order.1', $user->receivesBroadcastNotificationsOn());
    }
}
