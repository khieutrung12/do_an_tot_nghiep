@extends('layouts.app')

@section('content')
    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center m-auto">
        <a href="{{ route('home') }}" class="text-indigo-900 text-base">
            <i class="fas fa-home"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fas fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium uppercase">
            {{ __('titles.Shopping Cart') }}
        </p>
    </div>
    <!-- breadcrum end -->
    <!-- cart wrapper -->
    <div id="cart_wrapper">
        @include('user.cart.cart_components.cart_components')
    </div>
    <!-- end cart wrapper -->
@endsection
