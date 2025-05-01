<?php

namespace App\Livewire\Event;

use Livewire\Component;
use App\Services\EventDataService;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    public $event;
    public $title;
    public $price;
    public $event_date;

    protected $rules = [
        'title' => 'required|string',
        'price' => 'required|numeric',
        'event_date' => 'required|date',
    ];

    public function mount($event)
    {
        $eventDataService = app(EventDataService::class);
        $event = $eventDataService->getEventData($event);

        abort_if($event->user_id !== Auth::id(), 403);

        $this->event = $event;
        $this->title = $event->title;
        $this->price = $event->price;
        $this->event_date = date('Y-m-d\TH:i', strtotime($event->event_date));
    }

    public function update(EventDataService $eventDataService)
    {
        $this->validate();

        $eventDataService->updateEvent($this->event->id, [
            'title' => $this->title,
            'price' => $this->price,
            'event_date' => $this->event_date,
        ]);

        session()->flash('message', 'Event updated successfully.');
        return redirect()->route('event.index');
    }

    public function render()
    {
        return view('livewire.event.edit')->layout('layouts.app');
    }
}
