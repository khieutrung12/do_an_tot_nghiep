@extends('layouts.app')

@section('content')
    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center m-auto">
        <a href="{{ route('home') }}" class="text-indigo-900 text-base">
            <i class="fas fa-home"></i>
        </a>
        <span class="text-sm text-gray-400"><i
                class="fas fa-chevron-right"></i></span>
        <p class="text-gray-600 font-medium uppercase">
            {{ __('titles.My Account') }}</p>
    </div>
    <!-- breadcrum end -->

    <!-- account wrapper -->
    <div class="container lg:grid grid-cols-12 items-start gap-6 pt-4 pb-16 m-auto">
        <!-- sidebar -->
        <div class="col-span-3">
            <!-- account profile -->
            <div class="px-4 py-5 shadow-2xl flex items-center gap-4 bg-white">
                <div class="flex-shrink-0">
                    @if (Auth::user()->avatar != null)
                        <img src="{{ asset('avatars/' . Auth::user()->avatar) }}"
                            class="rounded-full w-14 h-14 p-1 border border-gray-200 object-cover">
                    @else
                        <img src="{{ asset('images/user.png') }}"
                            class="rounded-full w-14 h-14 p-1 border border-gray-200 object-cover">
                    @endif

                </div>
                <div>
                    <p class="text-gray-600">{{ __('titles.Hello') }},</p>
                    <h4 class="text-gray-800 capitalize font-medium mt-3 ml-6">
                        {{ Auth::user()->name }}
                    </h4>
                </div>
            </div>
            <!-- account profile end -->

            <!-- profile links -->
            <div
                class="mt-6 bg-white shadow-2xl rounded p-4 divide-y divide-gray-200 space-y-4 text-gray-600">
                <!-- single link -->
                <div class="space-y-3 pl-8 py-2">

                    <a href="{{ route('profile.edit', Auth::user()->id) }}"
                        class="relative text-base font-medium capitalize hover:text-indigo-900 transition block
                            @if (Route::currentRouteName() == 'profile.edit') text-indigo-900 @endif">
                        <span class="absolute left-0 top-0 text-base">
                            <i class="far fa-address-card"></i>
                        </span>
                        <span class="ml-8">
                            {{ __('titles.Manage account') }}
                        </span>
                    </a>

                    <a href="{{ route('password.edit', Auth::user()->id) }}"
                        class="hover:text-indigo-900 transition capitalize block ml-8
                            @if (Route::currentRouteName() == 'password.edit') text-indigo-900 @endif">
                        {{ __('titles.Change password') }}
                    </a>

                </div>
                <!-- single link end -->
                <!-- single link -->
                <div class="space-y-3 pl-8 pb-2 pt-5">
                    <a href="{{ route('viewOrders', ['id' => Auth::user()->id]) }}"
                        class="relative medium capitalize text-gray-800 font-medium hover:text-indigo-900 transition block">
                        <span class="absolute left-0 top-0 text-base">
                            <i class="fas fa-gift"></i>
                        </span>
                        <span class="ml-8">
                            {{ __('titles.My order history') }}
                        </span>
                    </a>
                    <a href="{{ route('viewStatusOrder', ['idUser' => Auth::user()->id, 'idStatus' => config('app.confirmed')]) }}"
                        class="hover:text-indigo-900 transition block capitalize ml-8">
                        {{ __('titles.Completed') }}
                    </a>
                    <a href="{{ route('viewStatusOrder', ['idUser' => Auth::user()->id, 'idStatus' => config('app.canceled')]) }}"
                        class="hover:text-indigo-900 transition block capitalize ml-8">
                        {{ __('titles.Cancelled') }}
                    </a>
                    <a href="{{ route('viewStatusOrder', ['idUser' => Auth::user()->id, 'idStatus' => config('app.unconfirmed')]) }}"
                        class="hover:text-indigo-900 transition block capitalize ml-8">
                        {{ __('titles.Unconfirmed') }}
                    </a>
                </div>
                <!-- single link end -->
                <!-- vouchers link -->
                <div class="space-y-3 pl-8 pb-2 pt-5">
                    <a href="{{ route('user.voucher.wallet') }}"
                        class="relative medium capitalize text-gray-800 font-medium hover:text-indigo-900 transition block">
                        <span class="absolute left-0 top-0 text-base">
                            <i class="far fa-credit-card"></i>
                        </span>
                        <span class="ml-8">
                            {{ __('titles.Voucher') }}
                        </span>
                    </a>
                </div>
                <!-- vouchers link end -->
                <!-- single link -->
                <div class="pl-8 pb-2 pt-5 hidden">
                    <a href="#"
                        class="relative medium capitalize text-gray-800 font-medium hover:text-indigo-900 transition block">
                        <span class="absolute left-0 top-0 text-base">
                            <i class="far fa-heart"></i>
                        </span>
                        <span class="ml-8">
                            {{ __('titles.My wishlist') }}
                        </span>
                    </a>
                </div>
                <!-- single link end -->
                <!-- single link -->
                <div class="pl-8 pb-2 pt-5">
                    <a href="{{ route('logout') }}"
                        class="relative medium capitalize text-gray-800 font-medium hover:text-indigo-900 transition block"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="absolute left-0 top-0 text-base">
                            <i class="fas fa-sign-out-alt"></i>
                        </span>
                        <span class="ml-8">
                            {{ __('titles.logout') }}
                        </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}"
                        method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
                <!-- single link end -->
            </div>
            <!-- profile links end -->
        </div>
        <!-- sidebar end -->
        @yield('content-profile')
    </div>
    <!-- account wrapper end -->
@endsection
