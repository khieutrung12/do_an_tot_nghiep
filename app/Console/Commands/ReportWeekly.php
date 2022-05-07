<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;

class ReportWeekly extends Command
{
    protected $userRepo;
    protected $orderRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'report:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send weekly sales report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        parent::__construct();
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emails = $this->userRepo->getEmailVerified();

        $fromDate = date('Y-m-d H:i:s', strtotime('-1 week', strtotime(date('Y-m-d'))));
        $toDate = date('Y-m-d H:i:s');
        $orders = $this->orderRepo->getOrdersOnWeek($fromDate, $toDate);

        foreach ((array) $emails as $email) {
            Mail::to($email)->send(new NotificationMail($orders));
        }
    }
}
