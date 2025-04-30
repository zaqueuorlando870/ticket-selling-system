<?php

namespace App\Livewire\Event;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public Event $event;
    public $title;
    public $price;
    public $event_date;

    public function mount(Event $event)
    {
        abort_if($event->user_id !== Auth::id(), 403);

        $this->event = $event;
        $this->title = $event->title;
        $this->price = $event->price;
        $this->event_date = date('Y-m-d\TH:i', strtotime($event->event_date)); // Make sure it's in correct format
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'event_date' => 'required|date',
        ]);

        $this->event->update([
            'title' => $this->title,
            'price' => $this->price,
            'event_date' => $this->event_date,
        ]);

        session()->flash('message', 'Event updated successfully.');
        return redirect()->route('events.index');
    }

    public function render()
    {
        return view('livewire.event.edit')->layout('layouts.app');
    }
}