@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.update-var', ['name' => __('titles.brand')]) }}
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
                            action="{{ route('brands.update', ['brand' => $edit_brand->id]) }}"
                            method="POST">
                            {{ csrf_field() }}
                            @method('PUT')
                            <div class="form-group">
                                <input type="hidden" name="id"
                                    value="{{ $edit_brand->id }}">
                                <label
                                    for="exampleInputEmail1">{{ __('titles.brand-name') }}</label>
                                <input type="text" value="{{ $edit_brand->name }}"
                                    name="name" class="form-control"
                                    id="exampleInputEmail1">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.brand-name')]) }}</span>
                                @enderror
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
