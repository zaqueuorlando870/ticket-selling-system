<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ open: false, eventId: null }">
        <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Upcoming Events</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($events as $event)
                <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-md transition">
                    @if ($event->getFirstMediaUrl('event_images'))
                        <img src="{{ $event->getFirstMediaUrl('event_images') }}"
                             alt="{{ $event->title }}"
                             class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $event->title }}</h3>
                        <p class="text-sm text-gray-600 mt-1 mb-2">{{ \Carbon\Carbon::parse($event->event_date)->toFormattedDateString() }}</p>
                        <p class="text-red-600 font-bold text-sm">Price: ${{ number_format($event->price, 2) }}</p>

                        <!-- On click, set eventId and show the modal -->
                        <button @click="open = true; eventId = {{ $event->id }}" class="mt-4 inline-block text-center w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Purchase Ticket
                        </button>
                    </div>

                    <!-- Modal for each event, shows when clicked -->
                    <div x-show="open && eventId === {{ $event->id }}" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded shadow-lg w-full max-w-lg">
                            <!-- Close the modal when clicked -->
                            <button @click="open = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                &times;
                            </button>

                            <!-- Ensure that the Livewire component reacts to eventId changes -->
                            @livewire('event-seat-purchase', ['eventId' => $event->id], key($event->id))

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
