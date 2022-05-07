function updateCart(event) {
    event.preventDefault();
    let urlUpdateCart = $(".update_cart_url").data("url");
    let id = $(this).data("id");
    let quantity = $(".quantityProductCart" + id).val();
    let _token = $('input[name="_token"]').val();
    $.ajax({
        type: "PUT",
        url: urlUpdateCart,
        data: {
            id: id,
            quantity: quantity,
            _token: _token,
        },
        success: function (data) {
            if (data.code === 200) {
                $("#cart_wrapper").html(data.cart_component);
                toastr.success(data.messageCart);
            }
        },
    });
}
function deleteCart(event) {
    event.preventDefault();
    let urlDeleteCart = $(".delete_cart_url").data("url_delete");
    let id = $(this).data("id");
    let _token = $('input[name="_token"]').val();
    $.ajax({
        type: "DELETE",
        url: urlDeleteCart,
        data: {
            id: id,
            _token: _token,
        },
        success: function (data) {
            if (data.code === 200) {
                $("#cart_wrapper").html(data.cart_component);
                renderCart();
                toastr.success(data.messageCart);
            }
        },
    });
}
function addToCart(event) {
    event.preventDefault();
    let urlCart = $(this).data("url");
    let _token = $('input[name="_token"]').val();
    $.ajax({
        method: "POST",
        url: urlCart,
        dataType: "json",
        data: {
            _token: _token,
        },
        success: function (data) {
            if (data.code === 200) {
                renderCart();
                toastr.success(data.messageCart);
            }
        },
    });
}
function renderCart() {
    let urlCountProduct = $(".count_product").data("url_count_product");
    $.ajax({
        type: "GET",
        url: urlCountProduct,
        dataType: "json",
        success: function (data) {
            if (data.code === 200) {
                $(".count_product").html(data.count_product);
            }
        },
        error: function () {},
    });
}

function addMoreProduct(event) {
    event.preventDefault();
    let id = $(this).data("id");
    let quantity = $("#input-number_" + id).val();
    let urlAddMoreProduct = $(this).data("url");
    let _token = $('input[name="_token"]').val();
    $.ajax({
        type: "POST",
        url: urlAddMoreProduct,
        dataType: "json",
        data: {
            quantity: quantity,
            _token: _token,
        },
        success: function (data) {
            if (data.code === 200) {
                renderCart();
                toastr.success(data.messageCart);
            }
        },
    });
}

function addQuantity() {
    let id = $(this).data("id");
    let quantity = $("#input-number_" + id).val();
    let urlAddQuantity = $(this).data("url");
    let _token = $('input[name="_token"]').val();
    $.ajax({
        type: "POST",
        url: urlAddQuantity,
        dataType: "json",
        data: {
            quantity: quantity,
            _token: _token,
        },
    });
}

$(function () {
    $(document).on("click", ".cart_update", updateCart);
    $(document).on("click", ".cart_delete", deleteCart);
    $(document).on("click", ".add_to_cart", addToCart);
    $(document).on("click", ".add_more_product", addMoreProduct);
    $(document).on("click", ".add_quantity", addMoreProduct);
});
