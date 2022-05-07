@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.all-var', ['name' => __('titles.product')]) }}
            </div>
            <div class="table-responsive">
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
                <table class="table table-striped b-t b-light" id="products_table">
                    <thead>
                        <tr>
                            <th class="width-css">
                            </th>
                            <th> {{ __('titles.name-var', ['name' => __('titles.product')]) }}
                            </th>
                            <th> {{ __('titles.slug') }}</th>
                            <th> {{ __('titles.quantity') }}</th>
                            <th> {{ __('titles.price') }}</th>
                            <th> {{ __('titles.image-thumbnail') }}</th>
                            <th> {{ __('titles.brand') }}</th>
                            <th> {{ __('titles.category') }}</th>
                            <th class="width-css"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_product as $key => $pro)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <p class="stt">
                                        {{ $pro->name }}
                                    </p>
                                </td>
                                <td> {{ $pro->slug }}</td>
                                <td> {{ $pro->quantity }}</td>
                                <td> {{ $pro->price }}</td>
                                <td> <img
                                        src="{{ asset('images/uploads/products/' . $pro->image_thumbnail) }}"
                                        class="style-image">
                                </td>
                                <td>{{ $pro->brand->name }}</td>
                                <td>
                                    @foreach ($pro->category as $name)
                                        {{ $name->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', ['product' => $pro->id]) }}"
                                        class="active styling-edit"
                                        ui-toggle-class="">
                                        <i
                                            class="fas fa-edit text-success text-active"></i></a>
                                    <form
                                        action="{{ route('products.destroy', ['product' => $pro->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-icon"
                                            onclick="return confirm('{{ __('messages.confirmDelete', ['name' => __('titles.product')]) }}')">
                                            <i
                                                class="fa fa-times text-danger text"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#products_table").DataTable();
        });
    </script>
@endsection
