<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image: url('/login.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>

        <div class="bg-white bg-opacity-85 shadow-lg rounded-lg w-full max-w-lg p-8 relative z-10 mx-4">
            <div class="text-center mt-4 mb-6">
                <img src="/telkom.png" alt="Pelindo" class="h-46 w-44 mx-auto">
                <h1 class="text-xl font-semibold text-gray-800 mt-2">Welcome to <span
                        class="text-gray-900 font-extrabold text-3xl">NJ <span
                            class="text-red-600 text-3xl font-extrabold">KI</span>
                    </span>
                </h1>
            </div>
            <x-slot name="logo">
                <x-authentication-card-logo />
            </x-slot>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ $value }}
                </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    {{-- @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif --}}

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
            <div class="mt-8 text-center text-xs text-gray-500">
                &copy; 2025 NJKI TELKOM by Lubabul Ilmi
            </div>
        </div>
    </div>
</x-guest-layout>
