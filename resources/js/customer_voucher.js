$(function () {
    $(document).on('click', '#btn_show', function () {
        var code = $(this).data('code');
        $.ajax({
            method: 'GET',
            url: '/show-voucher',
            data: {
                code: code,
            },
            success: function (response) {
                $('.show').html(response);
            }
        });
    });

    $(document).on('click', '#close', function () {
        $('#modal_show_voucher').addClass('hidden');
    });

    $(document).on('click', '#btn_ok', function () {
        $('#modal_show_voucher').addClass('hidden');
    });
});
