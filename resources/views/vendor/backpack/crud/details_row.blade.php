<div class="m-t-10 m-b-10 p-l-10 p-r-10 p-t-10 p-b-10">
	<div class="row">
		<div class="col-md-12">
			<strong>Address:</strong> {{ $entry->getDisplayAddress() }} <br>
			<strong>Guardian 1:</strong> {{ $entry->guardian1_display }} <strong>Phone:</strong> {{ $entry->guardian1_phone }} <br>
			<strong>Guardian 2:</strong> {{ $entry->guardian2_display }} <strong>Phone:</strong> {{ $entry->guardian2_phone }} <br>
			<strong>Enrolled Class(es):</strong>
			<table class="table table-borderless col-6">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Class</th>
						<th scope="col">Enrollment</th>
						<th scope="col">Withdraw</th>
					</tr>
				</thead>
				<tbody>
					@foreach($entry->scheduleClassersForDetailsRow as $key => $classer)
					<tr>
						<th scope="row">{{ $key+1 }}</th>
						<td>{{ $classer->classer->short_name }}</td>
						<td>{{ $classer->enrollment_date ? $classer->enrollment_date->toDateString() : "" }}</td>
						<td>{{ $classer->withdrawl_date ? $classer->withdrawl_date->toDateString() : "" }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<br>
			<strong>Gender:</strong> {{ $entry->gender }} <br>
			<strong>School:</strong> {{ $entry->school ? $entry->school->short_name : '' }} <br>
		</div>
	</div>
</div>
<div class="clearfix"></div>