@extends('home')

@section('body')
<style type="text/css">
	#main.table th{
		text-align: center!important;
	}
	dl dd:not(:last-child){
		margin-bottom: 0;
	}
</style>
<div class="row ">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-6">
						<dl class="row mb-0">
						  <dt class="col-sm-6">Grow Code</dt>
						  <dd class="col-sm-6">{{ $grow->grow_code }}</dd>
						  <dt class="col-sm-6">Start Date</dt>
						  <dd class="col-sm-6">
						  	{{ date_create($grow->start_date)->format('M d, Y') }}
						  </dd>
						  <dt class="col-sm-6">End Date</dt>
						  <dd class="col-sm-6">
							{{ $grow->end_date ? date_create($grow->end_date)->format('M d, Y') : 'Present' }}
						  </dd>
						</dl>
					</div>
					<div class="col-sm-6">
						<dl class="row mb-0">
						  <dt class="col-sm-6">Total Chick In</dt>
						  <dd class="col-sm-6">{{ number_format($totalChicks = $grow->getTotalChickIns()) }}</dd>
						  <dt class="col-sm-6">Total Mortality</dt>
						  <dd class="col-sm-6 text-danger">{{ number_format($totalMortality = $grow->getTotalMortality()) }}</dd>
						  <dt class="col-sm-6">Total Live</dt>
						  <dd class="col-sm-6 text-info">
						  	{{ number_format($total = ($totalChicks - $totalMortality)) }}
						  	<strong>({{ $total ? number_format(($total/$totalChicks) * 100, 2) : 0 }}%)</strong>
						  </dd>
						</dl>
					</div>
				</div>
			</div>
			<div class="col-sm-5">
				<table class="table table-sm table-bordered">
					<thead  class="thead-dark">
						<tr>
							<th rowspan="2">Feed</th>
							<th colspan="2" class="text-center">Total</th>
							<th rowspan="2">Remaining</th>
						</tr>
						<tr>
							<th class="text-center">Delivered</th>
							<th class="text-center">Consumed</th>
						</tr>
					</thead>
					@if($grow->dailyLogs->count())
						@foreach($grow->dailyLogs[0]->feedsDeliveries->sortBy('feed_id') as $delivery)
							<tr>
								<th>{{ $delivery->feed->description }}</th>
								<th class="text-right text-secondary">{{ $delivered = $grow->getTotalFeedsDelivered($delivery->feed_id) }}</th>
								<th class="text-right text-primary">{{ $consumption = $grow->getTotalFeedConsumption($delivery->feed_id) }}</th>
								<th class="text-right text-success">{{ $delivered-$consumption }}</th>
							</tr>
						@endforeach
					@endif
				</table>
			</div>
		</div>
		<table class="table table-bordered table-hover table-sm" id="main">
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
