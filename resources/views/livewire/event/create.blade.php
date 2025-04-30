<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Create Event') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-4">Create Event</h2>
            <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" wire:model="title" placeholder="Event Title"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea wire:model="description" placeholder="Event Description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition h-32 resize-none"></textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <input type="number" wire:model="price" placeholder="e.g., 100.00"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Event Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Event Date</label>
                    <input type="date" wire:model="event_date"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none transition" />
                    @error('event_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <div x-data="{ fileName: null }"
                    class="w-full border-2 border-dashed border-gray-300 rounded p-4 text-center bg-gray-50">
                    <label class="cursor-pointer">
                        <div class="text-gray-500" x-text="fileName ?? 'Click to upload an image (PNG, JPG)'"></div>
                        <input type="file" wire:model="image" @change="fileName = $event.target.files[0].name"
                            class="hidden" />
                    </label>

                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    @if ($image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}" class="w-48 h-48 object-cover rounded mx-auto mt-2">
                        </div>
                    @endif
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
            </form>

        </div>
    </div>
</div>
