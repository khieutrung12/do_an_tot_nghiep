$(function () {
    $('#input-search').keyup(function () {
        var _text = $(this).val();
        if (_text != '') {
            $.ajax({
                method: 'GET',
                url: '/search-product?name=' + _text,
                success: function (response) {
                    $('.search-ajax-result').html(response);
                }
            });
        } else {
            $('.search-ajax-result').html('');
        }
    })
});
