'use strict';
(function ($, Drupal, drupalSettings) {
    $(document).ready(function () {
        function closeDay() {
            $('.closeOrder').on('click', function () {
                var elem = $(this);
                $.post("/order/close_day", {
                    id: $('body').attr('id')
                }).done(function (data) {
                    console.log(data);
                    if (data && data.status === 'ok') {
                        elem.replaceWith('<button class="btn btn-success reopenOrder" type="button">Reopen Order</button>');
                        reopenDay();
                    }
                });
            });
        }

        function reopenDay() {
            $('.reopenOrder').on('click', function () {
                var elem = $(this);
                $.post("/order/reopen_day", {
                    id: $('body').attr('id')
                }).done(function (data) {
                    console.log(data);
                    if (data && data.status === 'ok') {
                        elem.replaceWith('<button class="btn btn-danger closeOrder" type="button">Close Order</button>');
                        closeDay()
                    }
                });
            });
        }

        // only call close day
        closeDay();
    });
})(jQuery, Drupal, drupalSettings);
