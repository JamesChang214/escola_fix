@if ($crud->hasAccess('bulkInvoiceVoid') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" data-toggle="modal" data-target="#invoiceVoidModal">Void</a>
@endif

@push('after_scripts')
<script>
    $(document).ready(function() {
        $("#submitInvoiceVoid").click(function() {
            $.ajax({
                url:  "{{ url($crud->route) }}/invoices/void",
                type: 'POST',
                data: {
                    invoices: crud.checkedItems,
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
                        new Noty({
                            type: "success",
                            text: "<strong>Invoices voided</strong>"
                        }).show();

                        crud.checkedItems = [];
                        crud.table.draw(true);
                    }
                    $("#invoiceVoidModal .close").click();
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