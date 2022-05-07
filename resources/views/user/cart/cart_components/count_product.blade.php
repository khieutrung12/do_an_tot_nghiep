@if (Session::has('data'))
    <span id="update_count_product">{{ count(Session::get('data')['carts']) }}</span>
@else
    <span>0</span>
@endif
