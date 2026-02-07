<x-app-layout>
    <x-slot name="header">
        My Events
    </x-slot>

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-stone-900">Upcoming Schedule</h3>
        <a href="{{ route('events.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Schedule New Event
        </a>
    </div>

    @if($events->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-stone-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-stone-50 text-stone-500 text-xs uppercase font-semibold">
                <tr>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Recipient</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4">Gift</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                @foreach($events as $event)
                    <tr class="hover:bg-stone-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-bold text-stone-800 block">{{ $event->title }}</span>
                            <span class="text-xs text-stone-500 capitalize">{{ $event->type }}</span>
                        </td>
                        <td class="px-6 py-4 text-stone-700">
                            {{ $event->recipient->name }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-stone-700">
                                <svg class="w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $event->event_date->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($event->gift)
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded bg-stone-100 overflow-hidden">
                                        <img src="{{ $event->gift->image_path }}" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-sm text-stone-700">{{ $event->gift->name }}</span>
                                </div>
                            @else
                                <span class="text-xs text-stone-400 italic">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($event->payment)
                                @if($event->payment->status == 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Processing</span>
                                @endif
                            @elseif($event->gift)
                                <a href="{{ route('payments.create', $event->id) }}" class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-brand-600 text-white hover:bg-brand-700 shadow-sm transition">
                                    Pay Now
                                </a>
                            @else
                                <span class="text-xs text-stone-400">Select Gift</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-12 text-center">
            <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900 mb-2">No scheduled events yet</h3>
            <p class="text-stone-500 mb-6">Create your first event and we'll remind you when it's time to send a gift.</p>
            <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-brand-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-brand-700 transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Schedule Your First Event
            </a>
        </div>
    @endif
</x-app-layout>
