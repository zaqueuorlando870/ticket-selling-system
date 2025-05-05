<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Services\SeatReservationService;
use App\Services\EventDataService;
use App\Models\Event;
use App\Services\UserService as GlobalUserService;

class EventSeatPurchase extends Component
{
    public int $eventId;
    public Event $event;
    public $seats;
    public $selectedSeat;
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|string',
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
        try {
            $seatReservationService->reserveSeat($seatId, request('user_id'));
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to purchase ticket: ' . $e->getMessage());
            return;
        }
    }

    public function guestPurchase()
    {
        $data = [
            'name' => $this->name ?? request('name'),
            'email' => $this->email ?? request('email')
        ];
        $userService = app(GlobalUserService::class);
        try {
            $user = $userService->getUserByEmail($this->email);
            if (!$user) {
                $user = $userService->registerGuest($data);
            } 
            request()->merge(['user_id' => $user->id]);
            $this->purchase($this->selectedSeat ?? request('id'));
            session()->flash('status', 'Guest Registered Successfully');
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to Register User: ' . $e->getMessage());
            return;
        }
    }

    public function purchase($seatId)
    {
        $seatReservationService = app(SeatReservationService::class);
        try {
            $seatReservationService->purchaseTicket($seatId, request('user_id'));
            session()->flash('status', 'Your Seat has been purchased successfully! Thank you for your order.');
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to purchase ticket: ' . $e->getMessage());
            return;
        }
    }
}
