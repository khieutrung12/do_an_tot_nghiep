@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.add-brand') }}
                </header>
                @if ($errors->any())
                    <div class="alert alert-danger text-center">
                        {{ __('messages.error') }}
                    </div>
                @endif
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" action="{{ route('brands.store') }}"
                            method="post">
                            {{ csrf_field() }}
                            @php
                                $mess = Session::get('mess');
                            @endphp
                            @if ($mess)
                                <span
                                    class="text-alert">{{ Session::get('mess') }}
                                </span>
                                <br><br>
                                @php
                                    Session::put('mess', null);
                                @endphp
                            @endif
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.brand-name') }}
                                </label>
                                <input type="text" name="name" class="form-control"
                                    id="exampleInputEmail1"
                                    value="{{ old('name') }}"
                                    placeholder="Tên thương hiệu...">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.brand-name')]) }}</span>
                                @enderror
                            </div>
                            <button type="submit" name="add_category_product"
                                class="btn btn-info">
                                {{ __('titles.add') }}</button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('brands.index') }}" class="btn btn-danger"
                    role="button">{{ __('titles.back_all_brand') }}</a>
            </section>
        </div>
    </div>
@endsection
