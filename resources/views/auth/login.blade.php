@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-lg">

                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{ __('titles.login') }}
                </header>

                @if ($message = Session::get('message'))
                <div 
                    class="text-indigo-900 text-base mx-auto mt-10">
                    {{ $message }}
                </div>
                @endif

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="flex flex-wrap">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.email') }}:
                        </label>

                        <input id="email" type="email"
                            class="form-input w-full @error('email') border-indigo-900 @enderror" name="email"
                            value="{{ old('email') }}" autocomplete="email" autofocus>

                        @error('email')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.password') }}:
                        </label>

                        <input id="password" type="password"
                            class="form-input w-full @error('password') border-indigo-900 @enderror" name="password">

                        @error('password')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <label class="inline-flex items-center text-sm text-gray-700" for="remember">
                            <input type="checkbox" name="remember" id="remember" class="form-checkbox"
                                {{ old('remember') ? 'checked' : '' }}>
                            <span class="ml-2">{{ __('titles.remember-me') }}</span>
                        </label>

                    </div>

                    <div class="flex flex-wrap">
                        <button type="submit" id="btnLogin"
                        class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-indigo-900  hover:bg-indigo-800 sm:py-4">
                            {{ __('titles.login') }}
                        </button>

                        @if (Route::has('register'))
                        <p class="w-full text-xs text-center text-gray-700 my-6 sm:text-sm sm:my-8">
                            {{ __("messages.none-account?") }}
                            <a id="register" class="text-indigo-900 hover:text-white no-underline hover:underline" href="{{ route('register') }}">
                                {{ __('titles.register') }}
                            </a>
                        </p>
                        @endif
                    </div>
                </form>

            </section>
        </div>
    </div>
</main>
@endsection
