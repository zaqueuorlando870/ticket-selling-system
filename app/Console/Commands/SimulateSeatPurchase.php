<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\AttemptSeatPurchase;

class SimulateSeatPurchase extends Command
{
    protected $signature = 'simulate:seat-purchase {seatId}';

    protected $description = 'Simulate 100+ users trying to buy the same seat';

    public function handle()
    {
        $seatId = $this->argument('seatId');
        $jobs = [];
        for ($i = 1; $i <= 100; $i++) {
            $jobs[] = new AttemptSeatPurchase($seatId, $i);
        }

        Bus::batch($jobs)->dispatch();

        $this->info("Simulation dispatched.");
    }
}