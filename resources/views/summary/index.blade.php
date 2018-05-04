@extends('home')

@section('body')
<div class="row ">
	<div class="col-sm-12">
		<h4>Grow Code: <span class="text-info">{{ $grow->grow_code }}</span></h4>
		<h4>Duration:
			<span class="text-info">{{ date_create($grow->start_date)->format('M d, Y') }} &mdash; </span>
			<span class="text-info">{{ $grow->end_date ? date_create($grow->end_date)->format('M d, Y') : 'Present' }}</span>
		</h4>
		<table class="table table-bordered table-hover table-sm">
			<thead>
				<tr>
					<th rowspan="2">Age</th>
					<th rowspan="2">Date</th>
					<th rowspan="2" class="text-white bg-danger">Mortality</th>
					@if($grow->dailyLogs->count())
						<th class="bg-info text-white" colspan="{{ $grow->dailyLogs[0]->mortalities->count() }}">Remaining Chicks</th>
						<th colspan="{{ $grow->dailyLogs[0]->feedsDeliveries->count() }}" class="text-white bg-primary">Feeds Delivered</th>
						<th colspan="{{ $grow->dailyLogs[0]->feedsDeliveries->count() }}" class="text-white bg-secondary">Feeds Consumption</th>
						<th  class="text-white bg-success" colspan="{{ $grow->dailyLogs[0]->feedsDeliveries->count() }}">Remaining Feeds</th>
						<th colspan="{{ $grow->dailyLogs[0]->weightRecords->count() }}"  class="text-white bg-warning">Weight Records</th>
					@endif
				</tr>
				@if($grow->dailyLogs->count())
				<tr>
					@foreach($grow->dailyLogs[0]->mortalities as $mortality)
						<th class="bg-info text-white">{{ $mortality->deck->name }}</th>
					@endforeach
					@foreach($grow->dailyLogs[0]->feedsDeliveries->sortBy('feed_id') as $delivery)
						<th class="text-white bg-primary">{{ $delivery->feed->description }}</th>
					@endforeach
					@foreach($grow->dailyLogs[0]->feedsDeliveries->sortBy('feed_id') as $delivery)
						<th class="text-white bg-secondary">{{ $delivery->feed->description }}</th>
					@endforeach
					@foreach($grow->dailyLogs[0]->feedsDeliveries->sortBy('feed_id') as $delivery)
						<th class="text-white bg-success">{{ $delivery->feed->description }}</th>
					@endforeach
					@foreach($grow->dailyLogs[0]->weightRecords as $record)
						<th class="text-white bg-warning">{{ $record->deck->name }}</th>
					@endforeach
				</tr>
				@endif
			</thead>
			<tbody>
				@forelse($grow->dailyLogs AS $log)
					<tr>
						<td> <a target="_blank" href="{{ route('grows.daily-logs.edit', ['dailyLog' => $log->id, 'grow' => $log->grow_id]) }}">{{ $log->day_count }}</a></td>
						<td>{{ date_create($log->date)->format('m/d/Y') }}</td>
						<td class="text-right bg-danger text-white">
							@php
								$mortalityCount = $log->getTotalMortality()
							@endphp
							{{ $mortalityCount ?: ''  }}
						</td>
						@foreach($log->mortalities as $mortality)
							<td class="text-right bg-info text-white">
								@php
									$remaining = $log->getRemainingChickCountFromDeck($mortality->deck_id, $chicksPerDeckInitial[$mortality->deck_id]);
									$chicksPerDeckInitial[$mortality->deck_id] -= ($mortality->num_am + $mortality->num_pm)
								 @endphp
								{{ $remaining ?: '' }}
							</td>
						@endforeach
						@foreach($log->feedsDeliveries->sortBy('feed_id') as $delivery)
							<td class="text-right text-white bg-primary">{{ floatval($delivery->num_feed) ? $delivery->num_feed : '' }}</td>
						@endforeach
						@foreach($log->feedsDeliveries->sortBy('feed_id') as $delivery)
							<td class="text-right text-white bg-secondary">
								@php
									$consumed = $log->getTotalFeedConsumption($delivery->feed_id);
									if(!isset($feedStock[$delivery->feed_id])){
										$feedStock[$delivery->feed_id] = 0;
									}
									$feedStock[$delivery->feed_id] -= $consumed;
								@endphp
								{{ $consumed ?: '' }}
							</td>
						@endforeach
						@foreach($log->feedsDeliveries->sortBy('feed_id') as $delivery)
							<td class="text-right bg-success text-white">
								@php
									$feedStock[$delivery->feed_id] += $delivery->num_feed;
								@endphp
								{{ $feedStock[$delivery->feed_id] ?: '' }}
							</td>
						@endforeach
						@foreach($log->weightRecords as $record)
							<td class="text-right text-white bg-warning">{{ floatval($record->recorded_weight) ? $record->recorded_weight : '' }}</td>
						@endforeach
					</tr>
				@empty
				@endforelse
			</tbody>
		</table>
	</div>
</div>
@endsection
