require([
    "jquery",
    "jquery/ui"
], function ($) {

    $('#stop-payment-custom-button').click(function () {
        var body = $('body').loader();
        body.loader('show');
        var str = this.className;
        var orderData = str.split("_class_");
        orderId = orderData[1];
        url = orderData[2];
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                // format: 'json',
                orderId: orderId
            },
            dataType: 'json',
            success: function (data) {
                if (data['return'] === true) {
                    location.reload();
                    body.loader('hide');
                } else {
                    alert(data['return']);
                    body.loader('hide');
                }
            },
            error: function (request, error)
            {
                alert(error);
            }
        });

    });


});

