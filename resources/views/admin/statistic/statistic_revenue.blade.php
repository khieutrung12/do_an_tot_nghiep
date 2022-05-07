@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('titles.statistic_revenue') }}
                </div>
                <div class="row">
                    <form method="post">
                        @csrf
                        <div class="col-md-2">
                            <p>{{ __('titles.select_year') }}:
                                <select class="form-control"
                                    id="select-filter-revenue"
                                    data-url="{{ route('statistic.selectYearRevenue') }}">
                                    <option>-- {{ __('titles.select_year') }} --
                                    </option>
                                    <option value="2020">
                                        2020</option>
                                    <option value="2021">2021</option>
                                    <option selected value="2022">2022</option>
                                </select>
                            </p>
                        </div>
                    </form>
                </div>
                <div class="panel-body" id="graph-container">
                    <canvas id="chart_revenue"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('statistic')
    <script src="{{ asset('js/statistic_revenue.js') }}"></script>
@endsection
