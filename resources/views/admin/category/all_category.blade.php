@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <a href="{{ route('categories.create') }}" class="btn btn-danger"
            role="button">{{ __('titles.add-var', ['name' => __('titles.category')]) }}</a>
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.all-var', ['name' => __('titles.category')]) }}
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
                <table class="table table-striped b-t b-light" id="categories_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __('titles.name-var', ['name' => __('titles.category')]) }}
                            </th>
                            <th>{{ __('titles.parent-category') }}</th>
                            <th>{{ __('titles.slug') }}</th>
                            <th class="width-css"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allCategory as $key => $category)
                            @include(
                                'admin.category.index_row',
                                compact('category', 'key')
                            )

                            @foreach ($category->childCategories as $childCategory)
                                @include(
                                    'admin.category.index_row',
                                    [
                                        'category' => $childCategory,
                                        'prefix' => '-----',
                                    ]
                                )

                                @foreach ($childCategory->childCategories as $childCategory)
                                    @include(
                                        'admin.category.index_row',
                                        [
                                            'category' => $childCategory,
                                            'prefix' => '-----------',
                                        ]
                                    )
                                @endforeach
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#categories_table").DataTable();
        });
    </script>
@endsection
