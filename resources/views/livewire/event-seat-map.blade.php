<div>
    <h2 class="text-2xl font-bold mb-4">Seat Map for: {{ $event->title }}</h2>

    <!-- Seat Grid -->
    <div class="grid grid-cols-10 gap-2">
        @foreach ($event->seats as $seat)
        <div wire:click="toggleSeatStatus({{ $seat->id }})"
            class="w-12 h-12 flex items-center justify-center border rounded cursor-pointer
            {{ $seat->isAvailable() ? 'bg-green-500 text-white' : ($seat->isReserved() ? 'bg-red-500 text-white' : 'bg-gray-500 text-white') }}"
            title="Status: {{ ucfirst($seat->isAvailable() ? 'Available' : ($seat->isReserved() ? 'Reserved' : 'Sold')) }}">

           {{ $seat->label }}
       </div>
        @endforeach
    </div>

    <!-- Legend -->
    <div class="flex space-x-6 mt-6">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-green-500 rounded"></div>
            <span>Available</span>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-red-500 rounded"></div>
            <span>Reserved</span>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('event.index') }}" class="text-blue-600 hover:underline">← Back to Events</a>
    </div>
</div>
