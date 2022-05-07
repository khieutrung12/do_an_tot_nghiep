<?php

namespace Tests\Unit\Models;

use App\Models\Role;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleTest extends TestCase
{
    protected $role;

    public function setUp(): void
    {
        parent::setUp();
        $this->role = new Role();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->role);
    }

    public function testHasManyRelation()
    {
        $relation = $this->role->users();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('role_id', $relation->getForeignKeyName());
    }
}
