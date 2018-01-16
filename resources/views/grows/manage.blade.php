@extends('grows.layout', ['data' => $data])

@section('manage-section')

{!!
    $data->id
    ? Form::model($data, ['url' => route('grows.update', ['id' => $data->id]), 'method' => 'PATCH'])
    : Form::open(['url' => route('grows.store'), 'method' => 'POST'])
!!}
    <div class="row">
        <div class="col">
            {!! Form::bsText('grow_code', 'Grow Code') !!}
        </div>
        <div class="col">
            {!! Form::bsDate('start_date', 'Date started') !!}
        </div>
        <div class="col">
            {!! Form::bsDate('end_date', 'Date ended') !!}
        </div>
    </div>
    {!! Form::bsTextarea('remarks', 'Remarks') !!}
    <div class="row">
        <div class="col"><button type="submit" class="btn btn-success">Save</button></div>
        <div class="col text-right"><a href="{{ route('grows.index') }}" class="btn btn-default">Go back</a></div>
    </div>
{!! Form::close() !!}

@endsection
