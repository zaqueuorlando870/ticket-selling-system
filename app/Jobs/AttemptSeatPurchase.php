<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Seat;

class AttemptSeatPurchase implements ShouldQueue
{ 
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $seatId;
    public $userId;

    public function __construct($seatId, $userId)
    {
        $this->seatId = $seatId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        DB::transaction(function () {
            // Lock the seat row for update to prevent race conditions
            $seat = Seat::where('id', $this->seatId)->lockForUpdate()->first();
    
            // Check if the seat exists
            if (!$seat) {
                info("Seat {$this->seatId} not found.");
                return;
            }
    
            // Check if the seat is already reserved
            if ($seat->is_reserved) {
                info("User {$this->userId} FAILED to buy seat {$this->seatId} - already reserved.");
                return;
            }
    
            // Proceed with reserving the seat
            $seat->is_reserved = true;
            $seat->reserved_by = $this->userId;
            $seat->save();
    
            info("User {$this->userId} successfully reserved seat {$this->seatId}");
        });
    }
}
