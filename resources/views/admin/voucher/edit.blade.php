<!-- Edit Voucher Modal -->
<div class="modal fade" id="editVoucher" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close close-action" data-dismiss="modal">&times;</button>
                <h5 class="modal-title">
                    {{ __('titles.edit_voucher') }}
                </h5>
            </div>
            <form action="{{ route('vouchers.update') }}" method="POST" id="form_edit_voucher">
                @csrf
                @method("PATCH")
                <input type="hidden" name="cid">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name_voucher">
                            {{ __('titles.name-var', ['name' => __('titles.Voucher')]) }}
                        </label>
                        <input type="text" name="name"
                            class="name form-control"
                            id="name_voucher">
                        <span class="text-danger error-text error_name"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="quantity_voucher">
                            {{ __('titles.quantity') }}</label>
                        <input id="quantity_voucher" type="text" name="quantity"
                            class="quantity form-control">
                        <span class="text-danger error-text error_quantity"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="value_voucher">
                            {{ __('titles.value'). ' ' . config('voucher.discount') }}</label>
                        <input id="value_voucher" type="text" name="value"
                            class="value form-control">
                        <span class="text-danger error-text error_value"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="condition_min_price">
                            {{ __('titles.condition_min_price'). ' ' . config('voucher.currency') }}
                        </label>
                        <input
                            id="condition_min_price"
                            type="text" name="condition_min_price"
                            class="condition_min_price form-control">
                        <span class="text-danger error-text error_condition_min_price"></span>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="maximum_reduction">
                            {{ __('titles.maximum_reduction'). ' ' . config('voucher.currency') }}
                        </label>
                        <input
                            id="maximum_reduction"
                            type="text" name="maximum_reduction"
                            class="maximum_reduction form-control">
                        <span class="text-danger error-text error_maximum_reduction"></span>
                    </div>

                    <div class="form-group mb-3">
                        <label for="start_date">
                            {{ __('titles.start_date') }}
                        </label>
                        <input
                            type="date"
                            class="start_date form-control"
                            min="{{ date('Y-m-d', strtotime('-3 year', strtotime(date('Y-m-d')))) }}"
                            max="{{ date('Y-m-d', strtotime('+3 year', strtotime(date('Y-m-d')))) }}"
                            name="start_date">
                        <span class="text-danger error-text error_start_date"></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="end_date">
                            {{ __('titles.end_date') }}
                        </label>
                        <input
                            type="date"
                            class="end_date form-control"
                            max="{{ date('Y-m-d', strtotime('+3 year', strtotime(date('Y-m-d')))) }}"
                            min=""
                            name="end_date" id="id_end_date">
                        <span class="text-danger error-text error_end_date"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_edit_voucher" class="btn btn-primary add_voucher">
                        {{ __('titles.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Edit Voucher Modal -->
