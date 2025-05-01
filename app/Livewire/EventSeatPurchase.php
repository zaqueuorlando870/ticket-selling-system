<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Services\SeatReservationService;
use App\Services\UserService;
use App\Services\EventDataService;
use App\Models\Event;

class EventSeatPurchase extends Component
{
    public int $eventId;
    public Event $event;
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
        $eventDataService = app(EventDataService::class);
        try {
            $eventData = $eventDataService->getEventData($eventId);
            $this->event = $eventData;
            $this->seats = $eventData;
        } catch (\Exception $e) {
            Log::error('Error fetching event data: ' . $e->getMessage());
            throw $e;
        }
    }


    public function render()
    {
        return view('livewire.event-seat-purchase')->layout('layouts.app');
    }

    public function selectSeat($id)
    {
        $this->selectedSeat = $id;
    }

    public function reserve($seatId)
    {
        $seatReservationService = app(SeatReservationService::class);
        $seatReservationService->reserveSeat($seatId, request('user_id'));
        $seat = $seatReservationService->find($seatId);
        $seat->is_reserved = true;
        $seat->save();
    }

    public function purchase($seatId){
        dd($seatId);
        $seatReservationService = app(SeatReservationService::class);
        $seatReservationService->purchaseTicket($seatId, request('user_id'));
        $seat = $seatReservationService->find($seatId);
        $seat->is_sold = true;
        $seat->save();
    }


    public function purchaseSeat($seatId = null, $eventId = null)
    {
        if (is_null($seatId) && is_null($eventId)) {
            $seatId = $this->selectedSeat;
            $eventId = $this->eventId;
        } else {
            $this->selectedSeat = $seatId;
            $this->eventId = $eventId;
        }
        $this->validate();
        $seatReservationService = app(SeatReservationService::class);
        $userService = app(\UserService::class);
        $seat = $seatReservationService->getAvailableSeat($this->selectedSeat, $this->eventId);
        if (!$seat) {
            session()->flash('error', 'This seat is already taken or invalid.');
            return;
        }

        // Create the user (attendee)
        $userData = [
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'password' => Str::random(16),
        ];
        try {
            $user = $userService->register($userData);
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to create attendee user: ' . $e->getMessage());
            return;
        }

        // Reserve the seat
        try {
            // Attempt to reserve the seat
            $seatReservationService->reserveSeat($seat->id, $user->id);
            // Flash a success message
            session()->flash('message', 'Seat purchased successfully and attendee information saved!');
        } catch (\Exception $e) {
            // Flash an error message if the seat reservation fails
            session()->flash('error', $e->getMessage());
        }
    }
}
