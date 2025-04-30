<?php

namespace App\Livewire\Event;

use Livewire\Component;
use App\Models\Event as Listings;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $events;

    protected $listeners = ['deleteConfirmed'];

    public function mount()
    {
        $this->events = Auth::user()->event;
    }

    public function deleteConfirmed($eventId)
    {
        $event = Listings::findOrFail($eventId);

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
