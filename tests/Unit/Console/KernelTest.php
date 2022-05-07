<?php

namespace Tests\Unit\Console\Commands;

use Mockery as m;
use Tests\TestCase;
use App\Console\Kernel;
use Illuminate\Console\Scheduling\Schedule;

class KernelTest extends TestCase
{
    public $kernelConsole;

    public function setUp(): void
    {
        parent::setUp();
        $this->kernelConsole = $this->app->make(Kernel::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->kernelConsole);
    }

    public function testSchedule()
    {
        $schedule = m::mock(Schedule::class)->makePartial();
        $schedule->shouldReceive('command->sundays->at->timezone')->andReturn(true);
        $response = $this->kernelConsole->schedule($schedule);

        $this->assertNull($response);
    }
}
