<x-guest-layout>
    <div class="min-h-screen flex flex-col items-center justify-center pt-6 sm:pt-0 bg-stone-50">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-stone-100">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-stone-900">Create Account</h2>
                <p class="text-stone-500 text-sm mt-1">Join GiftSync today</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label class="block font-medium text-sm text-stone-700" for="name">Name</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="email">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="phone">Phone (Optional)</label>
                    <input id="phone" type="text" name="phone" placeholder="0300-1234567"
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="password">Password</label>
                    <input id="password" type="password" name="password" required
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-stone-700" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="mt-1 block w-full rounded-lg border-stone-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 bg-stone-50 p-2.5">
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-stone-600 hover:text-brand-600" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 transition ease-in-out duration-150">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
