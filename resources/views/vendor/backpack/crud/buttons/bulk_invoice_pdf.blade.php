@if ($crud->hasAccess('bulkInvoicePdf') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" href="javascript:void(0)" onclick="bulkPdf(this)">PDF</a>
@endif

@push('after_scripts')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        $("#submitInvoicePdf").click(function() {
            $("#invoicePdfConfirmModal .close").click();
            printPdf();
        });
    });

    function bulkPdf() {
        if (crud.checkedItems.length == 1) {
            printPdf();
        } else {
            $("#invoicePdfConfirmModal").modal("show");
        }
    }

    function printPdf() {
        $.ajax({
            url: "check/invoices/status",
            type: 'GET',
            data: {
                invoices: crud.checkedItems,
            },
            success: function(result) {
                // Show an alert with the result
                if (result.status == 1) {
                    if (result.approved.length > 0) {
                        new Noty({
                            type: "success",
                            text: "<strong>Downloading " + result.approved.length + " invoice(s)</strong>"
                        }).show();
                    }

                    if (result.draft.length > 0) {
                        new Noty({
                            type: "danger",
                            text: "<strong>" + result.draft.length + " invoice(s) are in draft</strong>"
                        }).show();
                    }

                    crud.checkedItems = [];
                    crud.table.draw(false);
                    if (result.approved.length > 1) {
                        for (let index = 0; index < result.approved.length; index++) {
                            const id = result.approved[index];
                            window.open('get/invoice/' + id + '/pdf/D');
                        }
                    }

                    if (result.approved.length == 1) {
                        window.open('get/invoice/' + result.approved[0] + '/pdf/O');
                    }
                } else {
                    new Noty({
                        type: "info",
                        text: "Operation Failed",
                        timeout: 10000
                    }).show();
                }
            },
            error: function(result) {
                // Show an alert with the result
                new Noty({
                    type: "danger",
                    text: "<strong>Request failed</strong>"
                }).show();
            }
        });
    }
</script>
@endpush