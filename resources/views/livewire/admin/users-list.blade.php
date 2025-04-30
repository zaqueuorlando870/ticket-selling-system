<div class="bg-white min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">🎉 Explore Our Upcoming Events</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($events as $event)
                <div class="bg-white rounded-xl overflow-hidden shadow-lg transform hover:scale-105 transition duration-300">
                    @if ($event->getFirstMediaUrl('event_images'))
                        <img src="{{ $event->getFirstMediaUrl('event_images') }}"
                             alt="{{ $event->title }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500 text-xl">
                            No Image
                        </div>
                    @endif

                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2 truncate">{{ $event->title }}</h2>
                        <p class="text-gray-600 text-sm mb-1">
                            📅 {{ \Carbon\Carbon::parse($event->event_date)->toFormattedDateString() }}
                        </p>
                        <p class="text-gray-500 text-sm mb-3 h-12 overflow-hidden">
                            {{ \Illuminate\Support\Str::limit($event->description, 70) }}
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-bold text-red-600">${{ number_format($event->price, 2) }}</span>
                        </div>
                        <a href="#" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 rounded-lg font-semibold transition">
                            🎟️ Get Ticket
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    No events available at the moment.
                </div>
            @endforelse
        </div>
    </div>
</div>
