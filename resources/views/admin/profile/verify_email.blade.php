@extends('admin.admin_layout')
@section('admin_content')

<h4 class="page-title">{{ __('titles.verify-email') }}</h4>
<div class="container-verify-email">
    <div class="title-verify-email">
        {{ __('titles.verify-email') }}
    </div>
    <form action="" method="POST" class="content-verify-email">
        @csrf
        <label for="email">
            {{ __('titles.email') }}
        </label>
        <input type="text" name="email" value="{{ old('email') }}" class="form-control">
        @error('email')
        <p class="text-danger">
            {{ __($message, ['name' => __('titles.email')] )}}
        </p>
        @enderror
        <div class="button">
            <a href="{{ route('admin.profile') }}">
                {{ __('titles.back') }}
            </a>
            <button type="submit" class="btn-save">
                {{ __('titles.send-email') }}
            </button>
        </div>
    </form>
</div>
@endsection
