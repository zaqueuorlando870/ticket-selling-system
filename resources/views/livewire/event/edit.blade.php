


<x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Edit Event') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 bg-white rounded-lg shadow">
                <h2 class="mb-4 text-2xl font-semibold">Edit Event</h2>
        
                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="mb-4 text-green-600">{{ session('message') }}</div>
                @endif
        
                <!-- Edit Form -->
                <form wire:submit.prevent="update">
                    <div class="mb-4">
                        <label for="title" class="block font-medium text-gray-700">Title</label>
                        <input type="text" id="title" wire:model="title" class="block w-full p-3 mt-2 border rounded" required />
                        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="price" class="block font-medium text-gray-700">Price</label>
                        <input type="number" id="price" wire:model="price" class="block w-full p-3 mt-2 border rounded" required />
                        @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="event_date" class="block font-medium text-gray-700">Event Date</label>
                        <input type="date" id="event_date" wire:model="event_date" class="block w-full p-3 mt-2 border rounded" required />
                        @error('event_date') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="flex items-center justify-between">
                        <button type="submit" class="px-6 py-3 text-white bg-blue-600 rounded">Update Event</button>
                        <a href="{{ route('event.index') }}" class="text-gray-600">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>