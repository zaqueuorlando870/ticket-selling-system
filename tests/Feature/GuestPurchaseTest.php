<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Livewire\Livewire;
use App\Models\Seat;
use App\Models\Event;
use App\Livewire\EventSeatPurchase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;

class GuestPurchaseTest extends TestCase
{
    use RefreshDatabase, InteractsWithSession;

    /**
     * @test
     */
    public function test_guest_purchase_fails_if_email_is_already_in_use()
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
        Notification::fake();
        $response = $this->post('/seats/' . $seat->id . '/guest', [
            'name' => $user->name,
            'email' => $user->email,
        ]);   
        
        // Assert the seat is now sold after the action
        $seat->refresh();
        $this->assertFalse($seat->isSold());

        $response->assertStatus(200);
    }
}

