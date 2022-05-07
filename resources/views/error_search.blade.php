@extends('layouts.app')

@section('content')
    <div class="mt-32 ml-1/4 flex">
        <img src="{{ asset('images/Warning-rafiki.png') }}" class=" w-80 h-80" alt="">
        <div class=" text-indigo-800">
            <span class="font-semibold text-3xl">
                {{ __('messages.No Results Found') }}
            </span>
            <div class="mt-10 text-xl font-light">
                {{ __('messages.suggestions') }}
            </div>
            <p class="mt-5 ml-10 font-thin leading-8">
                {{ __('messages.suggestion_1') }} <br />
                {{ __('messages.suggestion_2') }} <br />
                {{ __('messages.suggestion_3') }} <br />
            </p>
        </div>
    </div>
@endsection
