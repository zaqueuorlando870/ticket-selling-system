<?php

namespace App\Livewire\Event;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;
    public $title, $description, $price, $event_date, $image;

    public function save()
    {
        $this->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'event_date' => 'required|date',
            'image' => 'nullable|image|max:2048',
        ]);


        $event = Auth::user()->event()->create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'event_date' => $this->event_date,
        ]);

        if ($this->image) {
            $event->addMedia($this->image->getRealPath())
            ->usingFileName($this->image->getClientOriginalName())
            ->toMediaCollection('event_images');
        }

        $event->generateSeats();

        session()->flash('message', 'Event created successfully.');

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.event.create')->layout('layouts.app');
    }
}
