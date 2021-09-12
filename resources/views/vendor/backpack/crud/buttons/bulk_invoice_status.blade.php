@if ($crud->hasAccess('bulkInvoiceStatus') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" data-toggle="modal" data-target="#invoiceStatusModal">Status</a>
@endif

@push('after_scripts')
<script>
    $(document).ready(function() {
        $(".submit-invoice-status").click(function() {
            $.ajax({
                url: "{{ url($crud->route) }}/invoices/status",
                type: 'POST',
                data: {
                    invoices: crud.checkedItems,
                    type: $(this).val(),
                },
                success: function(result) {
                    // Show an alert with the result
                    if (result.failed_msg) {
                        new Noty({
                            type: "info",
                            text: result.failed_msg,
                            timeout: 10000
                        }).show();
                    }
                    if (result.status == 1) {
                        if (result.success > 0) {
                            new Noty({
                                type: "success",
                                text: "<strong>" + result.success + " invoices status updated</strong>"
                            }).show();
                        }

                        if (result.failed > 0) {
                            new Noty({
                                type: "danger",
                                text: "<strong>" + result.failed + " invoices status update failed</strong>"
                            }).show();
                        }

                        crud.checkedItems = [];
                        crud.table.draw(true);
                    }
                    $("#invoiceStatusModal .close").click();
                },
                error: function(result) {
                    // Show an alert with the result
                    new Noty({
                        type: "danger",
                        text: "<strong>Request failed</strong>"
                    }).show();
                }
            });
        });
    });
</script>
@endpush