<x-app-layout>
    <x-slot name="header">
        Schedule New Event
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm border border-stone-200 rounded-2xl p-8">
            <form method="POST" action="{{ route('events.store') }}">
                @csrf

                <div class="mb-8">
                    <h4 class="text-stone-900 font-bold mb-4 border-b border-stone-100 pb-2">Event Details</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-stone-700 mb-1">Event Title</label>
                            <input type="text" name="title" placeholder="e.g. Mom's Birthday" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-stone-700 mb-1">Date</label>
                            <input type="date" name="event_date" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-stone-700 mb-1">Type</label>
                            <select name="type" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-8" x-data="{ mode: 'new' }">
                    <h4 class="text-stone-900 font-bold mb-4 border-b border-stone-100 pb-2">Who is this for?</h4>

                    @if($recipients->count() > 0)
                        <div class="flex gap-4 mb-4 text-sm">
                            <button type="button" @click="mode = 'existing'" :class="mode === 'existing' ? 'text-brand-600 font-bold underline' : 'text-stone-500'">Select Existing</button>
                            <button type="button" @click="mode = 'new'" :class="mode === 'new' ? 'text-brand-600 font-bold underline' : 'text-stone-500'">Create New</button>
                        </div>
                    @endif

                    <div x-show="mode === 'existing'" class="mb-4" style="display: none;">
                        <label class="block font-medium text-sm text-stone-700 mb-1">Select Recipient</label>
                        <select name="recipient_id" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                            <option value="">-- Choose --</option>
                            @foreach($recipients as $recipient)
                                <option value="{{ $recipient->id }}">{{ $recipient->name }} ({{ $recipient->relationship }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="mode === 'new'">
                        <label class="block font-medium text-sm text-stone-700 mb-1">New Recipient Name</label>
                        <input type="text" name="new_recipient_name" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-stone-900 font-bold mb-4 border-b border-stone-100 pb-2">Pre-select a Gift (Optional)</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($gifts as $gift)
                            <label class="relative flex cursor-pointer rounded-xl border p-4 shadow-sm focus:outline-none hover:border-brand-500 transition bg-white">
                                <input type="radio" name="gift_id" value="{{ $gift->id }}" class="sr-only peer">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium text-stone-900">{{ $gift->name }}</span>
                                        <span class="mt-1 flex items-center text-xs text-stone-500">{{ $gift->category }}</span>
                                        <span class="mt-2 text-sm font-bold text-brand-600">Rs. {{ number_format($gift->price) }}</span>
                                    </span>
                                </span>
                                <div class="absolute top-4 right-4 h-5 w-5 rounded-full border border-stone-300 peer-checked:bg-brand-600 peer-checked:border-brand-600" aria-hidden="true"></div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block font-medium text-sm text-stone-700 mb-1">Remind me before (days)</label>
                    <input type="number" name="notification_days" value="7" min="1" max="30" class="w-24 rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('events.index') }}" class="text-stone-500 hover:text-stone-700">Cancel</a>
                    <button type="submit" class="bg-brand-600 text-white px-6 py-3 rounded-xl font-bold shadow-md hover:bg-brand-700 transition">
                        Schedule Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
