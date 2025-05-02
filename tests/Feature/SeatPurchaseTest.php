<?php

namespace Tests\Feature;

use App\Jobs\AttemptSeatPurchase;
use App\Models\Seat;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class SeatPurchaseTest extends TestCase
{
    /**
     * @group feature
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

    /**
     * @group feature
     */
    public function it_reserves_a_seat_for_a_user()
    {
        $seat = Seat::factory()->create(['is_reserved' => false]);
        $user = User::factory()->create();

        $job = new AttemptSeatPurchase($seat->id, $user->id);
        $job->handle();

        $this->assertTrue($seat->fresh()->is_reserved);
        $this->assertEquals($user->id, $seat->fresh()->reserved_by);
    }

    /**
     * @group feature
     */
    public function it_fails_to_reserve_a_seat_if_already_reserved()
    {
        $seat = Seat::factory()->create(['is_reserved' => true]);
        $user = User::factory()->create();

        $job = new AttemptSeatPurchase($seat->id, $user->id);
        $job->handle();

        $this->assertFalse($seat->fresh()->reserved_by === $user->id);
    }

    /**
     * @group feature
     */
    public function it_fails_to_reserve_a_seat_if_seat_does_not_exist()
    {
        $user = User::factory()->create();

        $job = new AttemptSeatPurchase(999, $user->id);
        $job->handle();

        $this->assertNull(Seat::find(999));
    }

    /**
     * @group feature
     */
    public function multiple_users_cannot_reserve_the_same_seat()
    {
        $seat = Seat::factory()->create(['is_reserved' => false]);
        $users = User::factory()->create();

        $job1 = new AttemptSeatPurchase($seat->id, $users[0]->id);
        $job1->handle();

        $job2 = new AttemptSeatPurchase($seat->id, $users[1]->id);
        $job2->handle();

        $this->assertTrue($seat->fresh()->is_reserved);
        $this->assertEquals($users[0]->id, $seat->fresh()->reserved_by);
    }

}
