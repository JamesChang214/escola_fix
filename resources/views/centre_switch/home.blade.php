@extends('layout.master', [
	'breadcrumb' => [
		'Reconciliations' => false,
	]
])

@section('page-title', 'Switch/Change Centre')

@section('content')
    <div class="row">
        <div class="col-md-6">
        <div class="card p-4 m-2">
            <h5 class="text-danger">Caution</h5>
            <ul>
                <li>If you switch centre all related data will be changed</li>
                <li>Be careful</li>
            </ul>

            <select id="centre" data-url="{{route('centre-switch-switch')}}">
                <option>Select a centre</option>
                @foreach($centres as $centre)
                    <option value="{{$centre->id}}" @if(Session::get('centre_id') == $centre->id) selected @endif>{{$centre->name}}</option>
                @endforeach
            </select>
    </div>
</div>
    </div>
@endsection
@push('after_scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $("#centre").change(function (e){
            var centerId = $(this).val()
            var target = e.target;

            $.ajax({
                method: 'GET',
                url: target.dataset.url,
                data: {'centreId': centerId},
                success: function (result) {
                    swal({
                        title: "You have successfully switch the center",
                        icon: "success",
                    });
                }
            })
        })

    </script>
@endpush
