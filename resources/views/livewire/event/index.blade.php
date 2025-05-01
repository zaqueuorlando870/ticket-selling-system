<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('My Events') }}
    </h2>
</x-slot>

<div class="py-12" wire:init>
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Search -->
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <input
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Search events..."
                class="w-full px-4 py-2 border border-gray-300 rounded sm:w-1/3"
            >
        </div>

        <!-- Event Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @if ($events && $events->count())
            @forelse ($events as $event)
                <div x-data="{ showSeats: false, confirmDelete: false }" class="flex flex-col overflow-hidden bg-white rounded shadow">
                    @if ($event->getFirstMediaUrl('event_images'))
                        <img src="{{ $event->getFirstMediaUrl('event_images') }}"
                             alt="Event Image"
                             class="object-cover w-full h-48">
                    @endif

                    <div class="flex flex-col justify-between flex-1 p-4">
                        <div>
                            <h3 class="mb-1 text-lg font-semibold">{{ $event->title }}</h3>
                            <p class="mb-3 text-sm text-gray-600">Price: ${{ $event->price }}</p>
                        </div>

                        <div class="space-y-2">
                            <button @click="showSeats = true" class="w-full px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
                                View Seats
                            </button>
                            <a href="{{ route('event.edit', $event->id) }}" class="block w-full px-4 py-2 text-center text-white bg-blue-600 rounded hover:bg-blue-700">Edit</a>
                            <button @click="confirmDelete = true" class="w-full px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700">Delete</button>
                        </div>
                    </div>

                    <!-- Confirm Delete Modal -->
                    <div x-show="confirmDelete" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-50">
                        <div class="p-6 bg-white rounded shadow-lg">
                            <p class="mb-4 text-lg">Are you sure you want to delete this event?</p>
                            <div class="flex justify-end space-x-4">
                                <button @click="confirmDelete = false" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
                                <button
                                    @click="$wire.deleteConfirmed({{ $event->id }}); confirmDelete = false"
                                    class="px-4 py-2 text-white bg-red-600 rounded">
                                    Confirm
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Map Modal -->
                    <div x-show="showSeats" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-50">
                        <div class="p-6 bg-white rounded shadow-lg">
                            @livewire('event-seat-map', ['eventId' => $event->id], key($event->id))
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-600 col-span-full">
                    No events found.
                </div>
            @endforelse
            @endif
        </div> 
    </div>
</div>
