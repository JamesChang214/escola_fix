@if ($crud->hasAccess('bulkClassersInvoice') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" data-toggle="modal" data-target="#classersInvoice">Invoice</a>
@endif

@push('after_scripts')
<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    var sel_fees = [];
    var all_fees = [];
    var calcNet = function(id) {
        var net = 0;
        net = ($('#classers-invoice-price-' + id).val() * $('#classers-invoice-quantity-' + id).val()) - $('#classers-invoice-discount-' + id).val();
        $('#classers-invoice-net-' + id).val(net);
        calcTotal();
    }
    var calcTotal = function() {
        var total = 0;
        var discount = 0;
        $('.classers-discount-class').each(function() {
            discount += Number(this.value);
        });
        $('.net-class').each(function() {
            total += Number(this.value);
        });
        $('#classers-invoice-total-discount').val(discount);
        $('#classers-invoice-total-net').val(total);
    }

    var createSelectedFeeTable = function(val) {
        var output = "";
        if (val.payment_instructions && !$('#classer-invoice-instruction-1').val()) {
            $('#classer-invoice-instruction-1').val(val.payment_instructions);
        }
        if (val.small_print && !$('#classer-invoice-instruction-2').val()) {
            $('#classer-invoice-instruction-2').val(val.small_print);
        }
        output = '<tr id="table-row-c-invoice-' + val.id + '"><td><a id="classers-remove-fee-invoice" class="btn" type="button" data-id="' + val.id + '"><i class="las la-trash-alt"></i></a></td><td>' + val.name + '<br><br><textarea class="form-control" id="classers-invoice-description-' + val.id + '" type="text">' + val.name + '</textarea></td>' +
            '<td>' + val.revenue_start_date +
            '</td>' +
            '<td>' + val.revenue_end_date + '</td>' +
            '<td><input class="form-control" id="classers-invoice-price-' + val.id + '" type="text" value="' + val.amount +
            '" disabled></input></td>' +
            '<td><input class="form-control classers-quantity-class" id="classers-invoice-quantity-' + val.id +
            '" type="number" min="0" value="1" data-id="' + val.id +
            '"></input></td>' +
            '<td><input class="form-control classers-discount-class" id="classers-invoice-discount-' + val.id +
            '" type="number" min="0" value="0" data-id="' + val.id +
            '"></input></td>' +
            '<td><input class="form-control net-class" id="classers-invoice-net-' + val.id +
            '" type="text" value="' + val.amount +
            '" disabled></input></td>' +
            '</tr>';
        // console.log(output);
        $('#tbody-modal-classers-invoice').append(output);
    }

    $(document).ready(function() {
        $.ajax({
            type: 'post',
            url: 'get/grades/subjects',
            success: function(data) {
                $('#grades').html(data.grades);
            }
        });

        var fee_types = '<option value="" data-id="">Select Fee Type</option>';
        $.ajax({
            type: 'get',
            url: 'search/fee/types',
            success: function(data) {
                // console.log('test', data.output);
                all_fees = data.output;
                jQuery.each(data.output, function(i, val) {
                    fee_types += '<option value="' + i + '" data-id="' + val.id + '">' + val.short_name + '</option>';
                });
                $('#feesClassersInvoice').html(fee_types);
            }
        });

        $("#submitFeeTypeClassers").click(function() {
            if ($('#feesClassersInvoice :selected').val()) {
                sel_fees.push(all_fees[$('#feesClassersInvoice :selected').val()]);
                // console.log(sel_fees);$('#classer-invoice-instruction-1').val()
                createSelectedFeeTable(all_fees[$('#feesClassersInvoice :selected').val()]);
                $('#addFeeTypeClassers').modal('hide');
                calcNet($('#feesClassersInvoice :selected').attr('data-id'));
            } else {
                new Noty({
                    type: "danger",
                    text: "<strong>Select fee type</strong>"
                }).show();
            }
        });

        $("#closeClassersInvoice").click(function() {
            sel_fees = [];
            $('#classers-invoice-total-discount').val('');
            $('#classers-invoice-total-net').val('');
            $('#tbody-modal-classers-invoice').empty();
            $('#classer-invoice-instruction-1').val('');
            $('#classer-invoice-instruction-2').val('');
            $('#classer-invoice-due-date').val('');
            $('#classer-invoice-issue-date').val('');
            $('#feesClassersInvoice').val('');
        });

        $("#submitClassersInvoice").click(function() {
            var check = true;
            var selectedFees = {};
            var ajax_calls = [];
            var classers_invoice_url = "{{ url($crud->route) }}/classers/invoice";

            jQuery.each(sel_fees, function(i, val) {
                var id = val.id;
                selectedFees[id] = [];
                selectedFees[id].push($('#classers-invoice-quantity-' + id).val());
                selectedFees[id].push($('#classers-invoice-discount-' + id).val());
                selectedFees[id].push($('#classers-invoice-net-' + id).val());
                selectedFees[id].push($('#classers-invoice-description-' + id).val());
            });

            // console.log("Output - ",selectedFees);

            if (!jQuery.isEmptyObject(selectedFees)) {
                $("#classersInvoice .close").click();
                $.ajax({
                    url: classers_invoice_url,
                    type: 'POST',
                    data: {
                        classers: crud.checkedItems,
                        total: $('#classers-invoice-total-net').val(),
                        total_discount: $('#classers-invoice-total-discount').val(),
                        selected_fees: selectedFees,
                        instruction1: $('#classer-invoice-instruction-1').val(),
                        instruction2: $('#classer-invoice-instruction-2').val(),
                        due_date: $('#classer-invoice-due-date').val(),
                        issue_date: $('#classer-invoice-issue-date').val(),
                    },
                    success: function(result) {
                        // Show an alert with the result
                        if (result.status == 1) {
                            new Noty({
                                type: "success",
                                text: "<strong>Classers invoice created</strong>"
                            }).show();

                            crud.checkedItems = [];
                            crud.table.draw(false);
                            sel_fees = [];
                            $('#classers-invoice-total-discount').val('');
                            $('#classers-invoice-total-net').val('');
                            $('#tbody-modal-classers-invoice').empty();
                            $('#classer-invoice-instruction-1').val('');
                            $('#classer-invoice-instruction-2').val('');
                            $('#classer-invoice-due-date').val('');
                            $('#classer-invoice-issue-date').val('');

                        }
                        if (result.status == 0) {
                            new Noty({
                                type: "info",
                                text: "<strong>Invoice creation failed</strong>",
                                timeout: 10000
                            }).show();
                        }
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "danger",
                            text: "<strong>Classers invoice creation failed</strong><br /> Invoice items did not satisify the conditions"
                        }).show();
                    }
                });
            } else if (!check) {
                new Noty({
                    type: "warning",
                    text: "<strong>Select start date(s)!</strong>"
                }).show();
            } else {
                new Noty({
                    type: "warning",
                    text: "<strong>Select atleast one class!</strong>"
                }).show();
            }

        });
    });

    // $('#searchFee').keyup(searchFunction);
    $("body").on('change', '.classers-quantity-class,.classers-discount-class', function() {
        calcNet($(this).attr('data-id'));
    });

    $("body").on('click', '#classers-remove-fee-invoice', function() {
        sel_fees.splice($(this).attr('data-id'), 1);
        $('#table-row-c-invoice-' + $(this).attr('data-id')).empty();
        calcTotal();
    });
</script>
@endpush

<style>
    .modal-large {
        width: 80%;
        max-width: 80%;
    }

    .classers-invoice-modal {
        overflow: auto;
        max-height: 400px;
    }

    .date-div {
        display: flex;
        align-items: center;
    }

    .date-div label {
        margin-bottom: 0px;
    }
</style>