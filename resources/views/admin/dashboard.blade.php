<x-app-layout>
    <x-slot name="header">
        Admin Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-stone-900 text-white p-6 rounded-2xl shadow-lg">
            <p class="text-stone-400 text-sm font-medium">Pending Approvals</p>
            <p class="text-4xl font-bold mt-2">{{ $stats['pending_payments'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
            <p class="text-stone-500 text-sm font-medium">Total Revenue</p>
            <p class="text-3xl font-bold text-brand-600 mt-2">Rs. {{ number_format($stats['total_revenue']) }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
            <p class="text-stone-500 text-sm font-medium">Active Events</p>
            <p class="text-3xl font-bold text-stone-800 mt-2">{{ $stats['active_events'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-stone-200">
            <p class="text-stone-500 text-sm font-medium">Total Users</p>
            <p class="text-3xl font-bold text-stone-800 mt-2">{{ $stats['total_users'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-stone-200 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-stone-900 text-lg">Recent Payment Requests</h3>
            <a href="{{ route('admin.payments') }}" class="text-brand-600 hover:underline text-sm font-medium">View All</a>
        </div>

        @if($recentPayments->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="text-xs text-stone-400 uppercase font-semibold border-b border-stone-100">
                    <tr>
                        <th class="pb-3">User</th>
                        <th class="pb-3">Amount</th>
                        <th class="pb-3">Method</th>
                        <th class="pb-3 text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-50">
                    @foreach($recentPayments as $payment)
                        <tr>
                            <td class="py-3">
                                <span class="block text-stone-800 font-medium">{{ $payment->user->name }}</span>
                                <span class="text-xs text-stone-500">{{ $payment->created_at->diffForHumans() }}</span>
                            </td>
                            <td class="py-3 font-bold text-stone-700">Rs. {{ number_format($payment->amount) }}</td>
                            <td class="py-3 text-sm text-stone-600">{{ $payment->method }}</td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.payments') }}" class="text-brand-600 hover:text-brand-700 font-medium text-sm">Review</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-stone-500 text-center py-4">No pending payments.</p>
        @endif
    </div>
</x-app-layout>
