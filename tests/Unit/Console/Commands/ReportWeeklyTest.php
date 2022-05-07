<?php

namespace Tests\Unit\Console\Commands;

use Tests\TestCase;
use Mockery as m;
use App\Models\User;
use app\Console\Commands\ReportWeekly;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReportWeeklyTest extends TestCase
{
    protected $userRepo;
    protected $orderRepo;
    protected $reportWeeklyCommand;

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepo = m::mock(UserRepositoryInterface::class)->makePartial();
        $this->orderRepo = m::mock(OrderRepositoryInterface::class)->makePartial();
        $this->reportWeeklyCommand = new ReportWeekly($this->userRepo, $this->orderRepo);
    }

    public function tearDown(): void
    {
        m::close();
        unset($this->userRepo);
        unset($this->genderRepo);
        unset($this->reportWeeklyCommand);
        parent::tearDown();
    }

    public function testSignature()
    {
        $signature = 'report:weekly';
        $this->assertEquals($signature, $this->reportWeeklyCommand->signature);
    }

    public function testHandle()
    {
        Mail::fake();
        $user = User::factory()->make();
        $this->userRepo->shouldReceive('getEmailVerified')
            ->andReturn($user->email);
        $this->orderRepo->shouldReceive('getOrdersOnWeek');

        $this->reportWeeklyCommand->handle();
        // $this->artisan('report:weekly')->assertExitCode(0);
    }
}
