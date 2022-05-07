@extends('admin.admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('titles.statistic_order') }}
                </div>
                <div class="row">
                    <form method="post">
                        @csrf
                        <div class="col-md-2">
                            <p>{{ __('titles.select_month') }} <select
                                    name="month" id="select_month"
                                    class="select-filter-order form-control">
                                    <option>-- {{ __('titles.select_month') }} --
                                    </option>
                                    <option value="1">{{ __('titles.January') }}
                                    </option>
                                    <option value="2">
                                        {{ __('titles.February') }} </option>
                                    <option value="3">{{ __('titles.March') }}
                                    </option>
                                    <option selected value="4">
                                        {{ __('titles.April') }}
                                    </option>
                                    <option value="5">{{ __('titles.May') }}
                                    </option>
                                    <option value="6">{{ __('titles.June') }}
                                    </option>
                                    <option value="7">{{ __('titles.July') }}
                                    </option>
                                    <option value="8">{{ __('titles.August') }}
                                    </option>
                                    <option value="9">
                                        {{ __('titles.September') }} </option>
                                    <option value="10">
                                        {{ __('titles.October') }} </option>
                                    <option value="11">
                                        {{ __('titles.November') }} </option>
                                    <option value="12">
                                        {{ __('titles.December') }} </option>
                                </select>
                            </p>
                            <br>
                            <input type="button" id="btn-date-filter-order"
                                class="btn btn-primary btn-sm"
                                value="{{ __('titles.Search') }}"
                                data-url="{{ route('statistic.selectMonthOrder') }}">
                            </p>

                        </div>
                        <div class="col-md-2">
                            <p>{{ __('titles.select_year') }} <select name="year"
                                    id="select_year"
                                    class="select-filter-order form-control">
                                    <option>-- {{ __('titles.select_year') }} --
                                    </option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option selected value="2022">2022</option>
                                </select>
                            </p>

                        </div>
                    </form>
                </div>
                <div class="panel-body" id="graph-container">
                    <canvas id="line-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('statistic')
    <script src="{{ asset('js/statistic_order.js') }}"></script>
@endsection
