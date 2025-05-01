<?php

namespace App\Livewire\Event;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\EventDataService;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    public  $events;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->events = Auth::user()->event;
    }

    public function deleteConfirmed(EventDataService $eventDataService, $eventId)
    {
        try {
            $event = $eventDataService->getEventData($eventId);
        } catch (\Exception $e) {
            Log::error('Error fetching event data: ' . $e->getMessage());
            return;
        }

        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();

        $this->events = Auth::user()->event;

        session()->flash('message', 'event deleted successfully.');
    }

    public function render()
    {
        return view('livewire.event.index')->layout('layouts.app');
    }
}
