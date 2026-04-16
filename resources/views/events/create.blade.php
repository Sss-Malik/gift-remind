<x-app-layout>
    <x-slot name="header">
        Schedule New Event
    </x-slot>

    @php
        $selectedGiftId = (string) old('gift_id', request('gift_id', ''));
        if ($selectedGiftId === '' && request()->boolean('suggest_gifts') && $aiSuggestions->isNotEmpty()) {
            $selectedGiftId = (string) $aiSuggestions->first()['gift']->id;
        }
        $suggestedGiftIds = $aiSuggestions->pluck('gift.id')->map(fn ($id) => (string) $id)->all();
    @endphp

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm border border-stone-200 rounded-2xl p-8">
            <form method="POST" action="{{ route('events.store') }}">
                @csrf

                <div class="mb-8">
                    <h4 class="text-stone-900 font-bold mb-4 border-b border-stone-100 pb-2">Event Details</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-stone-700 mb-1">Event Title</label>
                            <input type="text" name="title" value="{{ old('title', request('title')) }}" placeholder="e.g. Mom's Birthday" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-stone-700 mb-1">Date</label>
                            <input type="date" name="event_date" value="{{ old('event_date', request('event_date')) }}" min="{{ $minEventDate }}" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                            <p class="text-xs text-stone-400 mt-1">Events must be scheduled at least 7 days ahead.</p>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-stone-700 mb-1">Type</label>
                            <select name="type" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                @foreach(['birthday' => 'Birthday', 'anniversary' => 'Anniversary', 'custom' => 'Custom'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', request('type', 'birthday')) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-8" x-data="{ mode: '{{ old('recipient_id', request('recipient_id')) ? 'existing' : 'new' }}' }">
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
                                <option value="{{ $recipient->id }}" {{ (string) old('recipient_id', request('recipient_id')) === (string) $recipient->id ? 'selected' : '' }}>{{ $recipient->name }} ({{ $recipient->relationship }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="mode === 'new'">
                        <label class="block font-medium text-sm text-stone-700 mb-1">New Recipient Name</label>
                        <input type="text" name="new_recipient_name" value="{{ old('new_recipient_name', request('new_recipient_name')) }}" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    </div>
                </div>

                <div class="mb-8">
                    <h4 class="text-stone-900 font-bold mb-4 border-b border-stone-100 pb-2">Pre-select a Gift (Optional)</h4>

                    <div class="mb-6 rounded-2xl border border-brand-100 bg-brand-50/50 p-5">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-stone-900 text-brand-500 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h5 class="font-bold text-stone-900">AI Suggestions</h5>
                                <p class="text-sm text-stone-500">Use the same demo recommendation logic to surface catalogue gifts for this event.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-stone-700 mb-1">Recipient type</label>
                                <select name="ai_recipient_type" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                    <option value="">Select</option>
                                    @foreach([
                                        'mother' => 'Mother',
                                        'father' => 'Father',
                                        'partner' => 'Partner',
                                        'friend' => 'Friend',
                                        'sibling' => 'Sibling',
                                        'colleague' => 'Colleague',
                                    ] as $value => $label)
                                        <option value="{{ $value }}" {{ old('ai_recipient_type', request('ai_recipient_type')) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-stone-700 mb-1">Budget</label>
                                <select name="ai_budget" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                    <option value="">Select</option>
                                    @foreach([
                                        'under_1000' => 'Under Rs. 1,000',
                                        '1000_3000' => 'Rs. 1,000 - 3,000',
                                        '3000_5000' => 'Rs. 3,000 - 5,000',
                                        '5000_10000' => 'Rs. 5,000 - 10,000',
                                        'above_10000' => 'Rs. 10,000+',
                                    ] as $value => $label)
                                        <option value="{{ $value }}" {{ old('ai_budget', request('ai_budget')) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-stone-700 mb-1">Interests</label>
                                <input type="text" name="ai_interests" value="{{ old('ai_interests', request('ai_interests')) }}" placeholder="tech, flowers, food" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" name="suggest_gifts" value="1" formmethod="GET" formaction="{{ route('events.create') }}" formnovalidate class="inline-flex items-center gap-2 bg-stone-900 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-stone-800 transition shadow-sm">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Suggest Gifts
                            </button>
                        </div>
                    </div>

                    @if(request()->boolean('suggest_gifts'))
                        @if($aiSuggestions->isNotEmpty())
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-3">
                                    <h5 class="font-bold text-stone-900">Recommended for this event</h5>
                                    <span class="text-xs text-stone-400">Top match is pre-selected</span>
                                </div>
                                <div class="space-y-3">
                                    @foreach($aiSuggestions as $suggestion)
                                        @php($gift = $suggestion['gift'])
                                        <div class="rounded-xl border bg-white p-4 shadow-sm transition hover:border-brand-500">
                                            <div class="flex gap-4">
                                                <div class="w-16 h-16 rounded-lg bg-stone-100 overflow-hidden shrink-0">
                                                    <img src="{{ $gift->image_path }}" alt="{{ $gift->name }}" class="w-full h-full object-cover">
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-start justify-between gap-4">
                                                        <div>
                                                            <h6 class="text-sm font-bold text-stone-900">{{ $gift->name }}</h6>
                                                            <p class="mt-1 text-xs text-stone-500">{{ $gift->category }} &middot; Rs. {{ number_format($gift->price) }}</p>
                                                        </div>
                                                        <input id="suggested-gift-{{ $gift->id }}" type="radio" name="gift_id" value="{{ $gift->id }}" class="mt-1 h-4 w-4 border-stone-300 text-brand-600 focus:ring-brand-500" {{ $selectedGiftId === (string) $gift->id ? 'checked' : '' }}>
                                                    </div>

                                                    @if($suggestion['matched_name'] !== $gift->name)
                                                        <p class="mt-2 text-xs font-medium text-brand-700">Inspired by: {{ $suggestion['matched_name'] }}</p>
                                                    @endif

                                                    <p class="mt-2 text-sm leading-relaxed text-stone-500">{{ $suggestion['reason'] }}</p>

                                                    <div class="mt-4 flex flex-wrap gap-2">
                                                        <a href="{{ route('gifts.show', $gift) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition">
                                                            View Details
                                                        </a>
                                                        <label for="suggested-gift-{{ $gift->id }}" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-brand-600 px-3 py-2 text-xs font-semibold text-white hover:bg-brand-700 transition">
                                                            Select Gift
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="mb-6 rounded-xl border border-stone-200 bg-stone-50 p-4 text-sm text-stone-600">
                                No active catalogue gifts matched those AI preferences yet. You can still choose any gift below.
                            </div>
                        @endif
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($gifts as $gift)
                            <div class="rounded-xl border bg-white p-4 shadow-sm transition hover:border-brand-500">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h5 class="text-sm font-medium text-stone-900">{{ $gift->name }}</h5>
                                        <p class="mt-1 text-xs text-stone-500">{{ $gift->category }}</p>
                                        <p class="mt-2 text-sm font-bold text-brand-600">Rs. {{ number_format($gift->price) }}</p>
                                    </div>
                                    <input id="catalogue-gift-{{ $gift->id }}" type="radio" name="gift_id" value="{{ $gift->id }}" class="mt-1 h-4 w-4 border-stone-300 text-brand-600 focus:ring-brand-500" {{ $selectedGiftId === (string) $gift->id && !in_array((string) $gift->id, $suggestedGiftIds, true) ? 'checked' : '' }}>
                                </div>

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ route('gifts.show', $gift) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center rounded-lg border border-stone-200 px-3 py-2 text-xs font-semibold text-stone-700 hover:bg-stone-50 transition">
                                        View Details
                                    </a>
                                    <label for="catalogue-gift-{{ $gift->id }}" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-brand-600 px-3 py-2 text-xs font-semibold text-white hover:bg-brand-700 transition">
                                        Select Gift
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block font-medium text-sm text-stone-700 mb-1">Remind me before (days)</label>
                    <input type="number" name="notification_days" value="{{ old('notification_days', request('notification_days', 7)) }}" min="7" max="30" class="w-24 rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    <p class="text-xs text-stone-400 mt-1">Reminders must be at least 7 days before the event and cannot exceed the days remaining.</p>
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
