@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-5 shadow-2xl rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
        <form action="{{ route('password.change', Auth::user()->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="text-lg font-medium capitalize mb-12 mx-6 pt-3.5 pb-8 border border-l-0 border-t-0 border-r-0">
                {{ __('titles.Change password') }}
            </h3>

            <div class="space-y-12 w-full px-6">
                <div>
                    <label for="current_password" class="text-gray-600 mb-2 block">
                        {{ __('titles.Current Password') }}
                    </label>
                    <input
                        type="password"
                        class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('current_password') border-red-600 @enderror"
                        name="current_password" required>
                    @error('current_password')
                    <p class="text-indigo-900 text-xs italic">
                        {{ __($message, ['current_password' => __('titles.current_password')] )}}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-600 mb-2 block">
                        {{ __('titles.New Password') }}
                    </label>
                    <input
                        type="password"
                        class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('new_password') border-red-600 @enderror"
                        name="new_password"
                        value="{{ old('new_password') }}"required>
                    @error('new_password')
                    <p class="text-indigo-900 text-xs italic">
                        {{ __($message, ['new_password' => __('titles.new_password')] )}}
                    </p>
                    @enderror
                </div>

                <div>
                    <label class="text-gray-600 mb-2 block">
                        {{ __('titles.Confirm Password') }}
                    </label>
                    <input
                        type="password"
                        class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('confirm_password') border-red-600 @enderror"
                        name="confirm_password" required>
                    @error('confirm_password')
                    <p class="text-indigo-900 text-xs italic">
                        {{ __($message, ['confirm_password' => __('titles.confirm_password')] )}}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="mt-12 ml-6">
                <button
                    type="submit"
                    class="px-6 py-2 text-center text-white bg-indigo-900 border border-indigo-900 rounded hover:bg-transparent hover:text-indigo-900 transition uppercase font-roboto font-medium">
                    {{ __('titles.Save change') }}
                </button>

                @if ($message = Session::get('message'))
                <span
                    class="text-gray-600 italic ml-4">
                    {{ $message }}
                </span>
                @endif
            </div>

        </form>
    </div>
    <!-- account content end -->
@endsection
