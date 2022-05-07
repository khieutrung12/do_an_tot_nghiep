@extends('admin.admin_layout')
@section('admin_content')

<h4 class="page-title">{{ __('titles.profile-admin') }}</h4>
<form action="{{ route('admin.update', $user->id) }}" method="POST"
    enctype="multipart/form-data" class="container-profile">
    @csrf
    @method('PUT')
    <div class="col-xl-4">
        <div class="title-profile">
            {{ __('titles.profile-picture') }}
        </div>
        <div class="content-avatar">
            @if ($user->avatar != null)
                <img
                    src="{{ asset('avatars/' . $user->avatar ) }}"
                    class="form-avatar"
                    alt="">
            @else
                <img
                    src="{{ asset('images/user.png') }}"
                    class="form-avatar"
                    alt="">
            @endif
            <div class="file div-file btn btn-lg">
                <label for="file" class="">
                    {{ __('titles.Choose a photo') }}
                </label>
                <input
                    type="file"
                    name="avatar"
                    accept="image/png, image/jpeg, image/jpg"
                    class="input-avatar">
            </div>
            <input type="hidden" value="{{ $user->avatar }}" name="image">
            <p class="">
                {{ __('titles.File size: maximum ') . config('specavatar.maximum.size') . config('specavatar.maximum.unit')  }}<br />
                {{ __('titles.File extension: ') . config('specavatar.extension')}}
            </p>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="title-profile">
            {{ __('titles.profile-details') }}
        </div>
        <div class="content-profile">
            <div class="form-group mb-3">
                <span for="name">
                    {{  __('titles.name') }}
                    <small class="text-danger">*</small>
                </span>
                <input type="text" name="name"
                    class="name form-control"
                    id="name" value="{{ $user->name }}">
                @error('name')
                <p class="">
                    {{ __($message, ['name' => __('titles.name')] )}}
                </p>
                @enderror
            </div>
            <div class="form-gender-birthday">
                <div class="form-gender mb-3 form-group">
                    <span for="gender">
                        {{ __('titles.gender') }}
                    </span>
                    <select
                        class="gender form-control"
                        name="gender">
                        <option value="">
                            {{ __('titles.Pick gender') }}
                        </option>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender->id }}" {{ $user->gender_id == $gender->id ? 'selected' : '' }}>
                                {{ __('titles.' . $gender->gender) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-birthday mb-3 form-group">
                    <span for="birthday">
                        {{ __('titles.birthday') }}
                    </span>
                    <input
                        type="date"
                        class="birthday form-control"
                        max="{{ date('Y-m-d', strtotime('-18 year', strtotime(date('Y-m-d')))) }}"
                        min="{{ date('Y-m-d', strtotime('-200 year', strtotime(date('Y-m-d')))) }}"
                        name="birthday" value="{{ $user->birthday }}">
                </div>
            </div>
            <div class="div-email">
                <div class="form-email form-group mb-3">
                    <span for="email">
                        {{ __('titles.email') }}
                        <small class="text-danger">*</small>
                    </span>
                    <input type="text" name="email"
                        class="email form-control" readonly
                        id="email" value="{{ $user->email }}">
                </div>
                <div class="div-email-verified">
                    @if (Session()->get('message_verify'))
                        <small>
                            {{ Session()->get('message_verify') }}
                        </small>
                    @elseif ($user->email_verified_at == null)
                        <a href="{{ route('admin.verify.email') }}" class="text-danger">
                            {{ __('messages.email-non-verified') }}
                        </a>
                    @else
                        <span>{{ __('messages.email-verified') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group mb-3">
                <span for="phone">
                    {{ __('titles.phone') }}
                    <small class="text-danger">*</small>
                </span>
                <input type="text" name="phone" readonly
                    class="phone form-control"
                    id="phone" value="{{ $user->phone }}">
            </div>
            <div class="form-group">
                <span for="address">
                    {{ __('titles.address') }}
                    <small class="text-danger">*</small>
                </span>
                <input type="text" name="address"
                    class="address form-control"
                    id="address" value="{{ $user->address }}">
                @error('address')
                <p class="">
                    {{ __($message, ['name' => __('titles.address')] )}}
                </p>
                @enderror
            </div>
            <button type="submit" class="btn-save">
                {{ __('titles.Save change') }}
            </button>
            @if ($message = Session::get('message'))
            <span
                class="">
                {{ $message }}
            </span>
            @endif
        </div>
    </div>
</form>
    

@endsection
