@extends('admin.admin_layout')
@section('admin_content')

<!-- Add Voucher Modal -->
@include('admin.voucher.create')
<!-- End Add Voucher Modal -->

<!-- Edit Voucher Modal -->
@include('admin.voucher.edit')
<!-- End Edit Voucher Modal -->
<h4 class="page-title">{{ __('titles.voucher') }}</h4>
<div class="panel panel-default">
    <a  href="#"
        data-toggle="modal" data-target="#addVoucher"
        class="btn-add">
        <i class="fa-solid fa-circle-plus"></i>
        <span>{{ __('titles.add_voucher') }}</span>
    </a>
    <div class="table-responsive">
        <table class="table table-hover mt-10" id="vouchers-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" name="main_checkbox">
                        <label></label>
                    </th>
                    <th>{{ __('titles.No') }}</th>
                    <th>{{ __('titles.name-var', ['name' => __('titles.Voucher')]) }}</th>
                    <th>{{ __('titles.code') }}</th>
                    <th>{{ __('titles.quantity') }}</th>
                    <th>{{ __('titles.value') . ' ' . config('voucher.discount') }} </th>
                    <th>{{ __('titles.condition_min_price') . ' ' . config('voucher.currency') }}</th>
                    <th>{{ __('titles.maximum_reduction'). ' ' . config('voucher.currency') }}</th>
                    <th>{{ __('titles.start_date') }}</th>
                    <th>{{ __('titles.end_date') }}</th>
                    <th><button class="btn btn-sm btn-danger hidden" id="deleteAllBtn">{{ __('titles.delete_all') }}</button></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
