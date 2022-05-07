@component('mail::message')
    <h1 style="text-align: center;">WEEK SALES REPORT</h1>
    <p style="text-align: center;">
        Time from {{ date('d-m-Y', strtotime('-1 week', strtotime(date('d-m-Y')))) }} to {{ date('d-m-Y') }}
    </p>

@component('mail::table')
    @php
        $num = 1;
        $total = 0;
    @endphp
    | No | Username | Order Code | Total order value | Create At |
    |:-----------------:|:------------------------:|:-------------------------:|:---------------------:|:---------------------:|
    @foreach ($data as $order)
        @php
            $total += $order->sum_price;
        @endphp
    | {{ $num++ }} | {{ $order->user->name }} | {{ $order->code }} | {{ vndFormat($order->sum_price) }} | {{ $order->created_at }} |
    @endforeach
@endcomponent
<h3 style="float: right; background: green; padding: 5px 10px; color: white">
    {{ __('Subtotal') }} : {{ vndFormat($total) }}
</h3>
@endcomponent
