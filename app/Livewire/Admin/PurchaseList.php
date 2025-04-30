<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Seat;
use App\Models\Event;
use Livewire\WithPagination;


class PurchaseList extends Component
{
    use WithPagination;
 
    public $search = '';
    public $eventId = '';
    public $events;

    public function mount()
    {
        $this->events = Event::all();
    }

    public function render()
    {
        $purchases = Seat::with(['event', 'reservedBy'])
        ->where('is_reserved', 1)
        ->when($this->eventId, fn($query) =>
            $query->where('event_id', $this->eventId))
        ->whereHas('reservedBy', function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
        })
        ->orderByDesc('updated_at')
        ->get();

    return view('livewire.admin.purchase-list', compact('purchases'))->layout('layouts.app');
    }
}
