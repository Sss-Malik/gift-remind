<x-app-layout>
    <x-slot name="header">
        Overview
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Upcoming Events</p>
                <p class="text-3xl font-bold text-stone-900 mt-1">3</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Pending Payments</p>
                <p class="text-3xl font-bold text-brand-600 mt-1">1</p>
            </div>
            <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-stone-500">Gifts Sent</p>
                <p class="text-3xl font-bold text-stone-900 mt-1">12</p>
            </div>
            <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-100 p-8 text-center">
        <div class="w-20 h-20 bg-stone-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        </div>
        <h3 class="text-lg font-bold text-stone-900 mb-2">No upcoming events?</h3>
        <p class="text-stone-500 max-w-sm mx-auto mb-6">Start by adding your first recipient and event. We will remind you when it's time to gift.</p>
        <button class="bg-brand-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-brand-700 transition">
            Create First Event
        </button>
    </div>

</x-app-layout>
