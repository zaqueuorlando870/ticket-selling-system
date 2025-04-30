<?php

namespace App\Livewire\Guest;

use Livewire\Component;
use App\Models\Event;


class EventCatalog extends Component
{
    public $events;

    public function mount()
    {
        $this->events = Event::with('media')->latest()->get();
    }
    public function render()
    {
        return view('livewire.guest.event-catalog')->layout('layouts.guest');
    }
}
