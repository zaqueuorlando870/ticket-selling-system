<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Seat;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class SeatReservationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        User::factory()->create();
        Event::factory()->create(['id' => 6]);
    }

    public function test_seat_can_be_reserved()
    {
        $seat = Seat::factory()->create(['event_id' => 6, 'is_reserved' => false]);

        $this->post('/reserve-seat', ['id' => $seat->id]);

        $this->assertTrue($seat->fresh()->is_reserved);
    }
}
