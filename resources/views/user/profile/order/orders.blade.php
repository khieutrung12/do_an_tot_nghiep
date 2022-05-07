@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9 shadow-2xl rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
        <h3
            class="text-lg font-medium capitalize mb-12 mx-6 pt-3.5 pb-8 border border-l-0 border-t-0 border-r-0">
            {{ __('titles.your-order') }}: {{ $orders->total() }}
            {{ __('titles.order') }}
        </h3>
        @foreach ($orders as $order)
            <h1 class="font-bold">#{{ $order->code }}</h1>
            <h1 class="font-normal my-2">{{ formatDate($order->created_at) }}</h1>
            <div class="flex">
                <a class="py-2 px-2 font-bold border-2 rounded border-black"
                    href="{{ route('viewDetailOrder', ['id' => $order->id]) }}">{{ __('titles.view_order') }}</a>
                <span
                    class="bg-transparent text-blue-700 font-semibold 
                    py-2 px-4 flex items-center justify-end flex-grow">
                    @if ($order->orderStatus->id === config('app.unconfirmed'))
                        {{ __('messages.unconfirmed') }}
                    @elseif($order->orderStatus->id === config('app.confirmed'))
                        {{ __('messages.confirmed') }}
                    @else
                        {{ __('messages.canceled') }}
                    @endif
                </span>
            </div>
            <div class="mb-10">
                @foreach ($order->products as $product)
                    <a href="{{ route('show', ['product' => $product->slug]) }}">
                        <div
                            class="max-w-md mx-auto bg-white rounded-xl shadow-2xl-md overflow-hidden md:max-w-4xl bg-gray-100 ">
                            <div class="md:flex">
                                <div class="md:shrink-0">
                                    <img class="h-48 w-full object-cover md:h-full md:w-48"
                                        src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                                        alt="Man looking at item at a store">
                                </div>
                                <div class="p-8">
                                    <div
                                        class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">
                                        {{ $product->name }}</div>
                                    <a href="#"
                                        class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">x{{ $product->pivot->product_sales_quantity }}</a>
                                    <p class="mt-2 text-slate-500">
                                        {{ vndFormat($product->price) }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <h1
                            class="uppercase tracking-wide text-lg text-indigo-500 font-semibold">
                            {{ __('titles.Total') }}:
                            {{ vndFormat($order->sum_price) }}</h1>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-sm-5 text-center">
            </div>
            <div class="col-sm-7 text-right text-center-xs">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                </ul>
            </div>
        </div>
        {{ $orders->links() }}
    </div>
    <!-- account content end -->
@endsection
