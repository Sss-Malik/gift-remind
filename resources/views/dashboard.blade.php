<x-app-layout>
    <x-slot name="header">
        Welcome back, {{ Auth::user()->name }}!
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Upcoming Events</p>
                <p class="text-3xl font-bold text-stone-900 mt-1">{{ $upcomingEvents }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Pending Payments</p>
                <p class="text-3xl font-bold text-brand-600 mt-1">{{ $pendingPayments }}</p>
            </div>
            <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Gifts Sent</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $giftsSent }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>

    @if($recentEvents->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden mb-8">
            <div class="p-6 border-b border-stone-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-stone-900">Upcoming Events</h3>
                <a href="{{ route('events.index') }}" class="text-brand-600 hover:text-brand-700 text-sm font-medium">View All</a>
            </div>
            <div class="divide-y divide-stone-50">
                @foreach($recentEvents as $event)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-stone-50/50 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg
                                {{ $event->type === 'birthday' ? 'bg-pink-50 text-pink-600' : ($event->type === 'anniversary' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600') }}">
                                {{ $event->type === 'birthday' ? '🎂' : ($event->type === 'anniversary' ? '💍' : '🎉') }}
                            </div>
                            <div>
                                <p class="font-semibold text-stone-900">{{ $event->title }}</p>
                                <p class="text-xs text-stone-500">{{ $event->recipient->name }} &middot; {{ $event->event_date->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div>
                            @if($event->event_date->isToday())
                                <span class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-bold">Today!</span>
                            @elseif($event->event_date->diffInDays(now()) <= 7)
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-bold">{{ $event->event_date->diffInDays(now()) }} days</span>
                            @else
                                <span class="bg-stone-100 text-stone-600 text-xs px-2.5 py-1 rounded-full font-medium">{{ $event->event_date->format('M d') }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($upcomingEvents === 0 && $giftsSent === 0)
        <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-8 text-center">
            <div class="w-20 h-20 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-stone-900 mb-2">Let's get started!</h3>
            <p class="text-stone-500 max-w-sm mx-auto mb-6">Create your first event and we'll remind you when it's time to send the perfect gift.</p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('events.create') }}" class="bg-brand-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-brand-700 transition">
                    Create Your First Event
                </a>
                <a href="{{ route('ai.suggestions') }}" class="bg-stone-100 text-stone-700 px-6 py-3 rounded-xl font-medium hover:bg-stone-200 transition">
                    Try AI Suggestions
                </a>
            </div>
        </div>
    @endif

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('gifts.index') }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 hover:border-brand-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center group-hover:bg-brand-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-stone-900">Browse Gift Catalogue</h4>
                    <p class="text-sm text-stone-500">Explore our curated selection of gifts</p>
                </div>
            </div>
        </a>

        <a href="{{ route('ai.suggestions') }}" class="bg-white rounded-2xl shadow-sm border border-stone-100 p-6 hover:border-brand-200 hover:shadow-md transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h4 class="font-semibold text-stone-900">Get AI Gift Ideas</h4>
                    <p class="text-sm text-stone-500">Let AI find the perfect gift for anyone</p>
                </div>
            </div>
        </a>
    </div>

</x-app-layout>
