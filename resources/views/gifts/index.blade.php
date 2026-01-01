<x-app-layout>
    <x-slot name="header">
        Gift Catalogue
    </x-slot>

    <div class="mb-10 flex flex-col md:flex-row gap-6 items-end justify-between">
        <div class="max-w-xl">
            <h3 class="text-2xl font-bold text-stone-900">Find the Perfect Gift</h3>
            <p class="text-stone-500 mt-2">Browse our curated selection or use our AI tool to find something unique for your recipient.</p>
        </div>

        <button class="w-full md:w-auto flex items-center justify-center gap-2 bg-stone-900 text-white px-5 py-3 rounded-xl hover:bg-stone-800 transition shadow-lg shadow-stone-200">
            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            <span>Ask AI for Ideas</span>
        </button>
    </div>

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
                        <span class="text-brand-600 font-bold">Rs. {{ number_format($gift->price) }}</span>
                    </div>

                    <p class="text-stone-500 text-sm mb-6 line-clamp-2">
                        {{ $gift->description }}
                    </p>

                    <button class="w-full py-3 rounded-xl border-2 border-stone-100 text-stone-600 font-semibold hover:border-brand-600 hover:bg-brand-600 hover:text-white transition-colors duration-200 flex items-center justify-center gap-2">
                        <span>Select Gift</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $gifts->links() }}
    </div>
</x-app-layout>
