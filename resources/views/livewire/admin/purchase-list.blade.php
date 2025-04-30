


<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('All Purchases') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="py-6">
            <!-- Grid Container -->
            <div class="grid grid-cols-12 sm:grid-cols-12 md:grid-cols-12 lg:grid-cols-1 gap-6">

                <div class="p-6 bg-white rounded shadow"> 
                
                    <div class="flex flex-wrap gap-4 mb-4">
                        <input
                            type="text"
                            wire:model.debounce.300ms="search"
                            placeholder="Search by name or email"
                            class="border px-4 py-2 rounded w-full sm:w-1/3"
                        >
                
                        <select wire:model="eventId" class="border px-4 py-2 rounded w-full sm:w-1/3">
                            <option value="">All Events</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <table class="min-w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Event</th>
                                <th class="px-4 py-2 border">Seat ID</th>
                                <th class="px-4 py-2 border">Attendee Name</th>
                                <th class="px-4 py-2 border">Email</th>
                                <th class="px-4 py-2 border">Reserved At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($purchases as $seat)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $seat->event->title ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $seat->id }}</td>
                                    <td class="px-4 py-2 border">{{ $seat->reservedBy->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $seat->reservedBy->email ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $seat->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center px-4 py-4">No purchases found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>