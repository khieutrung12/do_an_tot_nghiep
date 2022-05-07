@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.info-customer') }}
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th> {{ __('titles.name') }}</th>
                            <th>{{ __('titles.phone') }}</th>
                            <th>{{ __('titles.email') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->user->phone }}</td>
                            <td>{{ $order->user->email }}</td>
                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br>
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.info-delivery') }}
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th> {{ __('titles.name') }}</th>
                            <th>{{ __('titles.address') }}</th>
                            <th>{{ __('titles.phone') }}</th>
                            <th>{{ __('titles.email') }}</th>
                            <th>{{ __('titles.note') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->shipping->name }}</td>
                            <td>{{ $order->shipping->address }}</td>
                            <td>{{ $order->shipping->phone }}</td>
                            <td>{{ $order->shipping->email }}</td>
                            <td>{{ $order->shipping->note }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br><br>

    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.list-order-details') }}
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>#</th>

                            <th>{{ __('titles.name-var', ['name' => __('titles.product')]) }}
                            </th>
                            <th>{{ __('titles.quantity') }}</th>
                            <th>{{ __('titles.price') }}</th>
                            <th>{{ __('titles.Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $key => $order_product)
                            <tr>
                                <th>
                                    {{ $key + 1 }}
                                </th>
                                <th>
                                    {{ $order_product->name }}
                                </th>
                                <th>
                                    {{ $order_product->pivot->product_sales_quantity }}
                                </th>
                                <th>
                                    {{ vndFormat($order_product->price) }}
                                </th>
                                <th>
                                    {{ vndFormat($order_product->price * $order_product->pivot->product_sales_quantity) }}
                                </th>
                            </tr>
                        @endforeach
                        @if ($order->voucher != null)
                            <tr>
                                <td colspan="2">
                                    {{ __('titles.Voucher') }}:
                                    {{ $order->voucher->value }}%
                                </td>
                            </tr>
                        @endif
                        <tr>

                            <td colspan="2">
                                {{ __('titles.Total') }}:
                                {{ vndFormat($order->sum_price) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{ __('titles.code') }}:
                                {{ $order->code }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
