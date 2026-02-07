<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0 bg-stone-50">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-stone-100">

            {{-- Progress indicator --}}
            <div class="flex items-center justify-center gap-3 mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-green-600">Email</span>
                </div>
                <div class="w-8 h-px bg-brand-400"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                    <span class="text-sm font-medium text-brand-700">Phone</span>
                </div>
            </div>

            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-stone-900">Verify Your Phone</h2>
                <p class="text-stone-500 text-sm mt-2">
                    We've sent a 6-digit code to
                    <strong class="text-stone-700">{{ Auth::user()->phone ?? '03XX-XXXXXXX' }}</strong>
                </p>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verify.phone.submit') }}" x-data="{ code: '' }">
                @csrf

                <div class="mb-6">
                    <label class="block font-medium text-sm text-stone-700 mb-2" for="code">Verification Code</label>
                    <input id="code" type="text" name="code" x-model="code"
                           maxlength="6" inputmode="numeric" pattern="[0-9]*" autofocus
                           placeholder="000000"
                           class="block w-full text-center text-2xl tracking-[0.5em] rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-3 font-mono">
                    @error('code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                        :disabled="code.length !== 6"
                        :class="code.length === 6 ? 'bg-brand-600 hover:bg-brand-700 shadow-md' : 'bg-stone-300 cursor-not-allowed'"
                        class="w-full text-white py-3 rounded-xl font-bold transition">
                    Verify Phone
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-stone-500">Didn't receive the code?</p>
                <form method="POST" action="{{ route('verify.resend') }}" class="inline">
                    @csrf
                    <input type="hidden" name="type" value="phone">
                    {{-- Demo: resend button doesn't actually send anything --}}
                    <button type="submit" class="text-brand-600 hover:text-brand-700 text-sm font-medium mt-1">
                        Resend Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
