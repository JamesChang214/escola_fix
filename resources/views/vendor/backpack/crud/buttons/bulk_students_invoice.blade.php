@if ($crud->hasAccess('bulkStudentsInvoice') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" data-toggle="modal" data-target="#studentsInvoice">Invoice</a>
@endif

@push('after_scripts')
<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    var sel_fees = [];
    var all_fees = [];
    var calcNet = function(id) {
        var net = 0;
        net = ($('#students-invoice-price-' + id).val() * $('#students-invoice-quantity-' + id).val()) - $('#students-invoice-discount-' + id).val();
        $('#students-invoice-net-' + id).val(net);
        calcTotal();
    }
    var calcTotal = function() {
        var total = 0;
        var discount = 0;
        $('.students-discount-class').each(function() {
            discount += Number(this.value);
        });
        $('.net-class').each(function() {
            total += Number(this.value);
        });
        $('#students-invoice-total-discount').val(discount);
        $('#students-invoice-total-net').val(total);
    }

    var createSelectedFeeTable = function(val) {
        var output = "";

        if (val.payment_instructions && !$('#student-invoice-instruction-1').val()) {
            $('#student-invoice-instruction-1').val(val.payment_instructions);
        }
        if (val.small_print && !$('#student-invoice-instruction-2').val()) {
            $('#student-invoice-instruction-2').val(val.small_print);
        }
        output = '<tr id="table-row-s-invoice-' + val.id + '"><td><a id="students-remove-fee-invoice" class="btn" type="button" data-id="' + val.id + '"><i class="las la-trash-alt"></i></a></td><td>' + val.name + '<br><br><textarea class="form-control" id="students-invoice-description-' + val.id + '" type="text">' + val.name + '</textarea></td>' +
            '<td>' + val.revenue_start_date +
            '</td>' +
            '<td>' + val.revenue_end_date + '</td>' +
            '<td><input class="form-control" id="students-invoice-price-' + val.id + '" type="text" value="' + val.amount +
            '" disabled></input></td>' +
            '<td><input class="form-control students-quantity-class" id="students-invoice-quantity-' + val.id +
            '" type="number" min="0" value="1" data-id="' + val.id +
            '"></input></td>' +
            '<td><input class="form-control students-discount-class" id="students-invoice-discount-' + val.id +
            '" type="number" min="0" value="0" data-id="' + val.id +
            '"></input></td>' +
            '<td><input class="form-control net-class" id="students-invoice-net-' + val.id +
            '" type="text" value="' + val.amount +
            '" disabled></input></td>' +
            '</tr>';
        // console.log(output);
        $('#tbody-modal-students-invoice').append(output);
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
                $('#feesStudentsInvoice').html(fee_types);
            }
        });

        $("#submitFeeTypeStudents").click(function() {
            if ($('#feesStudentsInvoice :selected').val()) {
                sel_fees.push(all_fees[$('#feesStudentsInvoice :selected').val()]);
                // console.log(sel_fees);
                createSelectedFeeTable(all_fees[$('#feesStudentsInvoice :selected').val()]);
                $('#addFeeTypeStudents').modal('hide');
                calcNet($('#feesStudentsInvoice :selected').attr('data-id'));
            } else {
                new Noty({
                    type: "danger",
                    text: "<strong>Select fee type</strong>"
                }).show();
            }
        });

        $("#closeStudentsInvoice").click(function() {
            sel_fees = [];
            $('#students-invoice-total-discount').val('');
            $('#students-invoice-total-net').val('');
            $('#tbody-modal-students-invoice').empty();
            $('#student-invoice-instruction-1').val('');
            $('#student-invoice-instruction-2').val('');
            $('#student-invoice-issue-date').val('');
            $('#student-invoice-due-date').val('');
            $('#feesStudentsInvoice').val('');
        });

        $("#submitStudentsInvoice").click(function() {
            var check = true;
            var selectedFees = {};
            var ajax_calls = [];
            var students_invoice_url = "{{ url($crud->route) }}/students/invoice";

            jQuery.each(sel_fees, function(i, val) {
                var id = val.id;
                selectedFees[id] = [];
                selectedFees[id].push($('#students-invoice-quantity-' + id).val());
                selectedFees[id].push($('#students-invoice-discount-' + id).val());
                selectedFees[id].push($('#students-invoice-net-' + id).val());
                selectedFees[id].push($('#students-invoice-description-' + id).val());
            });

            if (!jQuery.isEmptyObject(selectedFees)) {
                $("#studentsInvoice .close").click();
                $.ajax({
                    url: students_invoice_url,
                    type: 'POST',
                    data: {
                        students: crud.checkedItems,
                        total: $('#students-invoice-total-net').val(),
                        total_discount: $('#students-invoice-total-discount').val(),
                        selected_fees: selectedFees,
                        instruction1: $('#student-invoice-instruction-1').val(),
                        instruction2: $('#student-invoice-instruction-2').val(),
                        issue_date: $('#student-invoice-issue-date').val(),
                        due_date: $('#student-invoice-due-date').val(),
                    },
                    success: function(result) {
                        // Show an alert with the result
                        if (result.status == 1) {
                            new Noty({
                                type: "success",
                                text: "<strong>Students invoice created</strong>"
                            }).show();

                            crud.checkedItems = [];
                            crud.table.draw(false);
                            sel_fees = [];
                            $('#students-invoice-total-discount').val('');
                            $('#students-invoice-total-net').val('');
                            $('#tbody-modal-students-invoice').empty();
                            $('#student-invoice-instruction-1').val('');
                            $('#student-invoice-instruction-2').val('');
                            $('#student-invoice-issue-date').val('');
                            $('#student-invoice-due-date').val('');
                        }
                        if (result.status == 0) {
                            new Noty({
                                type: "info",
                                text: "<strong>Students invoice creation failed</strong>",
                                timeout: 10000
                            }).show();
                        }
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "danger",
                            text: "<strong>Students invoice creation failed</strong>"
                        }).show();
                    }
                });
            } else {
                new Noty({
                    type: "warning",
                    text: "<strong>Add atleast one fee!</strong>"
                }).show();
            }
        });
    });

    $('#searchFee').keyup(searchFunction);
    $("body").on('change', '.students-quantity-class,.students-discount-class', function() {
        calcNet($(this).attr('data-id'));
    });

    $("body").on('click', '#students-remove-fee-invoice', function() {
        sel_fees.splice($(this).attr('data-id'), 1);
        $('#table-row-s-invoice-' + $(this).attr('data-id')).empty();
        calcTotal();
    });
</script>
@endpush

<style>
    .modal-large {
        width: 80%;
        max-width: 80%;
    }

    .students-invoice-modal {
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