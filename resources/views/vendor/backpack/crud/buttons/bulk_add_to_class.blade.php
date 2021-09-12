@if ($crud->hasAccess('bulkAddClass') && $crud->get('list.bulkActions'))
<a class="btn btn-sm btn-secondary bulk-button" type="button" data-toggle="modal" data-target="#toClass">Add To Class</a>
@endif

@push('after_scripts')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ asset('packages/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'post',
            url: 'get/grades/subjects',
            success: function(data) {
                $('#grades').html(data.grades);
                $('#subjects').html(data.subjects);
            }
        });
        $.ajax({
            type: 'get',
            url: 'search/classes',
            success: function(data) {
                // console.log(data.output);
                $('#tbody-modal-to-class').html(data.output);
            }
        });
        $("#submitAddToClass").click(function() {
            var check = true;
            var checkedClasses = {};
            $('input[name="class-check"]:checked').each(function() {
                if ($("#start-date-" + this.value).val()) {
                    checkedClasses[this.value] = $("#start-date-" + this.value).val();
                } else {
                    check = false;
                }
            });
            console.log(checkedClasses);
            var ajax_calls = [];
            var add_to_class = "{{ url($crud->route) }}/add/to/class";

            if (check && !jQuery.isEmptyObject(checkedClasses)) {
                $.ajax({
                    url: add_to_class,
                    type: 'POST',
                    data: {
                        students: crud.checkedItems,
                        classes: checkedClasses,
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
                        if (result.success_count) {
                            new Noty({
                                type: "success",
                                text: "<strong>" + result.success_count + " students added to class</strong>"
                            }).show();

                            crud.checkedItems = [];
                            crud.table.draw(false);
                            $('#searchClass').val('');
                            $('#grades').val('');
                            $('#day').val('');
                            $('#tbody-modal-to-class').html('');

                        }
                        $("#toClass .close").click();
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "danger",
                            text: "<strong>Students addition to class failed</strong>"
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
    var searchFunction = function() {
        $.ajax({
            type: 'get',
            url: 'search/classes',
            data: {
                'search': $('#searchClass').val(),
                'grade': $('#grades :selected').val(),
                'day': $('#day :selected').val(),
                'subject': $('#subjects :selected').val(),
            },
            success: function(data) {
                // console.log(data.output);
                $('#tbody-modal-to-class').html(data.output);
            }
        });
    }
    $('#searchClass').keyup(searchFunction);
    $('#grades').change(searchFunction);
    $('#day').change(searchFunction);
    $('#subjects').change(searchFunction);
</script>
@endpush

<style>
    .datepicker-dropdown {
        padding-left: 0.7rem;
    }

    .add-to-class-modal {
        border-color: #6852ed;
    }

    .add-to-class-modal-body {
        overflow: auto;
        max-height: 700px;
    }
</style>