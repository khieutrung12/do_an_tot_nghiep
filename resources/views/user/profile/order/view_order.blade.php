@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9 shadow rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
        <h1
            class="text-3xl font-medium mb-6 mx-6 pt-3.5 pb-8 border border-l-0 border-t-0 
            border-r-0 uppercase text-center">
            {{ __('messages.your-order') }}
        </h1>
        <h3 class="text-lg font-medium mb-6 mx-2 pt-1 pb-4  uppercase text-center">
            {{ __('titles.order') }}: <span
                class="uppercase">{{ $order->code }} </span>
        </h3>
        <div class="px-6 py-4 whitespace-nowrap">
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.order_date') }}:
                <span
                    class="font-semibold">{{ formatDate($order->created_at) }}</span>
            </div>
            @if ($order->created_at != $order->updated_at)
                <div class="text-lg py-2 text-gray-900">
                    {{ __('titles.order_processing_date') }}:
                    <span
                        class="font-semibold">{{ formatDate($order->updated_at) }}</span>
                </div>
            @endif
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.status') }}:
                <span class="font-semibold">
                    @if ($order->orderStatus->id === config('app.unconfirmed'))
                        {{ __('messages.unconfirmed') }}
                    @elseif($order->orderStatus->id === config('app.confirmed'))
                        {{ __('messages.confirmed') }}
                    @else
                        {{ __('messages.canceled') }}
                    @endif
                </span>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div
                        class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('titles.name-var', ['name' => __('titles.product')]) }}
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('titles.quantity') }}</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('titles.price') }}</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('titles.Total') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-200 divide-y divide-gray-200">
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($order->products as $product)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                                                        alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div
                                                        class="text-sm font-medium text-gray-900">
                                                        {{ $product->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $product->pivot->product_sales_quantity }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ vndFormat($product->price) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ vndFormat($product->price * $product->pivot->product_sales_quantity) }}
                                        </td>
                                        @php
                                            $total += $product->price * $product->pivot->product_sales_quantity;
                                        @endphp
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-medium text-gray-900">
                                                    {{ __('titles.total_product_price') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">

                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ vndFormat($total) }}
                                    </td>
                                </tr>
                                <tr>
                                    @if ($order->voucher != null)
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div
                                                        class="text-sm font-medium text-gray-900">
                                                        {{ __('titles.Voucher') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">

                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->voucher->value }}%
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div
                                                    class="text-sm font-medium text-gray-900">
                                                    {{ __('titles.transport_fee') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">

                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ vndFormat(0) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="ml-4">
                                                <div
                                                    class="text-2xl font-medium text-gray-900 ">
                                                    {{ __('titles.total_payment') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">

                                        </span>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-xl text-gray-500">
                                        {{ vndFormat($order->sum_price) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <h3
            class="text-2xl font-medium mt-32 mx-2 pt-1 pb-4  uppercase text-center">
            {{ __('titles.info-delivery') }}
        </h3>
        <div class="px-6 py-4 whitespace-nowrap">
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.name') }}:
                <span class="font-semibold">{{ $order->shipping->name }}</span>
            </div>
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.email') }}:
                <span class="font-semibold">{{ $order->shipping->email }}</span>
            </div>
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.phone') }}:
                <span class="font-semibold">{{ $order->shipping->phone }}</span>
            </div>
            <div class="text-lg py-2 text-gray-900">
                {{ __('titles.Shipping Address') }}:
                <span
                    class="font-semibold">{{ $order->shipping->address }}</span>
            </div>
        </div>
    </div>
    <!-- account content end -->
@endsection
