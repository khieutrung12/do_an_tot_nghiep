@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9 shadow-2xl rounded px-6 pt-5 ml-6 mr-6 pb-7 mt-6 lg:mt-0 bg-white">
        <!-- page title -->
        <h3 class="text-lg font-medium capitalize mb-6 pb-4 border border-l-0 border-t-0 border-r-0">
            {{ __('titles.My vouchers') }}
        </h3>
        <!-- page title end -->
        <!-- navbarmenu -->
        <div class="flex py-3 bg-gray-200 space-x-20 pl-10 mb-6 shadow">
        </div>
        <!-- navbarmenu end-->
        <!-- modal show voucher-->
        <div class="show">
        </div>
        <!-- modal show voucher end-->
        <!-- list voucher -->
        <div class="flex flex-wrap">
            @php
                $index = 1;
            @endphp
            @foreach ($vouchers as $voucher)
            <div class="flex mb-5 @if ($index % 2 != 0) mr-8 @endif">
                <div class="shadow-md">
                    <div class="px-3 py-10 text-sm bg-blue-400  text-white text-center border-dotted border-l-8 border-white">TECHNOLOGY<br > WORLD</div>
                    <div></div>
                </div>
                <div class="pt-2 pl-3 leading-5 shadow-md border-gray-100 border pr-5 w-72">
                    <a href="{{ route('user.use.voucher', $voucher->code) }}" class="text-red-400 text-sm flex items-center justify-end flex-grow">
                        {{ __('titles.use') }}
                        <i class="fa-solid fa-angle-right mt-1 ml-1"></i>
                    </a>
                    <span class="block font-medium">
                        {{ __('titles.discount-percent') . ' ' . $voucher->value . config('voucher.discount') }}
                    </span>
                    <span class="block text-sm">
                        {{ __('titles.min-spend') . vndKFormat($voucher->condition_min_price) }}
                        {{ __('titles.capped-at') . vndKFormat($voucher->maximum_reduction) }}
                    </span>
                    <div class=" text-xs pt-3 flex items-center justify-between flex-grow">
                        <span class="text-red-400">
                            @php
                                $end_date = new DateTime($voucher->end_date . " 00:00:00");
                                $now = new DateTime();
                                $days = (int) $now->diff($end_date)->format('%a');
                                $hours = (int) $now->diff($end_date)->format('%h');
                                $minutes = (int) $now->diff($end_date)->format('%i');
                            @endphp
                            @if ($days >= 1)
                                {{ __('titles.valid-till') . $voucher->end_date }}
                            @else
                                {{ __('titles.expiring') . ': ' }}
                                @if ($hours >= 1)
                                    {{ $hours . ' ' . __('titles.hour') }}
                                @else
                                    {{ $minutes . ' ' . __('titles.minute') }}
                                @endif
                            @endif
                        </span>
                        <a href="#" id="btn_show" class=" text-blue-300" data-code="{{ $voucher->code }}">
                            {{ __('titles.t&c') }}
                        </a>
                    </div>
                </div>
            </div>
            @php
                $index++;
            @endphp
            @endforeach
        </div>
        <!-- list voucher end -->
    </div>
    <!-- account content end -->
@endsection
