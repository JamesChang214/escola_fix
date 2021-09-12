@extends('layout.master', [
	'breadcrumb' => [
		'Reconciliations' => false,
	]
])

@section('page-title', 'Transaction Reconciliation')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div>
                <button class="btn btn-info" data-toggle="modal" data-target="#processModal">Process</button>
                <button class="btn btn-info" data-toggle="modal" data-target="#voidModal">void</button>
            </div>
            <div class="card mt-2">
                <div class="card-header">                
                   <form method="get" action="{{route('reconciliation-transaction')}}">
                        @csrf
                        <div style="width: 800px; float: left;">
                           <div class="form-group col-xs-12 col-sm-6 col-md-3 col-lg-3 col-xl-3">
                               <label for="name">Select Status</label>
                                <select class="form-control" name="filterfdstatus">
                                    <option value="">Status types</option> 
                                    <option value="Cleared">Cleared</Option>
                                    <option value="Deposited">Deposited</Option>
                                </select>
                            </div>
                        </div>
                        <div style="margin-left: 820px;">
                           <div class="row md-2">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                                    <button class="btn btn-success btn px-5" type="submit">
                                        <i class="la la-search-plus mr-2"></i>
                                        Search
                                    </button>
                                    <button class="btn btn-primary btn px-5" type="reset">
                                        <i class="la la-recycle mr-2"></i>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover table-sm table-responsive-sm">
                        <thead>
                            <tr>
                                <th  style="text-align: center; vertical-align: middle">
                            <input id="inline-checkbox1" type="hidden" value="check1">
                                </th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Type</th>
                                <th>Doc N0</th>
                                <th>Student/vendor</th>
                                <th>Status</th>
                                <th>Cleared Date</th>
                                <th>Cleared By</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $datum)
                            <tr>
                                <td><input type="checkbox" value="{{$datum->amount .' '. $datum->ip_id .' '. $datum->fd_id.' '.$datum->deposit_date }}" name="debit"></td>
                                <td>{{$datum->deposit_date}}</td>
                                <td>{{$datum->bank . ' ' . $datum->cheque}}</td>
                                <td>{{$datum->amount}}</td>
                                <td></td>
                                <td>{{$datum->payment}}</td>
                                <td>{{$datum->receipt_number}}</td>
                                <td>{{$datum->display_name}}</td>
                                <td>{{$datum->status}}</td>
                                <td>
                                    {{$datum->cleared_date}}
                                </td>
                                <td> {{$datum->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
    
                   <div id="result_area" hidden>
                        <small><b>Selected Total</b></small>
                        <small id="selected_value" class="font-weight-bold"></small>
                    </div>
                </div>
            </div>
        </div>
    </div> 


    {{ $data->links() }} 


    <!-- Modal -->
    <div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="processModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="processModalLabel">Reconciliation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-md-6">
                           <label> Cleared Date
                               <input type="date" id="cleared_date">
                           </label>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="process" data-url="{{route('reconciliation-store')}}">Process</button>
                </div>
            </div>
        </div>
    </div>


    <!--Void Modal -->
    <div class="modal fade" id="voidModal" tabindex="-1" role="dialog" aria-labelledby="voidModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="voidModalLabel">Reconciliation(void)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-md-6">
                           <label> Voided Date
                               <input type="date" id="voided_date">
                           </label>
                           <label> Voided Reason
                               <textarea id="void_reason" cols="50" rows="6"></textarea>
                           </label>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="void" data-url="{{route('void-store')}}">Process</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('after_scripts')
<script>
    $(document).ready(function (){
        //Need to open Modal
        $("body").children().first().before($(".modal"));

        var value = 0;
        var deposit_id = [];
        var payment_id = [];
        var deposit_date = [];
        $('input[type="checkbox"]').click(function () {

            if ($(this).prop("checked") == true) {
                const str = this.value;
                const idx = 6;
                payment_id.push(str.slice(idx).trim().split(' ')[0]);
                deposit_id.push(str.slice(idx).trim().split(' ')[1]);
                // deposit_date.push(str.slice(idx).trim().split(' ')[2]);

                value += parseInt(this.value);
              $('#result_area').removeAttr('hidden');
              $('#selected_value').empty().text(value);
                // console.log(deposit_id);
            }

            if ($(this).prop("checked") == false) {
                const str = this.value;
                const idx = 6;
                const payment_index = payment_id.indexOf(str.slice(idx).trim().split(' ')[0]);
                const deposit_index = deposit_id.indexOf(str.slice(idx).trim().split(' ')[1]);
                // const deposit_date_index = deposit_date.indexOf(str.slice(idx).trim().split(' ')[2]);
                // console.log(deposit_id);
                if (payment_index > -1) {
                    payment_id.splice(payment_index, 1)
                }

                if (deposit_index > -1) {
                    deposit_id.splice(deposit_index, 1)
                }

                value -= parseInt(this.value);
                $('#selected_value').empty().text(value);
            }
        });

        $('#process').click(function (e){
            var target = e.target;
            console.log(payment_id);
            $.ajax({
                method:'GET',
                url: target.dataset.url,
                data: {"date": $('#cleared_date').val(), "payment_id" : payment_id, "deposit_id" : deposit_id},
            }).done(function (data){

                swal({
                    title: data,
                    icon: "warning",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.replace('{{route('reconciliation-transaction')}}');
                        } else {
                            window.location.replace('{{route('reconciliation-transaction')}}');
                        }
                    });
            })
        })

        $('#void').click(function (e){
            var target = e.target;

            $.ajax({
                method:'GET',
                url: target.dataset.url,
                data: {"date": $('#voided_date').val(), "payment_id" : payment_id, "deposit_id" : deposit_id, "reason" :  $('#void_reason').val()},
            }).done(function (data){

                swal({
                    title: data,
                    icon: "warning",
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.replace('{{route('reconciliation-transaction')}}');
                        } else {
                            window.location.replace('{{route('reconciliation-transaction')}}');
                        }
                    });
            })
        })
    })
</script>
@endpush
