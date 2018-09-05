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
                            <td>
                                <strong class="text-info">
                                    @php $actualNumHeads = $data->line->sum('actual_num_heads') @endphp
                                    {{ number_format($actualNumHeads) }}
                                </strong>
                            </td>
                            <td>DOA</td>
                            <td>
                                <strong class="text-info">
                                    @php $totalDOA = $data->line->sum('doa_count') @endphp
                                    {{ number_format($totalDOA) }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                             <td>WEIGHT</td>
                             <td>
                                <strong class="text-info">
                                    @php $actualWeight = $data->line->sum('actual_kilos') @endphp
                                    {{ number_format($actualWeight, 2) }}
                                </strong>
                            </td>
                            <td>ALW</td>
                            <td><strong class="text-info">{{  $actualNumHeads ? number_format($actualWeight/$actualNumHeads, 3) : 0 }}</strong></td>
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
                <th  class="text-center">DOA</th>
                <th rowspan="2"></th>
            </tr>
            <tr class="bg-info text-white">
                <th>WS #</th>
                <th class="text-center">Actual Head Count</th>
                <th class="text-center">Actual ALW</th>
                <th class="text-center">Actual Kilos</th>
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
                    {!! Form::bsText("line[{$loop->index}][actual_num_heads]", null, $row->actual_num_heads, ['class' => 'form-control text-right form-control-sm numeric calc-actual-kilos actual-num-heads', 'data-name' => 'line[idx][actual_num_heads]']) !!}
                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][farm_average_live_weight]", null, $row->farm_average_live_weight, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_average_live_weight]', 'data-format' => '0,0.000']) !!}
                    {!! Form::bsText("line[{$loop->index}][actual_average_live_weight]", null, $row->actual_average_live_weight, ['class' => 'form-control  calc-actual-kilos actual-alw  text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_average_live_weight]', 'data-format' => '0,0.000']) !!}
                </td>
                <td>
                    {!! Form::bsText("line[{$loop->index}][doa_count]", null, $row->doa_count, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][doa_count]']) !!}
                    {!! Form::bsText("line[{$loop->index}][actual_kilos]", null, number_format($row->actual_kilos, 2),  ['class' => 'form-control text-right actual-kilos form-control-sm numeric', 'data-format' => '0,0.00']) !!}
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
                    {!! Form::bsText('line[0][actual_num_heads]', null, null, ['class' => 'form-control calc-actual-kilos actual-num-heads text-right form-control-sm numeric', 'data-name' => 'line[idx][actual_num_heads]']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][farm_average_live_weight]', null, null, ['class' => 'form-control text-right form-control-sm numeric mb-1', 'data-name' => 'line[idx][farm_average_live_weight]', 'data-format' => '0,0.000']) !!}
                    {!! Form::bsText('line[0][actual_average_live_weight]', null, null, ['class' => 'form-control text-right form-control-sm numeric calc-actual-kilos actual-alw', 'data-name' => 'line[idx][actual_average_live_weight]', 'data-format' => '0,0.000']) !!}
                </td>
                <td>
                    {!! Form::bsText('line[0][doa_count]', null, null, ['class' => 'form-control text-right form-control-sm numeric', 'data-name' => 'line[idx][doa_count]']) !!}
                    {!! Form::bsText('line[0][actual_kilos]', null, null,  ['class' => 'actual-kilos form-control text-right form-control-sm numeric', 'data-format' => '0,0.00']) !!}
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


@push('js')
<script type="text/javascript">
    // $(document).ready(function() {
    //     $('.dynamic').on('keyup', '.calc-actual-kilos', function () {
    //          var tr = $(this).closest('tr'),
    //             actualHeads = parseFloat(tr.find('.actual-num-heads').val() || 0),
    //             actualALW = parseFloat(tr.find('.actual-alw').val() || 0);

    //         tr.find('.actual-kilos').val(numeral((actualHeads * actualALW)).format('0,0.00'));

    //     })
    // });
</script>
@endpush
