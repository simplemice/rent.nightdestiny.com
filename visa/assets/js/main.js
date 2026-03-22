$(document).ready(function() {

    if (!$('.new_return').is(':checked')) {
        $('.fs-place-out').hide();
    }

    $('.new_return').click(function() {
        if ($(this).is(':checked')) {
            $('.fs-place-out').show(300);
        } else {
            $('.fs-place-out').hide(300);
        }
    });

    /**
     * DatePicker
     */
    var $start = $('#date_from');
    var $end = $('#date_to');

    $start.flatpickr({
        //defaultDate: new Date(),
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        altInput: true,
        altFormat: 'd.m.Y H:i',
        time_24hr: true,
        minDate: 'today',
        locale: 'en',
        onChange: function(selectedDates, dateStr, instance) {
            var newdate = new Date(selectedDates[0]);
            newdate.setDate(newdate.getDate() + 3);

            var fp = document.querySelector('#date_to')._flatpickr;

            if (fp.latestSelectedDateObj < newdate) {
                fp.config.minDate = newdate;
                fp.setDate(newdate);
            }

            //fp.open();
        }
    });

    $end.flatpickr({
        //defaultDate: new Date().fp_incr(3),
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        altInput: true,
        altFormat: 'd.m.Y H:i',
        time_24hr: true,
        minDate: new Date().fp_incr(3),
        locale: 'en',
        onChange: function(selectedDates, dateStr, instance) {
            var newdate = new Date(selectedDates[0]);
            newdate.setDate(newdate.getDate() - 3);
            if (selectedDates < newdate) {
                $start.val(newdate);
            }
        }
    });

    $('.js-recalculate', $('.js-form-place')).on('change', function() {
        var total = parseFloat($('#js-total').data('price'));

        var sum = 0;
        $('.js-recalculate:checked').each(function(k, v) {
            sum += parseFloat($(v).data('price'));
        });

        $('#js-total').text(total + sum);
    });

});

// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

/**
 * Place an order
 */
$('.js-form-place').on('submit', function(e) {
    e.preventDefault();

    var $form = $(this);

    if (this.checkValidity() === false) {
        e.stopPropagation();
    } else {
        this.classList.add('was-validated');

        $.ajax({
            type: 'POST',
            url: '/api/send.php',
            data: $form.serializeArray(),
            beforeSend: function(data) {
                $form.find('button[type="submit"]').attr('disabled', 'disabled');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong!'
                });
            },
            success: function(data) {
                var orderNo = data.payload.order;

                Swal.fire({
                    icon: 'success',
                    title: 'Спасибо!',
                    html: 'Ваша заявка отправлена! ' +
                        '<br>' +
                        'Номер Заказа: ' + orderNo + ''
                });
            },
            complete: function(data) {
                $form.find('button[type="submit"]').prop('disabled', false);
                $form.trigger('reset');
            }
        });
    }
});
