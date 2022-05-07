@if (Session::get('data'))
    <div class="container lg:grid grid-cols-12 gap-6 items-start pb-16 pt-4 update_cart_url delete_cart_url m-auto"
        data-url="{{ route('updateCart') }}"
        data-url_delete="{{ route('deleteCart') }}">
        <!-- product cart -->
        <div class="xl:col-span-9 lg:col-span-8 ">
            <!-- cart title -->
            @if (isset($data['carts']) && sizeOf($data['carts']) != 0)
                <div
                    class="bg-gray-200 py-2 pl-12 pr-20 xl:pr-28 mb-4 hidden md:flex shadow-md">
                    <p class="text-gray-600 text-center mr-8">
                        {{ __('titles.product') }}
                    </p>
                    <p class="text-gray-600 text-center ml-80 mr-16 xl:mr-24">
                        {{ __('titles.quantity') }}
                    </p>
                    <p class="text-gray-600 text-center">
                        {{ __('titles.Total') }}
                    </p>

                </div>
            @endif
            <!-- cart title end -->
            <!-- shipping carts -->
            <div class="space-y-8">
                @php
                    $total = 0;
                @endphp
                @foreach ($data['carts'] as $id => $cartItem)
                    @php
                        $total += $cartItem['quantity'] * $cartItem['price'];
                    @endphp
                    <div
                        class="shadow-md flex items-center md:justify-between gap-4 md:gap-6 p-4 border border-gray-200 rounded flex-wrap md:flex-nowrap">
                        <!-- cart image -->
                        <div class="w-32 flex-shrink-0 style-image">
                            <a href="{{ route('show', $id) }}">
                                <img src="{{ asset('images/uploads/products/' . $cartItem['image_thumbnail']) }}"
                                    class="style-image w-full style-image">
                            </a>
                        </div>
                        <!-- cart image end -->
                        <!-- cart content -->
                        <div class="md:w-1/4 w-full">
                            <h2
                                class="text-gray-800 mb-3 xl:text-xl textl-lg font-medium uppercase">
                                <a href="{{ route('show', $id) }}">
                                    {{ $cartItem['name'] }}
                                </a>
                            </h2>
                            <p class="text-indigo-900 font-semibold">
                                {{ vndFormat($cartItem['price']) }}</p>
                            <input type="hidden" name="_token"
                                value={{ csrf_token() }}>
                        </div>
                        <!-- cart content end -->
                        <!-- cart quantity -->
                        <div
                            class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300">
                            <button id="decrement_{{ $id }}"
                                onclick="stepper('decrement_{{ $id }}')"
                                class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">-</button>
                            <input id="input-number_{{ $id }}"
                                type="number" min="1"
                                max="{{ $cartItem['total_product'] }}"
                                readonly value={{ $cartItem['quantity'] }}
                                class="appearance-none h-8 w-15 flex items-center justify-center cursor-not-allowed text-center quantityProductCart{{ $id }}">
                            <button id="increment_{{ $id }}"
                                onclick="stepper('increment_{{ $id }}')"
                                class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">+</button>
                        </div>
                        <!-- cart quantity end -->
                        <div class="ml-auto md:ml-0">
                            <p class="text-indigo-900 text-lg font-semibold">
                                {{ vndFormat($cartItem['quantity'] * $cartItem['price']) }}
                            </p>
                        </div>
                        <div
                            class="text-gray-600 hover:text-indigo-900 cursor-pointer">
                            <a href="#" data-id="{{ $id }}"
                                class="cart_update bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('titles.update') }}
                            </a>
                            <a href="#" data-id="{{ $id }}"
                                class="bg-indigo-900 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cart_delete">
                                {{ __('titles.delete') }}

                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- shipping carts end -->
        </div>
        <!-- product cart end -->
        <!-- order summary -->
        @if (isset($data['carts']) && sizeOf($data['carts']) != 0)
            @include(
                'user.cart.cart_components.order_summary'
            )
        @endif
        <!-- order summary end -->
    </div>
@endif
