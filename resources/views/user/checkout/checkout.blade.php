@extends('layouts.app')

@section('content')
    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center m-auto">
        <a href="index.html" class="text-indigo-900 text-base">
            <i class="fas fa-home"></i>
        </a>
        <span class="text-sm text-gray-400"><i
                class="fas fa-chevron-right"></i></span>
        <p class="text-gray-600 font-medium uppercase">
            {{ __('titles.checkout') }}
        </p>
    </div>
    <!-- breadcrum end -->
    <!-- checkout wrapper -->
    <div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4 m-auto">
        <!-- checkout form -->
        @php
            $total = 0;
            $mess = Session::get('mess');
        @endphp
        @if ($mess)
            <div
                class="lg:col-span-12 border border-gray-200 px-4 py-4 rounded text-red-600">
                {{ Session::get('mess') }}
            </div>

            @php
                Session::put('mess', null);
            @endphp
        @endif
        <div
            class="lg:col-span-5 border border-gray-200 px-6 py-8 rounded mt-6 lg:mt-0 shadow-2xl">
            <h4 class="text-gray-800 text-lg mb-6 font-medium uppercase">
                ORDER SUMMARY
            </h4>

            @foreach ($carts as $id => $cartItem)
                @php
                    $total += $cartItem['quantity'] * $cartItem['price'];
                @endphp
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between" v-for="n in 3" :key="n">
                        <div>
                            <h5 class="text-gray-700 font-medium">
                                {{ $cartItem['name'] }}</h5>
                        </div>
                        <p class="text-gray-600">
                            x{{ $cartItem['quantity'] }}
                        </p>
                        <p class="text-gray-700 font-medium">
                            {{ vndFormat($cartItem['price'] * $cartItem['quantity']) }}
                        </p>
                    </div>
                </div>
            @endforeach

            <div class="flex justify-between border-b border-gray-200 mt-1">
                <h4 class="text-gray-700 font-medium my-3 uppercase">
                    {{ __('titles.Subtotal') }}
                </h4>
                <h4 class="text-gray-700 font-medium my-3 uppercase">
                    {{ vndFormat($total) }}
                </h4>
            </div>

            <div class="flex justify-between border-b border-gray-200 mt-3">
                <h4 class="text-gray-800 font-medium my-3 uppercase">
                    {{ __('titles.Delivery') }}
                </h4>
                <h4 class="text-gray-800 font-medium my-3 uppercase">
                    {{ __('titles.Free') }}
                </h4>
            </div>

            @if ($percent != 0)
                <div class="flex justify-between border-b border-gray-200 mt-3">
                    <h4 class="text-gray-800 font-medium my-3 uppercase">
                        {{ __('titles.Voucher') . ' (' . $percent . config('voucher.discount') . ')' }}
                        <h4 class="text-gray-800 font-medium my-3 uppercase">
                            {{ vndFormat($discount) }}
                        </h4>
                </div>
            @endif

            <div class="flex justify-between mt-3">
                <h4 class="text-gray-800 font-semibold my-3 uppercase">
                    {{ __('titles.Total') }}
                </h4>
                <h4 class="text-gray-800 font-semibold my-3 uppercase">
                    @php
                        if ($discount) {
                            Session::put('subTotal', $total + $discount);
                        } else {
                            Session::put('subTotal', $total);
                        }
                    @endphp
                    {{ vndFormat($total + $discount) }}
                </h4>
            </div>

            <!-- checkout -->
            <a href="#" id="checkout"
                class="bg-indigo-900 mt-8 border border-indigo-900 text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
                hover:text-indigo-900 transition text-sm w-full block text-center">
                {{ __('titles.place-order') }}

            </a>
            <!-- checkout end -->
        </div>
        <div
            class="lg:col-span-6 border border-gray-200 px-6 py-8 rounded shadow-2xl">
            <form role="form" action="{{ route('orders.store') }}" method="post"
                id="form-checkout">
                @csrf
                <h3 class="text-lg font-medium capitalize mb-4">
                    {{ __('titles.checkout') }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('titles.name') }}
                        </label>
                        <input type="text"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('name') border-red-600 @enderror"
                            name="name">
                        @error('name')
                            <span class="text-red-600">
                                {{ __($message, ['name' => __('titles.name')]) }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('titles.address') }}
                        </label>
                        <input type="text"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('address') border-red-600 @enderror"
                            name="address">
                        @error('address')
                            <span class="text-red-600">
                                {{ __($message, ['name' => __('titles.address')]) }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('titles.phone') }}
                        </label>
                        <input type="number"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('phone') border-red-600 @enderror"
                            name="phone">
                        @error('phone')
                            <span class="text-red-600">
                                {{ __($message, ['name' => __('titles.phone')]) }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('titles.email') }}
                        </label>
                        <input type="text"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('email') border-red-600 @enderror"
                            name="email">
                        @error('email')
                            <span class="text-red-600">
                                {{ __($message, ['name' => __('titles.email')]) }}
                            </span>
                        @enderror
                    </div>
                    <div>
                        <label class="text-gray-600 mb-2 block">
                            {{ __('titles.note') }}
                        </label>
                        <textarea type="text" class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400"
                            name="note" rows="4" draggable="false">
                        </textarea>
                    </div>
                    <input type="hidden" name="user_id"
                        value="{{ Auth::user()->id }}">
                    <input type="hidden" name="sum_price"
                        value="{{ $total }}">
                </div>

            </form>
        </div>
        <!-- checkout form end -->
    </div>
    <!-- checkout wrapper end -->
@endsection
