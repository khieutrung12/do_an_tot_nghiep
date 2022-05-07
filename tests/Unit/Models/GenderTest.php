<?php

namespace Tests\Unit\Models;

use App\Models\Gender;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GenderTest extends TestCase
{
    protected $gender;

    public function setUp(): void
    {
        parent::setUp();
        $this->gender = new Gender();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->gender);
    }

    public function testHasManyRelation()
    {
        $relation = $this->gender->users();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertEquals('gender_id', $relation->getForeignKeyName());
    }
}
