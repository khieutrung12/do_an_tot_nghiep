@extends('layouts.app')

@section('content')
<main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-5">
    <div class="flex">
        <div class="w-full">
            <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-lg">

                <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                    {{ __('titles.register') }}
                </header>

                @if ($message = Session::get('message'))
                <div 
                    class="text-indigo-900 text-base mx-auto mt-10">
                    {{ $message }}
                </div>
                @endif

                <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" method="POST"
                    action="{{ route('register') }}">
                    @csrf

                    <div class="flex flex-wrap">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.name') }}:
                        </label>

                        <input id="name" type="text" class="form-input w-full @error('name')  border-indigo-900 @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ __($message, ['name' => __('titles.name')] )}}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.email') }}:
                        </label>

                        <input id="email" type="email"
                            class="form-input w-full @error('email') border-indigo-900 @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ __($message, ['name' => __('titles.email')] )}}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="phone" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.phone') }}:
                        </label>

                        <input id="phone" type="text" class="form-input w-full @error('phone')  border-indigo-900 @enderror"
                            name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                        @error('phone')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ __($message, ['name' => __('titles.phone')] )}}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="address" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.address') }}:
                        </label>

                        <input id="address" type="text" class="form-input w-full @error('address')  border-indigo-900 @enderror"
                            name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                        @error('address')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ __($message, ['name' => __('titles.address')] )}}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.password') }}:
                        </label>

                        <input id="password" type="password"
                            class="form-input w-full @error('password') border-indigo-900 @enderror" name="password"
                            required autocomplete="new-password">

                        @error('password')
                        <p class="text-indigo-900 text-xs italic mt-4">
                            {{ __($message, ['name' => __('titles.password')] )}}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-wrap">
                        <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                            {{ __('titles.confirmpassword') }}:
                        </label>

                        <input id="password-confirm" type="password" class="form-input w-full"
                            name="password_confirmation" required autocomplete="new-password">
                    </div>

                    <div class="flex flex-wrap">
                        <button type="submit"
                            class="w-full select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-indigo-900  hover:bg-indigo-800 sm:py-4">
                            {{ __('titles.register') }}
                        </button>

                        <p class="w-full text-xs text-center text-gray-700 my-6 sm:text-sm sm:my-8">
                            {{ __('messages.account?') }}
                            <a class="text-indigo-900 hover:text-blue-700 no-underline hover:underline" href="{{ route('login') }}">
                                {{ __('titles.login') }}
                            </a>
                        </p>
                    </div>
                </form>

            </section>
        </div>
    </div>
</main>
@endsection
