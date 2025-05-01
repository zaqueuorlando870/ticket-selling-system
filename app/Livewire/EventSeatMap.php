<?php

namespace App\Livewire;

use App\Services\EventDataService;
use App\Services\SeatReservationService;
use Livewire\Component;

class EventSeatMap extends Component
{
    public $event;

    public function mount($eventId)
    {
        $eventDataService = app(EventDataService::class);

        $this->event = $eventDataService->getEventData($eventId);
    }

    public function toggleSeatStatus(SeatReservationService $seatReservationService, $seatId)
    {
        try {
            $seat = $seatReservationService->find($seatId);
            if (!$seat) {
                session()->flash('error', 'Seat not found.');
                return;
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error fetching seat: ' . $e->getMessage());
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

        $this->refreshSeats($seatReservationService);
    }

    public function refreshSeats(SeatReservationService $seatReservationService)
    {
        $this->seats = $seatReservationService->getAvailableSeats($this->event->id);
    }

    public function render()
    {
        return view('livewire.event-seat-map');
    }
}
