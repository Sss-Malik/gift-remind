<x-app-layout>
    <x-slot name="header">
        AI Gift Suggestions
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-stone-900">Find the Perfect Gift</h3>
            <p class="text-stone-500 mt-2">Tell us about the person and occasion, and our AI will suggest thoughtful, personalized gift ideas.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-8">
            <form method="POST" action="{{ route('ai.suggestions.submit') }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div class="space-y-6">
                    {{-- Recipient Type --}}
                    <div>
                        <label class="block font-medium text-sm text-stone-700 mb-2">Who is this gift for?</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach([
                                'mother' => 'Mother',
                                'father' => 'Father',
                                'partner' => 'Partner',
                                'friend' => 'Friend',
                                'sibling' => 'Sibling',
                                'colleague' => 'Colleague',
                            ] as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="recipient_type" value="{{ $value }}" class="peer sr-only" {{ old('recipient_type') === $value ? 'checked' : '' }} required>
                                    <div class="p-3 rounded-xl border-2 border-stone-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-stone-50 transition text-center">
                                        <span class="block font-medium text-stone-800 text-sm">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('recipient_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Occasion --}}
                    <div>
                        <label class="block font-medium text-sm text-stone-700 mb-2">What's the occasion?</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach([
                                'birthday' => 'Birthday',
                                'anniversary' => 'Anniversary',
                                'wedding' => 'Wedding',
                                'graduation' => 'Graduation',
                                'holiday' => 'Holiday',
                                'thank_you' => 'Thank You',
                                'just_because' => 'Just Because',
                            ] as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="occasion" value="{{ $value }}" class="peer sr-only" {{ old('occasion') === $value ? 'checked' : '' }} required>
                                    <div class="p-3 rounded-xl border-2 border-stone-200 peer-checked:border-brand-500 peer-checked:bg-brand-50 hover:bg-stone-50 transition text-center">
                                        <span class="block font-medium text-stone-800 text-sm">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('occasion') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Budget --}}
                    <div>
                        <label class="block font-medium text-sm text-stone-700 mb-2">Budget range</label>
                        <select name="budget" class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                            <option value="">Select a budget</option>
                            <option value="under_1000" {{ old('budget') === 'under_1000' ? 'selected' : '' }}>Under Rs. 1,000</option>
                            <option value="1000_3000" {{ old('budget') === '1000_3000' ? 'selected' : '' }}>Rs. 1,000 - 3,000</option>
                            <option value="3000_5000" {{ old('budget') === '3000_5000' ? 'selected' : '' }}>Rs. 3,000 - 5,000</option>
                            <option value="5000_10000" {{ old('budget') === '5000_10000' ? 'selected' : '' }}>Rs. 5,000 - 10,000</option>
                            <option value="above_10000" {{ old('budget') === 'above_10000' ? 'selected' : '' }}>Rs. 10,000+</option>
                        </select>
                        @error('budget') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Interests --}}
                    <div>
                        <label class="block font-medium text-sm text-stone-700 mb-1">Their interests (optional)</label>
                        <p class="text-xs text-stone-400 mb-2">Comma-separated, e.g. "cooking, music, travel, tech"</p>
                        <input type="text" name="interests" value="{{ old('interests') }}"
                               placeholder="e.g. cooking, gardening, reading, fitness"
                               class="w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                        @error('interests') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit"
                            :disabled="loading"
                            class="w-full bg-stone-900 text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-stone-800 transition flex items-center justify-center gap-2">
                        <template x-if="!loading">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Get AI Suggestions
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                AI is thinking...
                            </span>
                        </template>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
