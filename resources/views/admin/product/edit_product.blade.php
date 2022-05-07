@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    {{ __('titles.update-var', ['name' => __('titles.product')]) }}
                </header>
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
                <div class="panel-body">
                    <div class="position-center col-lg-9">
                        <form role="form"
                            action="{{ route('products.update', ['product' => $edit_product->id]) }}"
                            method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            @method('PUT')
                            <input type="hidden" name="id"
                                value="{{ $edit_product->id }}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.name-var', ['name' => __('titles.product')]) }}
                                </label>
                                <input type="text" name="name" class="form-control"
                                    id="exampleInputEmail1"
                                    value="{{ $edit_product->name }}">
                                @error('name')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.name-var', ['name' => __('titles.product')])]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.quantity') }}</label>
                                <input type="text" name="quantity"
                                    class="form-control"
                                    value="{{ $edit_product->quantity }}">
                                @error('quantity')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.quantity')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.price') }}</label>
                                <input type="text" name="price"
                                    class="form-control" id="exampleInputEmail1"
                                    value="{{ $edit_product->price }}">
                                @error('price')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.price')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.description') }}</label>
                                <textarea name="description" class="form-control" id="desc_product_ckeditor">
                                {{ $edit_product->description }}
                                    </textarea>
                                @error('description')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.description')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    {{ __('titles.name-var', ['name' => __('titles.brand')]) }}</label>
                                <select name="brand_id"
                                    class="form-control input-sm m-bot15">
                                    @foreach ($brands as $key => $brand)
                                        @if ($brand->id == $edit_product->brand_id)
                                            <option selected
                                                value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </option>
                                        @else
                                            <option value="{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    {{ __('titles.name-var', ['name' => __('titles.category')]) }}</label>
                            </div>
                            <select name="categories[]" id="demo1"
                                class="subcategory" multiple="multiple">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $edit_product->category->contains($category->id) ? 'selected' : '' }}>
                                        {{ $category->parentCategory->parentCategory->name }}
                                        --
                                        {{ $category->parentCategory->name }}
                                        -- {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.image-thumbnail') }}</label>
                                <input type="file" name="image_thumbnail"
                                    class="form-control" id="exampleInputEmail1">
                                <img src="{{ asset('images/uploads/products/' . $edit_product->image_thumbnail) }}"
                                    class="style-image">
                                <input type="hidden" name="image_thumbnail_save"
                                    value="{{ $edit_product->image_thumbnail }}">
                                @error('image_thumbnail')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('titles.image_thumbnail')]) }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">
                                    {{ __('titles.list-image') }}
                                </label>
                                <input type="file" name="images[]"
                                    class="form-control" id="exampleInputEmail1"
                                    multiple />
                                @error('images')
                                    <span class="text-alert">
                                        {{ __($message, ['name' => __('title.list-image')]) }}</span>
                                @enderror
                            </div>
                            <button type="submit" name="add_product"
                                class="btn btn-info">
                                {{ __('titles.update') }}
                            </button>
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            @foreach ($edit_product->images as $img)
                                <form
                                    action="{{ route('deleteimage', ['id' => $img->id]) }}"
                                    method="post">
                                    <button type="submit"
                                        class="btn text-danger">X</button>
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <img src="{{ asset('images/uploads/products/' . $img['image']) }}"
                                    class="style-all-image">
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
@endsection
@section('multiple_select_categories')
    <script>
        CKEDITOR.replace('ckeditor');
        CKEDITOR.replace('add_product_ckeditor');
        CKEDITOR.replace('desc_product_ckeditor');
        $(function() {
            $('#demo').multiselect({
                nonSelectedText: 'Select Categories',
                enableHTML: true,
                enableCaseInsensitiveFiltering: true,
                buttonClass: 'subcategory',
            });
            $('#demo1').multiselect({
                nonSelectedText: 'Select Categories',
                enableHTML: true,
                enableCaseInsensitiveFiltering: true,
                buttonClass: 'subcategory',
                selectAllValue: 'multiselect-all'
            });
        });
    </script>
@endsection
