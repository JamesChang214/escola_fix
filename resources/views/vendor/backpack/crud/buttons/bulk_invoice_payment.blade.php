@if ($crud->hasAccess('bulkInvoicePayment') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" id="invoicePaymentInvoke">Payment</a>
@endif

@push('after_scripts')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    if (typeof bulkStatusEntries != 'function') {
        function bulkStatusEntries(button) {

            if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
                new Noty({
                    type: "warning",
                    text: "<strong>{{ trans('backpack::crud.bulk_no_entries_selected_title') }}</strong><br>{{ trans('backpack::crud.bulk_no_entries_selected_message') }}"
                }).show();

                return;
            }
        }
    }

    $(document).on('hidden.bs.modal', '#invoicePaymentModal', function() {
        $('.invoice-payment-modal-body').html("");
    })

    $(document).ready(function() {
        $("#invoicePaymentInvoke").click(function() {
            $.ajax({
                url: "check/invoices/status",
                type: 'GET',
                data: {
                    invoices: crud.checkedItems,
                },
                success: function(result) {
                    if (result.draft.length == 0) {
                        $.ajax({
                            type: 'post',
                            url: "get/invoices/payments",
                            data: {
                                invoices: crud.checkedItems,
                            },
                            success: function(data) {
                                $('#invoicePaymentModal').modal('show');
                                $('.invoice-payment-modal-body').html(data.output);
                            },
                            error: function() {
                                new Noty({
                                    type: "danger",
                                    text: "<strong>Invoice(s) has invalid data!</strong>",
                                    timeout: 10000
                                }).show();
                            }
                        });
                    } else {
                        new Noty({
                            type: "danger",
                            text: "<strong>Invoice(s) must be approved before payment!</strong>",
                            timeout: 10000
                        }).show();
                    }
                }
            });
        });

        $("#submitInvoicePayment").click(function() {
            var check = true;
            var invoiceFees = {};
            var ajax_calls = [];
            var invoice_payments_url = "make/invoices/payment";

            jQuery.each(crud.checkedItems, function(i, val) {
                invoiceFees[val] = [];
                invoiceFees[val].push($('#paid-invoice-' + val).val());
                invoiceFees[val].push($('#transaction-type-' + val).val());
                invoiceFees[val].push($('#external-comment-invoice-' + val).val());
                invoiceFees[val].push($('#internal-comment-invoice-' + val).val());
                invoiceFees[val].push($('#transaction-date-' + val).val());
            });

            $.ajax({
                url: invoice_payments_url,
                type: 'POST',
                data: {
                    invoice_fees: invoiceFees,
                    print_receipt: $('#print_receipt').is(":checked"),
                },
                success: function(result) {
                    // Show an alert with the result
                    if (result.status == 1) {
                        new Noty({
                            type: "success",
                            text: "<strong>Invoice payment created</strong>"
                        }).show();

                        $("#invoicePaymentModal .close").click();

                        if (result.payment_ids) {
                            for (let index = 0; index < result.payment_ids.length; index++) {
                                const id = result.payment_ids[index];
                                window.open('get/receipt/' + id + '/pdf');
                            }
                        }
                        crud.checkedItems = [];
                        crud.table.draw(false);
                    }
                    if (result.status == 0) {
                        new Noty({
                            type: "info",
                            text: "<strong>Invoice payment creation failed</strong>",
                            timeout: 10000
                        }).show();
                    }
                },
                error: function(result) {
                    // Show an alidert with the result
                    new Noty({
                        type: "danger",
                        text: "<strong>Invoice payment creation failed</strong>"
                    }).show();
                }
            });
        });
    });
</script>
@endpush

<style>
    .invoice-payment-modal-body {
        overflow: auto;
        max-height: 700px;
    }
</style>