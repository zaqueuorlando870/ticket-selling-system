<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use App\Models\Seat;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;
use App\Jobs\AttemptSeatPurchase;

class GuestPurchaseTest extends TestCase
{
    use RefreshDatabase, InteractsWithSession;

    /**
     * @group feature
     */
    public function test_guest_can_purchase_a_seat()
    {
        // Create an event and a seat
        $event = Event::factory()->create();
        $seat = Seat::factory()->create([
            'event_id' => $event->id,  // Ensure the seat is associated with the created event
            'is_reserved' => false,
            'is_sold' => false
        ]);

        $this->assertFalse($seat->isSold());
        // Create an existing user
        $user = User::factory()->create();
        // Post request using existing email
        $response = $this->post('/seats/' . $seat->id . '/guest', [
            'name' => $user->name,
            'email' => $user->email,
            'id' => $seat->id
        ]);

        // Assert the seat is now sold after the action
        $seat->refresh();
        $this->assertTrue($seat->isSold());

        $response->assertStatus(200);
    }


    /**
     * @group feature
     */
    public function test_only_one_guest_can_purchase_a_seat_when_many_guests_attempt_to_purchase_the_same_seat()
    {
        // Create an event and a seat
        $event = Event::factory()->create();
        $seat = Seat::factory()->create([
            'event_id' => $event->id,  // Ensure the seat is associated with the created event
            'is_reserved' => false,
            'is_sold' => false
        ]);

        $this->assertFalse($seat->isSold());
        // Create an existing user
        $users = User::factory(100)->create();
        // Post request using existing email
        $response = [];
        foreach ($users as $user) {
            $response = $this->post('/seats/' . $seat->id . '/guest', [
                'name' => $user->name,
                'email' => $user->email,
                'id' => $seat->id
            ]);
        }

        // Assert the seat is now sold after the action
        $seat->refresh();
        $this->assertTrue($seat->isSold());

        $response->assertStatus(200);

    }
}
