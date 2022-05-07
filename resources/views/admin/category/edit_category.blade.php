@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.update-var', ['name' => __('titles.category')]) }}
                </header>
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ __('messages.error') }}
                    </div>
                @endif
                <div class="panel-body">
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
                    <div class="position-center">
                        <form role="form"
                            action="{{ route('categories.update', ['category' => $productCategory->id]) }}"
                            method="POST">
                            {{ csrf_field() }}
                            @method('PUT')
                            <input type="hidden" name="id"
                                value="{{ $productCategory->id }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.name-var', ['name' => __('titles.category')]) }}</label>
                                <input type="text"
                                    value="{{ $productCategory->name }}"
                                    name="name" class="form-control"
                                    id="exampleInputEmail1">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.name-var', ['name' => __('titles.category')])]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">
                                    {{ __('titles.parent-category') }}</label>
                                <select class="form-control select2"
                                    name="parent_id" id="parent_id">
                                    <option value="">
                                        {{ __('titles.none') }}
                                    </option>
                                    @foreach ($categories as $category)
                                        @if ($productCategory->id !== $category->id)
                                            <option value="{{ $category->id }}"
                                                {{ old('parent_id', $productCategory->parent_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                            @foreach ($category->childCategories as $childCategory)
                                                @if ($productCategory->id !== $childCategory->id)
                                                    <option
                                                        value="{{ $childCategory->id }}"
                                                        {{ old('parent_id', $productCategory->parent_id) == $childCategory->id ? 'selected' : '' }}>
                                                        --
                                                        {{ $childCategory->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" name="update_brand_product"
                                class="btn btn-info">{{ __('titles.update') }}</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
