


<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Event') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4">Edit Event</h2>
        
                <!-- Success Message -->
                @if (session()->has('message'))
                    <div class="mb-4 text-green-600">{{ session('message') }}</div>
                @endif
        
                <!-- Edit Form -->
                <form wire:submit.prevent="update">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-medium">Title</label>
                        <input type="text" id="title" wire:model="title" class="mt-2 block w-full p-3 border rounded" required />
                        @error('title') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700 font-medium">Price</label>
                        <input type="number" id="price" wire:model="price" class="mt-2 block w-full p-3 border rounded" required />
                        @error('price') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="mb-4">
                        <label for="event_date" class="block text-gray-700 font-medium">Event Date</label>
                        <input type="date" id="event_date" wire:model="event_date" class="mt-2 block w-full p-3 border rounded" required />
                        @error('event_date') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
        
                    <div class="flex justify-between items-center">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded">Update Event</button>
                        <a href="{{ route('events.index') }}" class="text-gray-600">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>