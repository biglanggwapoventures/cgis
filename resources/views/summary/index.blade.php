@extends('home')

@section('body')
@foreach($report['daily_logs'] as $day_count => $data)
	@if($loop->first)
		@php $countDeck = count($data['weight_records']); @endphp
	@endif
@endforeach
 <div class="row">
 	<div class="col-2 ">
 		<h5>GROW CODE:</h5>
 		<h5>TOTAL CHICKS:</h5>
 		<h5>TOTAL DOA:</h5>
 		<h5>NET CHICKS:</h5>
 	</div>
 	<div class="col-2 text-right">
 		<h5>{{ $report['grow_code'] }}</h5>
 		<h5>{{ number_format($report['total_chicks']) }}</h5>
 		<h5>{{ number_format($report['total_DOA']) }}</h5>
 		<h5>{{ number_format($report['net_chicks']) }}</h5>
 	</div>
 	<div class="col-8">
 		<a href="{{ route('grows.index') }}" class="float-right btn btn-danger text-white">Back to index</a>
 	</div>
 </div>
<table class="table table-striped table-sm table-bordered">
	<thead>
		<tr class="text-center">
			<th>Log #</th>
			<th>Log Date</th>
			<th colspan="2">Mortality</th>
			<th colspan="2">Feed Consumption</th>
			<th colspan="{{ $countDeck }}">Weight Record</th>
			<th colspan="2">Feed Delivery</th>
			<th colspan="2">Remaining Feeds</th>
			<th colspan="2">Remaining Chicks</th>
		</tr>
		<tr>
			<th></th>
			<th></th>
			<th>AM</th>
			<th>PM</th>
			<th class="text-right">CB</th>
			<th class="text-right">BS</th>
			@foreach($report['daily_logs'] as $day_count => $data)
				@if ($loop->first)
					@foreach($data['weight_records'] as $wr)
						<th class="text-right">{{ $wr['deck']['name'] }}</th>
					@endforeach
				@endif
			@endforeach
			<th class="text-right">CB</th>
			<th class="text-right">BS</th>
			<th class="text-right">CB</th>
			<th class="text-right">BS</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		{{-- @print_r($report['daily_logs']) --}}
		@foreach($report['daily_logs'] as $log => $data)
			<tr>
				<td class="text-center">{{ $log }}</td>
				<td class="text-center">
					{{ Carbon\Carbon::parse($data['date'])->format('m/d/Y') }}
				</td>
				@foreach($data['mortalities'] as $mort)
					<td>{{ number_format($mort['num_am']) }}</td>
					<td>{{ number_format($mort['num_pm']) }}</td>
				@endforeach
				@foreach($data['feeds_consumption'] as $fc)
					<td class="text-right">{{ $fc['num_feed'] }}</td>
				@endforeach
				@foreach($data['weight_records'] as $wr)
					<td class="text-right">{{ $wr['recorded_weight'] }}</td>
				@endforeach
				@foreach($data['feeds_deliveries'] as $fd)
					<td class="text-right">{{ $fd['num_feed'] }}</td>
				@endforeach

				{{-- Reserve for remaining feeds collumn --}}
				<td></td>
				<td></td>

				@foreach($data['mortalities'] as $mort)
					@php $remainingChicks = $report['net_chicks'] -= $mort['total_mortalities']; @endphp
					<td>{{ number_format($remainingChicks) }}</td>
				@endforeach
			</tr>
		@endforeach
	</tbody>
</table>
@endsection