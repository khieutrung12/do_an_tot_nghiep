@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9 shadow-2xl rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
        <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="text-lg font-medium capitalize mb-6 ml-6 mr-6 pb-4 border border-l-0 border-t-0 border-r-0">
                {{ __('titles.Profile Information') }}
            </h3>
            <div class="flex">
                <div class="space-y-6 w-11/12 px-6">
                    <div class="grid sm:grid-cols-1 gap-4">
                        <label class="text-gray-600 mb-0 block">
                            {{ __('titles.name') }}
                        </label>
                        <input
                            type="text"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('name') border-red-600 @enderror"
                            name="name" value="{{ $user->name }}" required>
                        @error('name')
                        <p class="text-indigo-900 text-xs italic">
                            {{ __($message, ['name' => __('titles.name')] )}}
                        </p>
                        @enderror
                    </div>
    
                    <div class="grid sm:grid-cols-1 gap-4">
                        <label class="text-gray-600 mb-0 block">
                            {{ __('titles.birthday') }}
                        </label>
                        <input
                            type="date"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-40"
                            max="{{ date('Y-m-d', strtotime('-18 year', strtotime(date('Y-m-d')))) }}"
                            min="{{ date('Y-m-d', strtotime('-200 year', strtotime(date('Y-m-d')))) }}"
                            name="birthday" value="{{ $user->birthday }}">
                    </div>
    
                    <div class="grid sm:grid-cols-1 gap-4">
                        <label class="text-gray-600 mb-0 block">
                            {{ __('titles.gender') }}
                        </label>
                        <select
                            class="w-full form-select appearance-none block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-white bg-white focus:border-indigo-900"
                            name="gender">
                            <option value="" {{ $user->gender_id == null ? 'selected' : '' }}>
                                {{ __('titles.Pick gender') }}
                            </option>
                            @foreach ($genders as $gender)
                                <option value="{{ $gender->id }}" {{ $user->gender_id == $gender->id ? 'selected' : '' }}>
                                    {{ __('titles.' . $gender->gender) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="grid sm:grid-cols-1 gap-4">
                        <label class="text-gray-600 mb-0 block">
                            {{ __('titles.phone') }}
                        </label>
                        <input
                            type="text"
                            name="phone"
                            class="w-full block border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded placeholder-gray-400 @error('phone') border-red-600 @enderror"
                            value="{{ $user->phone }}">
                        @error('phone')
                        <p class="text-indigo-900 text-xs italic">
                            {{ __($message, ['name' => __('titles.phone')] )}}
                        </p>
                        @enderror
                    </div>
                </div>
    
                <div class="w-full px-6 ml-6 inline m-auto border border-b-0 border-t-0 border-r-0">
                    @if ($user->avatar != null)
                        <img
                            src="{{ asset('avatars/' . $user->avatar ) }}"
                            class="w-52 rounded-full m-auto mb-5"
                            alt="">
                    @else
                        <img
                            src="{{ asset('images/user.png') }}"
                            class="w-52 rounded-full m-auto mb-5"
                            alt="">
                    @endif
                        
                    <input
                        type="file"
                        name="avatar"
                        accept="image/png, image/jpeg, image/jpg"
                        class="cursor-pointer absolute opacity-0 flex justify-items-center items-center ml-48 mt-2 w-auto">
                    <input type="hidden" value="{{ $user->avatar }}" name="image">
                    <label for="file" class="p-3 bg-cool-gray-700 rounded-3xl w-max-content text-center m-auto flex justify-items-center items-center text-gray-200">
                        {{ __('titles.Choose a photo') }}
                    </label>
                    <p class="mt-5 ml-28 m-auto flex justify-items-center items-center text-cool-gray-600 text-sm">
                        {{ __('titles.File size: maximum ') . config('specavatar.maximum.size') . config('specavatar.maximum.unit')  }}<br />
                        {{ __('titles.File extension: ') . config('specavatar.extension')}}
                    </p>
                </div>
            </div>

            <div class="mt-6 ml-6">
                <button
                    type="submit"
                    class="px-6 py-2 text-center text-white bg-indigo-900 border border-indigo-900 rounded hover:bg-transparent hover:text-indigo-900 transition uppercase font-roboto font-medium">
                    {{ __('titles.Save change') }}
                </button>

                @if ($message = Session::get('message'))
                <span
                    class="text-gray-600 italic ml-4">
                    {{ $message }}
                </span>
                @endif
            </div>

        </form>
    </div>
    <!-- account content end -->
@endsection
