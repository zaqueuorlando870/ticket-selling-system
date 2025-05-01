<div>
    <a href="{{ url()->previous() }}" class="text-blue-600 hover:underline">
        &larr; Back to Events
    </a>

    @if (session()->has('error'))
        <div class="p-4 mb-4 text-white bg-red-500 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-white bg-green-500 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-10 gap-2">
        @foreach ($event->seats as $seat)
            <div wire:click="selectSeat({{ $seat->id }})"
                class="w-12 h-12 flex items-center justify-center border rounded cursor-pointer
            {{ $seat->isAvailable() ? 'bg-green-500 text-white' : ($seat->isReserved() ? 'bg-red-500 text-white' : 'bg-gray-500 text-white') }}"
                title="Status: {{ ucfirst($seat->isAvailable() ? 'Available' : ($seat->isReserved() ? 'Reserved' : 'Sold')) }}">

                {{ $seat->label }}
            </div>
        @endforeach
    </div>

    @if ($selectedSeat)
    <div class="mt-4">
        <h3 class="text-xl font-semibold">Enter Your Details</h3>

        <form wire:submit.prevent="purchase">
            <div class="mt-2">
                <label for="first_name" class="block">First Name</label>
                <input type="text" id="first_name" wire:model="first_name" class="w-full p-2 mt-1 border rounded" required>
            </div>

            <div class="mt-2">
                <label for="last_name" class="block">Last Name</label>
                <input type="text" id="last_name" wire:model="last_name" class="w-full p-2 mt-1 border rounded" required>
            </div>

            <div class="mt-2">
                <label for="email" class="block">Email</label>
                <input type="email" id="email" wire:model="email" class="w-full p-2 mt-1 border rounded" required>
            </div>

            <button type="submit" class="px-4 py-2 mt-4 text-white bg-blue-600 rounded hover:bg-blue-700">
                Purchase Seat
            </button>
        </form>
    </div>
@endif
</div>
