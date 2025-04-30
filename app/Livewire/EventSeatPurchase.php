<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use App\Models\Seat;

class EventSeatPurchase extends Component
{
    public $eventId;
    public $event;
    public $seats;
    public $selectedSeat;
    public $first_name;
    public $last_name;
    public $email;

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email',
        'selectedSeat' => 'required|exists:seats,id',
    ];


    public function mount($eventId)
    {
        $this->eventId = $eventId;
        $this->event = Event::findOrFail($this->eventId);
        $this->seats = Seat::where('event_id', $this->eventId)->where('is_reserved', 0)->get();
    }

    public function render()
    {
        return view('livewire.event-seat-purchase')->layout('layouts.app');
    }

    public function selectSeat($id)
    {
        $this->selectedSeat = $id;
    }

    public function purchaseSeat()
    {
        $this->validate();

        $seat = Seat::where('id', $this->selectedSeat)
            ->where('event_id', $this->eventId)
            ->where('is_reserved', 0)
            ->first();
    
        if (!$seat) {
            session()->flash('error', 'This seat is already taken or invalid.');
            return;
        }
    
        // Create the user (attendee)
        $user = User::firstOrCreate(
            ['email' => $this->email],
            [
                'name' => $this->first_name . ' ' . $this->last_name,
                'password' => bcrypt('temporarypassword'),
            ]
        );
    
        $user->assignRole('attendee');
    
        // Reserve the seat
        $seat->update([
            'is_reserved' => 1,
            'reserved_by' => $user->id,
        ]);
    
        session()->flash('message', 'Seat purchased successfully and attendee information saved!');
    }
}

