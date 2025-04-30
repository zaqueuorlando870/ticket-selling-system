<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Seat;
use Livewire\Component;

class EventSeatMap extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function toggleSeatStatus($seatId)
    {
        $seat = Seat::find($seatId);

        if (!$seat) {
            session()->flash('error', 'Seat not found.');
            return;
        }

        switch ($seat->status) {
            case 'available':
                $seat->status = 'reserved';
                break;
            case 'reserved':
                $seat->status = 'sold';
                break;
            case 'sold':
                $seat->status = 'available';
                break;
        }

        $seat->save();
        $this->refreshSeats(); // Optional: refresh seat map
    }

    public function refreshSeats()
    {
        $this->seats = Seat::where('event_id', $this->event->id)->get();
    }

    public function render()
    {
        return view('livewire.event-seat-map');
    }
}
