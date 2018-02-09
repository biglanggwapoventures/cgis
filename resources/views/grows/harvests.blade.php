@extends('grows.layout', ['data' => $grow])

@section('manage-section')
    @if($data->id)
        {!! Form::model($data, ['url' => route('grows.harvests.update', ['grow' => $grow->id, 'id' => $data->id]), 'class' => 'ajax', 'method' => 'patch']) !!}
    @else
        {!! Form::open(['url' => route('grows.harvests.store', ['grow' => $grow->id]), 'class' => 'ajax', 'method' => 'post']) !!}
    @endif
    <div class="row">
        <div class="col-sm-4">
            {!! Form::bsDate('harvest_date', 'Harvest Date') !!}
        </div>
        <div class="col-sm-8">
            {!! Form::bsText('remarks', 'Remarks') !!}
        </div>
    </div>
    @if($data->id)
        <div class="row">
            <div class="col-sm-6">
                <table class="table-sm table" style="table-layout: fixed">
                    <tbody>
                        <tr>
                            <td>HEADS</td>
                            <td><strong class="text-info">{{ number_format($data->line->sum('actual_num_heads')) }}</strong></td>
                            <td>DOA</td>
                             <td><strong class="text-info">{{ number_format($data->line->sum('doa_count')) }}</strong></td>
                        </tr>
                        <tr>
                             <td>WEIGHT</td>
                             <td><strong class="text-info">{{ number_format($data->line->sum(function ($line) { return ($line->actual_average_live_weight * $line->actual_num_heads); }), 2) }}</strong></td>
                            <td>ALW</td>
                             <td><strong class="text-info">{{ number_format($data->line->avg('actual_average_live_weight')) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <table class="table dynamic">
        <thead>
            <tr class="bg-info text-white">
                <th rowspan="2">Column</th>
                <th>Plate #</th>
                <th class="text-center">Farm Head Count</th>
                <th class="text-center">Farm ALW</th>
                <th rowspan="2" class="text-center">DOA</th>
                <th rowspan="2"></th>

            </tr>
            <tr class="bg-info text-white">
                <th>WS #</th>
                <th class="text-center">Actual Head Count</th>
                <th class="text-center">Actual ALW</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data->line AS $row)
            <tr>
                <td>
                    {!! Form::bsSelect("line[{$loop->index}][column_id]", null, $columns, $row->column_id, ['data-name' => 'line[idx][column_id]']) !!}
                    {!! Form::hidden("line[{$loop->index}][id]", $row->id) !!}

                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][vehicle_plate_number]", null, $row->vehicle_plate_number, ['class' => 'form-control form-control-sm mb-1', 'data-name' => 'line[idx][vehicle_plate_number]']) !!}
                    {!! Form::bsText("line[{$loop->index}][withdrawal_slip]", null, $row->withdrawal_slip, ['class' => 'form-control form-control-sm', 'data-name' => 'line[idx][withdrawal_slip]']) !!}
                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][farm_num_heads]", null, $row->farm_num_heads, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_num_heads]']) !!}
                    {!! Form::bsText("line[{$loop->index}][actual_num_heads]", null, $row->actual_num_heads, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_num_heads]']) !!}
                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][farm_average_live_weight]", null, $row->farm_average_live_weight, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_average_live_weight]']) !!}
                    {!! Form::bsText("line[{$loop->index}][actual_average_live_weight]", null, $row->actual_average_live_weight, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_average_live_weight]']) !!}
                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][doa_count]", null, $row->doa_count, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][doa_count]']) !!}
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-line">x</button>
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    {!! Form::bsSelect('line[0][column_id]', null, $columns, null, ['data-name' => 'line[idx][column_id]']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][vehicle_plate_number]', null, null, ['class' => 'form-control form-control-sm mb-1', 'data-name' => 'line[idx][vehicle_plate_number]']) !!}
                    {!! Form::bsText('line[0][withdrawal_slip]', null, null, ['class' => 'form-control form-control-sm', 'data-name' => 'line[idx][withdrawal_slip]']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][farm_num_heads]', null, null, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_num_heads]']) !!}
                    {!! Form::bsText('line[0][actual_num_heads]', null, null, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_num_heads]']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][farm_average_live_weight]', null, null, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_average_live_weight]', 'data-format' => '0,0.000']) !!}
                    {!! Form::bsText('line[0][actual_average_live_weight]', null, null, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_average_live_weight]', 'data-format' => '0,0.000']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][doa_count]', null, null, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][doa_count]']) !!}
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-line">x</button>
                </td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><button type="button" class="btn btn-primary add-line">Add new line</button></td>
            </tr>
        </tfoot>
    </table>
    <button type="submit" class="btn btn-success">Submit</button>
{!! Form::close() !!}
@endsection