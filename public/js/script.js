$(document).ready(function () {
    $('body').on('click', '.partners-dropdown li', function () {
        var v = $(this).children().text();
        $('#partner-name').text(v);
    });

    $('body').on('click', '.status-dropdown li', function () {
        var v = $(this).children().text();
        $('#status-name').text(v);
    });

    $('[id^="product-"]').change(function () {
        var dataArray = [];
        $('[id^="product-"]').each(function () {
            dataArray[$(this).attr('id')] = $(this).val();
        });
        dataObj = Object.assign({}, dataArray);

        $.ajax({
            type: 'GET',
            data: dataObj,
            url: '/order-sum',
            cache: false,
            success: function (response) {
                $('#ordercost').val(response);
            }
        });
    });

    $('[id^="price-product-"]').change(function () {
        var dataArray = [];
        dataArray['id'] = $(this).attr('id');
        dataArray['price'] = $(this).val();
        dataObj = Object.assign({}, dataArray);

        $.ajax({
            type: 'POST',
            data: dataObj,
            url: '/product-price',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
            }
        });
    });
});