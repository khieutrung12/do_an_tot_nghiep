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
        <a href="{{ route('shop') }}"
            class="text-indigo-900 text-base font-medium uppercase">
            {{ __('titles.Shop') }}
        </a>
        <span class="text-sm text-gray-400">
            <i class="fas fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium uppercase">
            {{ $product->name }}
        </p>
    </div>
    <!-- breadcrum end -->

    <!-- product view -->
    <div class="container pt-4 pb-6 grid lg:grid-cols-2 gap-6 m-auto">
        <!-- product image -->
        <div>
            <div>
                <img id="main-img"
                    src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                    class="w-full">
            </div>
            <div class="grid grid-cols-5 gap-4 mt-4">
                @foreach ($product->images as $image)
                    <div>
                        <img src="{{ asset('images/uploads/products/' . $image->image) }}"
                            class="single-img w-28 h-28 cursor-pointer border border-indigo-900">
                    </div>
                @endforeach
            </div>
        </div>
        <!-- product image end -->
        <!-- product content -->
        <div class="ml-6">
            <h2 class="md:text-3xl text-2xl font-medium uppercase mb-4">
                {{ $product->name }}
            </h2>
            <div class="flex items-center mb-6">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                    <span><i class="fas fa-star"></i></span>
                </div>
                <div class="text-xs text-gray-500 ml-3">
                    (150 {{ __('titles.Reviews') }})
                </div>
            </div>
            <div class="space-y-4">
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">
                        {{ __('titles.Brand') }}:
                    </span>
                    <span class="text-gray-600">
                        {{ $product->brand->name }}
                    </span>
                </p>
            </div>
            <div class="mt-20 flex items-baseline gap-5 bg-gray-50 py-8 pl-5">
                <span class="text-indigo-900 font-semibold text-3xl">
                    {{ vndFormat($product->price) }}
                    <input type="hidden" name="_token"
                        value="{{ csrf_token() }}">
                </span>
            </div>
            <!-- quantity -->
            <div class="mt-10">
                <h3 class="text-base text-gray-800 mb-1">
                    {{ __('titles.Quantity') }}
                </h3>
                <div
                    class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max-content absolute">
                    <button id="decrement_{{ $product->id }}"
                        onclick="stepper('decrement_{{ $product->id }}')"
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">-</button>
                    <input id="input-number_{{ $product->id }}" type="number"
                        min="1" max="{{ $product->quantity }}" readonly value="1"
                        class="appearance-none h-8 w-15 flex items-center justify-center cursor-not-allowed text-center">
                    <button id="increment_{{ $product->id }}"
                        onclick="stepper('increment_{{ $product->id }}')"
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">+</button>
                </div>
                <div class="text-gray-400 ml-32 pt-2">
                    {{ $product->quantity . __('titles.piece available') }}
                </div>
            </div>
            <!-- {{ __('titles.Add to Cart') }} button -->
            <div class="flex gap-3 border-b border-gray-200 pb-5 mt-10">
                <a href="{{ route('carts.index') }}"
                    data-id="{{ $product->id }}"
                    data-url="{{ route('addMoreProduct', ['id' => $product->id]) }}"
                    class="bg-indigo-900 border border-indigo-900 text-white px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm flex items-center add_quantity">
                    <span class="mr-2"><i
                            class="fas fa-shopping-bag"></i></span>
                    {{ __('titles.Buy now') }}
                </a>
                <a href="#"
                    class="bg-indigo-900 border border-indigo-900 text-white px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm flex items-center add_more_product"
                    data-url="{{ route('addMoreProduct', ['id' => $product->id]) }}"
                    data-id="{{ $product->id }}">
                    <span class="mr-2"><i
                            class="fa-solid fa-cart-shopping"></i></span>
                    {{ __('titles.Add to Cart') }}
                </a>
                <a href="#"
                    class="hidden border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm">
                    <span class="mr-2"><i
                            class="far fa-heart"></i></span>
                    {{ __('titles.Wishlist') }}
                </a>
            </div>
            <!-- {{ __('titles.Add to Cart') }} button end -->
            <!-- product share icons -->
            <div class="flex space-x-3 mt-6">
                <span
                    class="text-gray-500 mr-3 flex items-center justify-center">{{ __('titles.Share') }}:</span>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <!-- product share icons end -->
        </div>
        <!-- product content end -->
    </div>
    <!-- product view end -->

    <!-- product details and review -->
    <div class="container pb-16 mx-auto mt-20">
        <!-- detail buttons -->
        <h3
            class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium text-xl uppercase">
            {{ __('titles.Product Details') }}
        </h3>
        <!-- details button end -->

        <!-- details content -->
        <div class="lg:w-4/5 xl:w-3/5 pt-8">
            <div class="space-y-5 text-gray-600 text-lg">
                <p class="leading-6">
                    {!! $product->description !!}
                </p>
            </div>
        </div>
        <!-- details content end -->
    </div>
    <!-- product details and review end -->
@endsection
