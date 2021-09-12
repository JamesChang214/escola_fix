@if ($crud->hasAccess('refund'))
    <a class="btn btn-xs btn-link" type="button" href="javascript:void(0)" onclick="refundPaymentFn(this,{{$entry->getKey()}})"><i class="fa fa-list"></i> Refund</a>
@endif