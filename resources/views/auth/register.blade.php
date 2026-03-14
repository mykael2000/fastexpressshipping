<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-fes-navy">Create Your Account</h1>
            <p class="mt-2 text-sm text-gray-600">
                Join Fast Express Shipping and manage your shipments with ease.
            </p>
        </div>

        <!-- Card -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-lg sm:p-8">
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Full Name')" class="mb-2 text-sm font-semibold text-fes-navy" />
                    <x-text-input
                        id="name"
                        class="block w-full rounded-xl border-gray-300 focus:border-fes-orange focus:ring-fes-orange"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your full name"
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="mb-2 text-sm font-semibold text-fes-navy" />
                    <x-text-input
                        id="email"
                        class="block w-full rounded-xl border-gray-300 focus:border-fes-orange focus:ring-fes-orange"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autocomplete="username"
                        placeholder="Enter your email address"
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="mb-2 text-sm font-semibold text-fes-navy" />
                    <x-text-input
                        id="password"
                        class="block w-full rounded-xl border-gray-300 focus:border-fes-orange focus:ring-fes-orange"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="Create a password"
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />

                    <p class="mt-2 text-xs text-gray-500">
                        Use a strong password with a mix of letters, numbers, and symbols.
                    </p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mb-2 text-sm font-semibold text-fes-navy" />
                    <x-text-input
                        id="password_confirmation"
                        class="block w-full rounded-xl border-gray-300 focus:border-fes-orange focus:ring-fes-orange"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="Re-enter your password"
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Footer Actions -->
                <div class="pt-2">
                    <x-primary-button class="w-full justify-center rounded-xl bg-fes-orange px-4 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-orange-600 focus:bg-orange-600 active:bg-orange-700">
                        {{ __('Create Account') }}
                    </x-primary-button>

                    <p class="mt-4 text-center text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-semibold text-fes-orange hover:text-orange-600">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
