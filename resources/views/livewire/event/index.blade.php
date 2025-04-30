<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('My Events') }}
    </h2>
</x-slot>

<div class="py-12" wire:init>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search -->
        <div class="mb-6 flex flex-wrap gap-4 items-center">
            <input
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Search events..."
                class="border border-gray-300 px-4 py-2 rounded w-full sm:w-1/3"
            >
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @if ($events && $events->count())
            @forelse ($events as $event)
                <div x-data="{ showSeats: false, confirmDelete: false }" class="bg-white shadow rounded overflow-hidden flex flex-col">
                    @if ($event->getFirstMediaUrl('event_images'))
                        <img src="{{ $event->getFirstMediaUrl('event_images') }}"
                             alt="Event Image"
                             class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">{{ $event->title }}</h3>
                            <p class="text-sm text-gray-600 mb-3">Price: ${{ $event->price }}</p>
                        </div>

                        <div class="space-y-2">
                            <button @click="showSeats = true" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                View Seats
                            </button>
                            <a href="{{ route('event.edit', $event->id) }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</a>
                            <button @click="confirmDelete = true" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete</button>
                        </div>
                    </div>

                    <!-- Confirm Delete Modal -->
                    <div x-show="confirmDelete" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded shadow-lg">
                            <p class="text-lg mb-4">Are you sure you want to delete this event?</p>
                            <div class="flex justify-end space-x-4">
                                <button @click="confirmDelete = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                <button
                                    @click="$wire.deleteConfirmed({{ $event->id }}); confirmDelete = false"
                                    class="px-4 py-2 bg-red-600 text-white rounded">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Map Modal -->
                    <div x-show="showSeats" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded shadow-lg">
                            @livewire('event-seat-map', ['event' => $event], key($event->id))
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-600">
                    No events found.
                </div>
            @endforelse
            @endif
        </div> 
    </div>
</div>
