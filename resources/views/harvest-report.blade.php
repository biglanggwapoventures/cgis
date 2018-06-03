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
<div class="row">
    <div class="col-sm-4">
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
    <div class="col-sm-5">
        <table class="table table-sm table-bordered">
            <thead  class="thead-dark">
                <tr>
                    <th></th>
                    <th class="text-center">Actual AVG</th>
                    <th class="text-center">Farm AVG</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>ALW</strong></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>Farm</strong></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center">Date</th>
                    <th rowspan="2" class="text-center">WS #</th>
                    <th rowspan="2" class="text-center">Plate #</th>
                    <th colspan="2" class="text-center">Farm</th>
                    <th colspan="2" class="text-center">Actual</th>
                    <th rowspan="2" class="text-center">Mortality</th>
                </tr>
                <tr>
                    <th class="text-center">Head Count</th>
                    <th class="text-center">ALW</th>
                    <th class="text-center">Head Count</th>
                    <th class="text-center">ALW</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grow->harvests as $harvest)
                    @foreach($harvest->line as $row)
                        <tr>
                            <td>{{ date_create($harvest->date)->format('M d, Y') }}</td>
                            <td>{{ $row->withdrawal_slip }}</td>
                            <td>{{ $row->vehicle_plate_number }}</td>
                            <td class="text-right">{{ number_format($row->farm_num_heads) }}</td>
                            <td class="text-right">{{ number_format($row->farm_average_live_weight, 3) }}</td>
                            <td class="text-right">{{ number_format($row->actual_num_heads) }}</td>
                            <td class="text-right">{{ number_format($row->actual_average_live_weight, 3) }}</td>
                            <td class="text-right">{{ number_format($row->doa_count) }}</td>
                        </tr>
                    @endforeach
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
