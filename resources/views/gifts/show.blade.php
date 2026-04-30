<x-app-layout>
    <x-slot name="header">
        Gift Details
    </x-slot>

    <div class="space-y-8">
        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('gifts.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-stone-500 hover:text-stone-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Catalogue
            </a>

            <a href="{{ route('events.create', ['gift_id' => $gift->id]) }}" class="inline-flex items-center gap-2 bg-brand-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-brand-700 transition shadow-sm">
                Select This Gift
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <section class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
            <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                <div class="bg-stone-100 min-h-[320px] lg:min-h-[520px]">
                    <img src="{{ $gift->image_path }}" alt="{{ $gift->name }}" class="w-full h-full object-cover">
                </div>

                <div class="p-6 md:p-8 flex flex-col">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wide text-brand-600">{{ $gift->category ?? 'Gift' }}</p>
                            <h2 class="text-3xl font-bold text-stone-900 mt-2">{{ $gift->name }}</h2>
                        </div>
                        <span class="shrink-0 rounded-xl bg-brand-50 px-4 py-2 text-lg font-bold text-brand-700">
                            Rs. {{ number_format($gift->price) }}
                        </span>
                    </div>

                    <div class="rounded-2xl border border-stone-100 bg-stone-50 p-5 mb-6">
                        <h3 class="text-sm font-bold text-stone-900 mb-2">About This Gift</h3>
                        <p class="text-sm leading-relaxed text-stone-600">
                            {{ $gift->description ?: 'A curated gift option from the GiftSync catalogue.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <div class="rounded-xl border border-stone-100 p-4">
                            <p class="text-xs uppercase font-bold tracking-wide text-stone-400 mb-1">Category</p>
                            <p class="font-semibold text-stone-900">{{ $gift->category ?? 'General' }}</p>
                        </div>
                        <div class="rounded-xl border border-stone-100 p-4">
                            <p class="text-xs uppercase font-bold tracking-wide text-stone-400 mb-1">Availability</p>
                            <p class="font-semibold text-green-700">Ready to schedule</p>
                        </div>
                    </div>

                    <div class="mt-auto flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('events.create', ['gift_id' => $gift->id]) }}" class="inline-flex items-center justify-center gap-2 bg-brand-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-brand-700 transition shadow-sm">
                            Use This Gift
                        </a>
                        <a href="{{ route('ai.suggestions') }}" class="inline-flex items-center justify-center gap-2 bg-stone-100 text-stone-700 px-5 py-3 rounded-xl font-semibold hover:bg-stone-200 transition">
                            Ask AI For Alternatives
                        </a>
                    </div>
                </div>
            </div>
        </section>

        @if($relatedGifts->count() > 0)
            <section>
                <div class="flex items-center justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-xl font-bold text-stone-900">More Gift Ideas</h3>
                        <p class="text-sm text-stone-500 mt-1">A few other catalogue options you might want to compare.</p>
                    </div>
                    <a href="{{ route('gifts.index') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700 transition">Browse all</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedGifts as $relatedGift)
                        <article class="bg-white rounded-2xl border border-stone-200 shadow-sm overflow-hidden">
                            <div class="h-44 bg-stone-100">
                                <img src="{{ $relatedGift->image_path }}" alt="{{ $relatedGift->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h4 class="font-bold text-stone-900 leading-tight">{{ $relatedGift->name }}</h4>
                                    <span class="text-sm font-bold text-brand-600 shrink-0">Rs. {{ number_format($relatedGift->price) }}</span>
                                </div>
                                <p class="text-sm text-stone-500 line-clamp-2 mb-4">{{ $relatedGift->description }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('gifts.show', $relatedGift) }}" class="flex-1 inline-flex items-center justify-center rounded-xl border border-stone-200 px-4 py-2.5 text-sm font-semibold text-stone-700 hover:bg-stone-50 transition">
                                        View Details
                                    </a>
                                    <a href="{{ route('events.create', ['gift_id' => $relatedGift->id]) }}" class="flex-1 inline-flex items-center justify-center rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition">
                                        Select
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
