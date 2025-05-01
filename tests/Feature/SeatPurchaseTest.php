<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Seat;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class SeatPurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_purchase_ticket(): void
    {
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'user_id' => $user->id
        ]);
       
        // Now create a seat associated with that event
        $seat = Seat::factory()->create([
            'event_id' => $event->id,  // Ensure the seat is associated with the created event
            'is_reserved' => false,
            'is_sold' => false
        ]);

        
        $this->assertFalse($seat->isSold());

        // Post request to purchase the seat
        $response = $this->post('/seats/' . $seat->id . '/purchase', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
        $response->assertStatus(200); // Check for successful request

        // Assert the seat is now sold after the action
        $seat->refresh();
        $this->assertTrue($seat->isSold());

        $response->assertStatus(200);
    }
}
