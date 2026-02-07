<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0 bg-stone-50">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-stone-100">
            <div class="mb-6 text-center">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-brand-600 rounded-lg shadow-sm rotate-3"></div>
                    <span class="text-xl font-bold text-stone-900">Gift<span class="text-brand-600">Sync</span></span>
                </div>
                <h2 class="text-2xl font-bold text-stone-900">Welcome back</h2>
                <p class="text-stone-500 text-sm mt-1">Sign in to manage your gifts and events</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="password">Password</label>
                    <input id="password" type="password" name="password" required
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-brand-600 text-white py-3 rounded-xl font-bold shadow-md hover:bg-brand-700 transition">
                        Sign In
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <span class="text-sm text-stone-500">Don't have an account?</span>
                    <a class="text-sm text-brand-600 hover:text-brand-700 font-medium ml-1" href="{{ route('register') }}">
                        Create one
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
