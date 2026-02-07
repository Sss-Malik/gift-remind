<x-app-layout>
    <x-slot name="header">
        AI Gift Suggestions
    </x-slot>

    <div class="max-w-4xl mx-auto">
        {{-- Context summary --}}
        <div class="mb-8">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-10 h-10 bg-stone-900 text-brand-500 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-stone-900">Here's what I found for you</h3>
                    <p class="text-stone-500 mt-1">
                        Based on your request for a
                        <strong class="text-stone-700">{{ str_replace('_', ' ', $occasion) }}</strong> gift for your
                        <strong class="text-stone-700">{{ str_replace('_', ' ', $recipientType) }}</strong>
                        @if($interests)
                            who enjoys <strong class="text-stone-700">{{ $interests }}</strong>
                        @endif
                        — I picked these {{ count($suggestions) }} options that I think they'll love.
                    </p>
                </div>
            </div>
        </div>

        {{-- Suggestion Cards --}}
        <div class="space-y-6 mb-8">
            @foreach($suggestions as $index => $suggestion)
                <div class="bg-white rounded-2xl shadow-sm border border-stone-200 overflow-hidden hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 h-48 md:h-auto bg-stone-100 overflow-hidden">
                            <img src="{{ $suggestion['image'] }}" alt="{{ $suggestion['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-brand-600 uppercase tracking-wide">{{ $suggestion['category'] }}</span>
                                        <h4 class="text-lg font-bold text-stone-900 mt-1">{{ $suggestion['name'] }}</h4>
                                    </div>
                                    <span class="text-lg font-bold text-brand-600 shrink-0">Rs. {{ number_format($suggestion['price']) }}</span>
                                </div>

                                <div class="mt-3 bg-stone-50 rounded-xl p-4 border border-stone-100">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-brand-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        <p class="text-sm text-stone-600 leading-relaxed">{{ $suggestion['reason'] }}</p>
                                    </div>
                                </div>

                                @if(isset($suggestion['occasion_note']))
                                    <p class="text-xs text-stone-400 mt-2 italic">{{ $suggestion['occasion_note'] }}</p>
                                @endif
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('gifts.index') }}"
                                   class="inline-flex items-center gap-2 bg-brand-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-brand-700 transition shadow-sm">
                                    View in Catalogue
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
            <p class="text-stone-500 text-sm">Not quite right? Try adjusting your preferences for different results.</p>
            <a href="{{ route('ai.suggestions') }}" class="bg-stone-900 text-white px-6 py-3 rounded-xl font-bold hover:bg-stone-800 transition flex items-center gap-2 shrink-0">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Try Again
            </a>
        </div>
    </div>
</x-app-layout>
