@extends('layouts.app')

@section('content')
    <!-- banner -->
    <div class="bg-head bg-cover bg-no-repeat bg-center pt-20 pb-40 relative m-auto">
        <div class="container m-auto">
            <!-- banner content -->
            <h1 class="xl:text-6xl md:text-5xl text-4xl text-white font-bold mb-8">
                Technology Is Best <br class="hidden sm:block"> When It Brings People Together
            </h1>
            <!-- banner button -->
            <div class="mt-36">
                <a href="{{ route('shop') }}" class="text-xl bg-indigo-900 border border-indigo-900 text-white px-8 py-3 font-medium rounded-md uppercase hover:bg-gray-200
               hover:text-indigo-900 transition">
                    {{ __('titles.Shop now') }}
                </a>
            </div>
            <!-- banner button end -->
            <!-- banner content end -->
        </div>
    </div>
    <!-- banner end -->

    <!-- features -->
    <div class="container py-16 m-auto">
        <div class="lg:w-10/12 grid md:grid-cols-3 gap-3 lg:gap-6 mx-auto justify-center">

            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/freeship.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.free shipping') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.Order over $200') }}</p>
                </div>
            </div>
            <!-- single feature end -->
            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/moneyreturn.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.Money returns') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.30 Days money return') }}</p>
                </div>
            </div>
            <!-- single feature end -->
            <!-- single feature -->
            <div
                class="border-indigo-900 border rounded-sm px-8 lg:px-3 lg:py-6 py-4 flex justify-center items-center gap-5 bg-white">
                <img src="{{ asset('images/icons/support.png') }}" class="lg:w-12 w-10 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">{{ __('titles.24/7 Support') }}</h4>
                    <p class="text-gray-500 text-xs lg:text-sm">{{ __('titles.Customer support') }}</p>
                </div>
            </div>
            <!-- single feature end -->

        </div>
    </div>
    <!-- features end -->
    <!-- top new arrival -->
    <div class="container pb-16 m-auto">
        <div class="flex ">
            <h2 class="text-2xl md:text-3xl font-medium text-gray-800 uppercase mb-6">
                {{ __('titles.top-new-arrival') }}
            </h2>
            <a href="{{ route('shop') }}" class=" text-indigo-900 flex items-center justify-end flex-grow">
                {{ __('titles.see-more') }}
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>
        <!-- product wrapper -->
        <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-6">
            @foreach ($topNew as $product)
                <div class="button-product rounded bg-white shadow-2xl overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                            class="w-80 h-80">
                        <div class="product absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center gap-2 opacity-0 transition">
                            <a href="{{ route('show', $product->slug) }}"
                                class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                <i class="fas fa-search"></i>
                            </a>
                            <a href="#"
                                class="hidden text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                <i class="far fa-heart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="{{ route('show', $product->slug) }}">
                            <h4
                                class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-indigo-900 transition">
                                {{ $product->name }}
                            </h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p
                                class="text-lg text-indigo-900 font-roboto font-semibold">
                                {{ vndFormat($product->price) }}
                                <input type="hidden" name="_token"
                                    value={{ csrf_token() }}>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex gap-1 text-sm text-yellow-400">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                            </div>
                            <div class="text-xs text-gray-500 ml-3">(150)</div>
                        </div>
                    </div>
                    <a href="#"
                        data-url="{{ route('addToCart', ['id' => $product->id]) }}"
                        class="block w-full py-1 text-center text-white bg-indigo-900 border border-indigo-900 rounded-b hover:bg-transparent hover:text-indigo-900 transition add_to_cart">
                        {{ __('titles.Add to Cart') }}
                    </a>
                </div>
            @endforeach
        </div>
        <!-- product wrapper end -->
    </div>
    <!-- top new arrival end -->
@endsection
