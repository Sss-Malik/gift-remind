<x-app-layout>
    <x-slot name="header">
        Gift Catalogue
    </x-slot>

    <div class="mb-10 flex flex-col md:flex-row gap-6 items-end justify-between">
        <div class="max-w-xl">
            <h3 class="text-2xl font-bold text-stone-900">Find the Perfect Gift</h3>
            <p class="text-stone-500 mt-2">Browse our curated selection of gifts, or let AI recommend something tailored to your recipient.</p>
        </div>

        <a href="{{ route('ai.suggestions') }}" class="w-full md:w-auto flex items-center justify-center gap-2 bg-stone-900 text-white px-5 py-3 rounded-xl hover:bg-stone-800 transition shadow-lg shadow-stone-200">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span>Ask AI for Ideas</span>
        </a>
    </div>

    @if($gifts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($gifts as $gift)
                <div class="group bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="relative h-56 overflow-hidden bg-stone-100">
                        <img src="{{ $gift->image_path }}" alt="{{ $gift->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-xs font-bold text-stone-900 shadow-sm">
                            {{ $gift->category }}
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="text-lg font-bold text-stone-900 leading-tight">{{ $gift->name }}</h4>
                            <span class="text-brand-600 font-bold shrink-0 ml-2">Rs. {{ number_format($gift->price) }}</span>
                        </div>

                        <p class="text-stone-500 text-sm mb-6 line-clamp-2">
                            {{ $gift->description }}
                        </p>

                        <div class="flex gap-3">
                            <a href="{{ route('gifts.show', $gift) }}" class="flex-1 py-3 rounded-xl border border-stone-200 text-stone-700 font-semibold hover:bg-stone-50 transition flex items-center justify-center gap-2">
                                <span>View Details</span>
                            </a>
                            <a href="{{ route('events.create', ['gift_id' => $gift->id]) }}" class="flex-1 py-3 rounded-xl border-2 border-stone-100 text-stone-600 font-semibold hover:border-brand-600 hover:bg-brand-600 hover:text-white transition-colors duration-200 flex items-center justify-center gap-2">
                                <span>Select Gift</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $gifts->links() }}
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-12 text-center">
            <div class="w-16 h-16 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900 mb-2">No gifts available yet</h3>
            <p class="text-stone-500 mb-6">Our gift catalogue is being updated. Try AI suggestions in the meantime!</p>
            <a href="{{ route('ai.suggestions') }}" class="inline-flex items-center gap-2 bg-stone-900 text-white px-6 py-3 rounded-xl font-medium hover:bg-stone-800 transition">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Get AI Suggestions
            </a>
        </div>
    @endif
</x-app-layout>
