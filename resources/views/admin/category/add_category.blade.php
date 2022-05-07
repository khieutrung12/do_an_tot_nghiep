@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.add-var', ['name' => __('titles.category')]) }}
                </header>
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ __('messages.error') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('categories.store') }}"
                            method="post">
                            {{ csrf_field() }}
                            @php
                                $mess = Session::get('mess');
                            @endphp
                            @if ($mess)
                                <span class="text-alert">{{ $mess }}
                                </span>
                                <br><br>
                                @php
                                    Session::put('mess', null);
                                @endphp
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.name-var', ['name' => __('titles.category')]) }}
                                </label>
                                <input type="text" name="name" class="form-control"
                                    id="exampleInputEmail1"
                                    value="{{ old('name') }}"
                                    placeholder="Tên danh mục...">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.name-var', ['name' => __('titles.category')])]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    {{ __('titles.parent-category') }}</label>
                                <select name="parent_id"
                                    class="form-control select2">
                                    <option value="">{{ __('titles.none') }}
                                    </option>
                                    @foreach ($categories as $key => $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @foreach ($category->childCategories as $childCategory)
                                            <option
                                                value="{{ $childCategory->id }}"
                                                {{ old('parent_id') == $childCategory->id ? 'selected' : '' }}>
                                                -- {{ $childCategory->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" name="add_category_product"
                                class="btn btn-info">
                                {{ __('titles.add') }}</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-danger"
                    role="button">{{ __('titles.back_all_category') }}</a>
            </section>
        </div>
    </div>
@endsection
