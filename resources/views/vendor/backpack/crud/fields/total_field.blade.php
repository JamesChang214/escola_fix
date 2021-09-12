<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<input type="number" name="{{ $field['name'] }}" value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}" @include('crud::fields.inc.attributes')>

{{-- HINT --}}
@if (isset($field['hint']))
<p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
@php
$crud->markFieldTypeAsLoaded($field);
@endphp

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script>
    $(document).ready(function() {
        function updateTotals() {
            // element will be a jQuery wrapped DOM node
            var container = $('[data-repeatable-identifier=invoiceItems]');
            var total = 0;
            var discount = 0;
            container.each(function(i, el) {
                var rowNumber = i + 1;
                var value = ($("[data-repeatable-input-name='amount'][data-row-number='" + rowNumber + "']").val() * $("[data-repeatable-input-name='quantity'][data-row-number='" + rowNumber + "']").val()) - $("[data-repeatable-input-name='discount'][data-row-number='" + rowNumber + "']").val();
                $("[data-repeatable-input-name='total_amount'][data-row-number='" + rowNumber + "']").val(Number(value).toFixed(2));
                total += value;
                discount += parseInt($("[data-repeatable-input-name='discount'][data-row-number='" + rowNumber + "']").val());
            });
            $("input[name='sub_total']").val(Number(total).toFixed(2));
            $("input[name='discount']").val(Number(discount).toFixed(2));
            $("input[name='total_amount']").val(Number(total - discount).toFixed(2));
        }
        $(document).on("change", "[data-repeatable-input-name='amount'],[data-repeatable-input-name='quantity'], [data-repeatable-input-name='discount']", function(e) {
            updateTotals();
        });
        $(document).on("change", "[data-repeatable-input-name='invoice_fee_type_id']", function(e) {
            // console.log("Target ", e.target.getAttribute('data-row-number'));
            $.ajax({
                type: 'get',
                url: 'get/fee/type/' + e.target.value + '/value',
                success: function(data) {
                    $("[data-repeatable-input-name='amount'][data-row-number='" +  e.target.getAttribute('data-row-number') + "']").val(data.amount);
                    $(".revenue_start_date > .date > input[type=text][data-bs-datetimepicker][data-row-number='" +  e.target.getAttribute('data-row-number') + "']").val(data.start_date);
                    $(".revenue_end_date > .date > input[type=text][data-bs-datetimepicker][data-row-number='" +  e.target.getAttribute('data-row-number') + "']").val(data.end_date);
                    updateTotals();
                }
            });
        });
    });
</script>
@endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}