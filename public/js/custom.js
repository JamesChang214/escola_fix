function refundPaymentFn(button, id) {
    $.ajax({
        type: 'post',
        url: "get/invoices/payment/refund",
        data: {
            payment_id: id,
        },
        success: function (data) {
            $('#refundModal').modal('show');
            $('.refund-modal-body-1').html(data.output1);
            $('.refund-modal-body-2').html(data.output2);
        },
        error: function () {
            new Noty({
                type: "danger",
                text: "<strong>Payment(s) has invalid data!</strong>",
                timeout: 10000
            }).show();
        }
    });
}

var paymentId = "";

function documentModal(id) {
    paymentId = id;
    $.ajax({
        type: 'post',
        url: "get/invoice/payment/details",
        data: {
            payment_id: id,
        },
        success: function (data) {
            $('#documentActionModal').modal('show');
            $('.document-action-modal-body').html(data.body);
            $('.document-action-modal-title').html(data.heading);
            $('#editDocumentActionModal').attr('href', '/admin/invoicepayment/' + id + '/edit');
            $('#void-payment-date').attr('data-date-start-date', data.payment_date);
            $('#void-payment-date').attr('data-date-end-date', data.today);
            if (data.voided) {
                $('#voidDocumentActionModal').attr('disabled', true);
            }
            else {
                $('#voidDocumentActionModal').attr('disabled', false);
            }
        },
        error: function () {
            new Noty({
                type: "danger",
                text: "<strong>Payment(s) has invalid data!</strong>",
                timeout: 10000
            }).show();
        }
    });
}

function voidPaymentModal() {
    $("#documentActionModal .close").click();
    $('#voidPaymentModal').modal('show');
}

$("#submitVoidPayment").click(function () {
    if ($('#void-payment-date').val()) {
        $.ajax({
            type: 'post',
            url: "payment/void",
            data: {
                payment_id: paymentId,
                date: $('#void-payment-date').val(),
                reason: $('#void-payment-reason :selected').val(),
            },
            success: function (result) {
                if (result.status == 1) {
                    new Noty({
                        type: "success",
                        text: "<strong>Payment Voided</strong>"
                    }).show();
                    window.location.reload();

                }
                if (result.status == 0) {
                    new Noty({
                        type: "info",
                        text: "<strong>Payment void failed</strong>",
                        timeout: 10000
                    }).show();
                }
            },
            error: function () {
                new Noty({
                    type: "danger",
                    text: "<strong>Payment(s) has invalid data!</strong>",
                    timeout: 10000
                }).show();
            }
        });
    }
    else {
        new Noty({
            type: "danger",
            text: "<strong>Please select a date</strong>",
            timeout: 10000
        }).show();
    }
});
