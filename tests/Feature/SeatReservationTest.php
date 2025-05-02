<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Seat;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\EventSeatPurchase;

class SeatReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group feature
     */
    public function test_a_seat_can_be_reserved()
    {
        // Create the event first
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'user_id' => $user->id
        ]);
        // Now create a seat associated with that event
        $seat = Seat::factory()->create([
            'event_id' => $event->id,  // Ensure the seat is associated with the created event
            'is_reserved' => 0,
            'is_sold' => 0
        ]);
        $this->assertFalse($seat->isReserved());

        // Post request to reserve the seat
        $response = $this->post('/seats/' . $seat->id . '/reserve', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
        $response->assertStatus(200); // Check for successful request

        // Assert the seat is now reserved after the action
        $seat->refresh();
        $this->assertTrue($seat->isReserved());
    }
}
