@extends('grows.layout', ['data' => $grow])

@section('manage-section')

{!! Form::open(['url' => route('grows.chick-in.update', ['grow' => $grow->id]), 'method' => 'POST']) !!}
    @php $index = 0 @endphp
    @foreach($buildings AS $building)
        <div class="card mb-2">
            <div class="card-header text-center">{{ $building->name }} ({{ $building->farm->name }})</div>
            <div class="card-body p-0">
                @foreach($building->decks AS $deck)
                    <table class="table mb-0 table-sm table-hover" style="table-layout: fixed;">
                        <thead>
                            <tr class="table-active"><th colspan="6" class="text-center">{{ $deck->name }}</th></tr>
                            <tr><th>Column</th><th>DR #</th><th>Date</th><th>Heads</th><th>DOA</th><th>Net</th></tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td class="heads-total text-right bg-warning text-white"></td>
                                <td class="dead-total text-right bg-warning text-white"></td>
                                <td class="net-total text-right bg-warning text-white"></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($deck->columns AS $column)
                                <tr>
                                    <td>
                                        {{ $column->name }}
                                        {!! Form::hidden("in[{$index}][column_id]", $column->id) !!}
                                        @if($recorded->get($column->id))
                                            {!! Form::hidden("in[{$index}][id]", $recorded->get($column->id)->id) !!}
                                        @endif
                                    </td>
                                    <td>
                                        {!! Form::bsText("in[{$index}][reference_number]", null, $recorded->get($column->id)->reference_number ?? null, ['class' => 'form-control form-control-sm']) !!}
                                    </td>
                                    <td>
                                        {!! Form::bsDate("in[{$index}][chick_in_date]", null, $recorded->get($column->id)->chick_in_date  ?? null, ['class' => 'form-control form-control-sm']) !!}
                                    </td>
                                    <td>
                                        {!! Form::bsText("in[{$index}][num_heads]", null, $recorded->get($column->id)->num_heads  ?? null, ['class' => 'form-control form-control-sm text-right numeric num-heads']) !!}
                                    </td>
                                    <td
                                        >{!! Form::bsText("in[{$index}][num_dead]", null, $recorded->get($column->id)->num_dead  ?? null, ['class' => 'form-control form-control-sm text-right numeric num-dead']) !!}
                                    </td>
                                    <td class="text-right net"></td>
                                </tr>
                                @php $index++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="row">

    </div>
    <div class="row">
        <div class="col"><button type="submit" class="btn btn-success">Save</button></div>
    </div>
{!! Form::close() !!}

@endsection


@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.num-heads, .num-dead').blur(function () {
                getRowNet($(this).closest('tr'));
                calculateTotals($(this).closest('table'));
            }).trigger('blur');

            function getRowNet(row) {
                row.find('.net').text(function () {
                    var numHeads = numeral().unformat(row.find('.num-heads').val()),
                        numDoa = numeral().unformat(row.find('.num-dead').val()),
                        net = numHeads - numDoa;

                    return numeral(net).format('0,0');
                })
            }

            function calculateTotals(table) {
                var headsTotal = 0,
                    deadTotal = 0;

                table.find('tbody tr').each(function () {
                    var $this = $(this);
                    headsTotal += numeral().unformat($this.find('.num-heads').val());
                    deadTotal += numeral().unformat($this.find('.num-dead').val());
                });

                table.find('.dead-total').text(numeral(deadTotal).format('0,0'));
                table.find('.heads-total').text(numeral(headsTotal).format('0,0'));
                table.find('.net-total').text(numeral(headsTotal - deadTotal).format('0,0'));
            }
        });
    </script>
@endpush
