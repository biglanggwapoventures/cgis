@extends('grows.layout', ['data' => $grow])

@section('manage-section')

@if(isset($data))
{!! Form::open(['url' => route('grows.daily-logs.update', ['grow' => $grow->id, 'dailyLog' => $data->id]), 'method' => 'PATCH']) !!}
@else
{!! Form::open(['url' => route('grows.daily-logs.store', ['grow' => $grow->id]), 'method' => 'POST']) !!}
@endif
    <h4>
        Day #
        @if(isset($data))
            {{ $data->day_count }}
        @else
            {{ $grow->dailyLogs()->count() + 1 }}
        @endif
    </h4>
    <div class="row">
        <div class="col-4">
            @if(isset($data))
                {{ Form::bsDate('date', 'Date', $data->date) }}
            @else
                {{ Form::bsDate('date', 'Date', now()->toDateString()) }}
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-8">
            <div class="card mb-2">
                <div class="card-header text-center p-1">Mortality</div>
                <div class="card-body p-0">
                    <table class="table table-sm" style="table-layout: fixed">
                        <thead >
                            <tr class="bg-info text-white">
                                <th>Deck</th>
                                <th>Pre Count</th>
                                <th>AM</th>
                                <th>PM</th>
                                <th>Post Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($decks AS $deck)
                             @php
                                $mortality = isset($data) && $data->mortalities->where('deck_id', $deck->id)->count()
                                ? $data->mortalities->where('deck_id', $deck->id)->first()
                                : new \App\Mortality
                            @endphp
                            <tr>
                                <td>
                                    {{ $deck->name }} ({{ $deck->building->name }})
                                    {!! Form::hidden("mortality[{$loop->index}][deck_id]", $deck->id) !!}
                                    @if($mortality->id)
                                        {!! Form::hidden("mortality[{$loop->index}][id]", $mortality->id) !!}
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ number_format($remainingHeadsPerDeck[$deck->id] + $mortality->num_am + $mortality->num_pm) }}
                                </td>
                                <td>{!! Form::bsText("mortality[{$loop->index}][num_am]", null, $mortality->num_am, ['class' => 'form-control form-control-sm numeric text-right']) !!}</td>
                                <td>{!! Form::bsText("mortality[{$loop->index}][num_pm]", null, $mortality->num_pm, ['class' => 'form-control form-control-sm numeric text-right']) !!}</td>
                                <td class="text-right">
                                    {{ number_format($remainingHeadsPerDeck[$deck->id]) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header text-center p-1">Feeds Consumption</div>
                <div class="card-body p-0">
                    <table class="table table-sm" style="table-layout: fixed">
                        <thead>
                            <tr  class="bg-info text-white">
                                <th></th>
                                @foreach($feeds AS $feed)
                                    <th>{{ "{$feed->description} ({$feed->units})" }}</th>
                                @endforeach
                                <th>Total</th>
                                <th>Ideal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $index = 1 @endphp
                            @foreach($decks AS $deck)
                            <tr>
                                <td>{{ $deck->name }} ({{ $deck->building->name }})</td>
                                @foreach($feeds AS $feed)
                                    @php
                                        $consumption = isset($data) && $data->feedsConsumption->where('deck_id', $deck->id)->where('feed_id', $feed->id)->count()
                                        ? $data->feedsConsumption->where('deck_id', $deck->id)->where('feed_id', $feed->id)->first()
                                        : new \App\FeedsConsumption
                                    @endphp
                                    <td>
                                        @if($consumption->id)
                                            {!! Form::hidden("consumption[{$index}][id]", $consumption->id) !!}
                                        @endif
                                        {!! Form::hidden("consumption[{$index}][deck_id]", $deck->id) !!}
                                        {!! Form::hidden("consumption[{$index}][feed_id]", $feed->id) !!}
                                        {!! Form::bsText("consumption[{$index}][num_feed]", null, $consumption->num_feed, ['class' => 'form-control form-control-sm numeric text-right']) !!}
                                    </td>
                                    @php $index++ @endphp
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-2">
                <div class="card-header text-center p-1">Weight Record</div>
                <div class="card-body p-0">
                    <table class="table table-sm" style="table-layout: fixed">
                        <thead>
                            <tr class="bg-info text-white">
                                <th>Deck</th>
                                <th>Ideal Weight</th>
                                <th>Actual Weight</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($decks AS $deck)
                            @php
                                $weight = isset($data) && $data->weightRecords->where('deck_id', $deck->id)->count()
                                ? $data->weightRecords->where('deck_id', $deck->id)->first()
                                : new \App\WeightRecord
                            @endphp
                            <tr>
                                <td>
                                    @if($weight->id)
                                        {!! Form::hidden("weight[{$loop->index}][id]", $weight->id) !!}
                                    @endif
                                    {{ $deck->name }} ({{ $deck->building->name }})
                                    {!! Form::hidden("weight[{$loop->index}][deck_id]", $deck->id) !!}
                                </td>
                                <td>
                                    {{ $program['weight'] }}
                                    {!! Form::hidden("weight[{$loop->index}][optimal_weight]", $program['weight']) !!}
                                </td>
                                <td>{!! Form::bsText("weight[{$loop->index}][recorded_weight]", null, $weight->recorded_weight, ['class' => 'actual-weight form-control form-control-sm numeric text-right', 'data-optimal-weight' => $program['weight']]) !!}</td>
                                <td class="result"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header text-center p-1">Feeds Delivery</div>
                <div class="card-body p-0">
                    <table class="table table-sm" style="table-layout: fixed">
                        <thead>
                            <tr class="bg-info text-white">
                                <th>Feed</th>
                                <th>Amount</th>
                                <th>Remaning</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feeds AS $feed)
                            @php
                                $delivery = isset($data) && $data->feedsDeliveries->where('feed_id', $feed->id)->count()
                                ? $data->feedsDeliveries->where('feed_id', $feed->id)->first()
                                : new \App\FeedsDelivery
                            @endphp
                            <tr>
                                <td>
                                    @if($delivery->id)
                                        {!! Form::hidden("delivery[{$loop->index}][id]", $delivery->id) !!}
                                    @endif
                                    {{ $feed->description }} ({{ $feed->units }})
                                    {!! Form::hidden("delivery[{$loop->index}][feed_id]", $feed->id) !!}
                                </td>
                                <td>{!! Form::bsText("delivery[{$loop->index}][num_feed]", null, $delivery->num_feed, ['class' => 'form-control form-control-sm numeric text-right']) !!}</td>
                                <td>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col clearfix">
            {!! Form::bsTextarea('remarks', 'Remarks') !!}
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('grows.daily-logs.index', ['grow' => $grow->id]) }}" class="btn btn-default float-right">Go back</a>
        </div>
    </div>
{!! Form::close() !!}

@endsection


<script>
    $(document).ready(function() {

    });
</script>
