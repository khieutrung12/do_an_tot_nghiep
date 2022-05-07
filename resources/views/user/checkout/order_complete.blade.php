@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto px-4 pt-16 pb-24 mb-48 text-center">

        <h2 class="text-gray-800 font-medium text-3xl mb-10">
            {{ __('titles.order-complete') }}
        </h2>
        <p class="text-gray-600 ">
            {{ __('messages.order-complete') }}
        </p>
    </div>
@endsection
