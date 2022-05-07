<div class="xl:col-span-3 lg:col-span-4 border border-gray-200 px-4 py-4 rounded mt-6 lg:mt-0 shadow-md" id="order-summary">
    <!-- title -->
    <h4 class="text-gray-800 text-lg mb-6 font-medium uppercase">
        {{ __('titles.Order summary') }}
    </h4>
    <!-- title end -->
    <!-- info checkout -->
    <div class="space-y-3 text-gray-600 pb-3 border-b border-gray-200 mb-6">
        <div class="flex justify-between font-medium">
            <p> {{ __('titles.Subtotal') }}</p>
            <p>{{ vndFormat($total) }}</p>
        </div>
        <div class="flex justify-between">
            <p> {{ __('titles.Delivery') }}</p>
            <p>{{ __('titles.Free') }}</p>
        </div>
        <div class="flex justify-between" id="info-discount">
            <p>
                {{ __('titles.discount') }}
                @if ($data['percent'] != 0)
                    {{ ' (' . $data['percent'] . config('voucher.discount') .')' }}
                @endif
            </p>
            <p>{{ vndFormat($data['discount']) }}</p>
        </div>
    </div>
    <!-- info checkout end -->
    <!-- total -->
    <div
        class="flex justify-between my-6 text-gray-800 font-semibold uppercase">
        <h4>{{ __('titles.Total') }}</h4>
        <h4>{{ vndFormat($total + $data['discount']) }}</h4>
    </div>
    <!-- total end -->
    <!-- info voucher -->
    @if (isset($data['voucher']))
        <div class="info-voucher mb-5 flex justify-between">
            <span class="text-gray-600 mt-1">
                {{ __('titles.Voucher') }}
            </span>
            <div class="flex space-x-2 absolute ">
                <span class="ml-36 mr-1 text-xs border-dotted border-2 border-gray-500 px-2 py-1 text-gray-500">
                    {{ $data['voucher']->name }}
                </span>
                <form action="{{ route('carts.delete.voucher') }}" method="POST"
                    class="hover:text-gray-500 text-sm cursor-pointer mt-1">
                    @csrf
                    @method('delete')
                    <button type="submit">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    <!-- info voucher end -->
    @else
    <!-- searchbar -->
        <form action="{{ route('carts.apply.voucher') }}" method="POST" class="mb-5">
            @csrf
            <div class="flex mb-1" >
                <input type="hidden" name="total" value="{{ $total }}">
                <input type="text"
                    class="pl-4 w-full border border-r-0 border-indigo-900 py-2 px-3 rounded-l-md focus:ring-indigo-900 focus:border-indigo-900 text-sm"
                    placeholder="Coupon"
                    @if (Session()->get('code'))
                        value={{ Session()->get('code') }}
                    @else
                        value="{{ old('coupon') }}"
                    @endif
                    name="coupon" id="coupon">
                <button type="submit"
                    id="btn_apply_voucher"
                    class="bg-indigo-900 border border-indigo-900 text-white px-5 font-medium rounded-r-md hover:bg-transparent hover:text-indigo-900 transition text-sm font-roboto">
                    {{ __('titles.Apply') }}
                </button>
            </div>
            @error('coupon')
                <span class="text-red-600 error-text error_coupon text-xs">
                    {{ __($message, ['name' => __('titles.voucher')] )}}
                </span>
            @enderror
        </form>
    @endif
    <!-- searchbar end -->
    <!-- checkout -->
    <a href="{{ route('checkout') }}"
        class="bg-indigo-900 border border-indigo-900 text-white px-4 py-3 font-medium rounded-md uppercase hover:bg-transparent
    hover:text-indigo-900 transition text-sm w-full block text-center">
        {{ __('titles.Process to checkout') }}
    </a>
    <!-- checkout end -->
</div>
