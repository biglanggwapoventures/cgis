@extends('feeds.layout', ['data' => $data])

@section('manage-section')

{!!
    $data->id
    ? Form::model($data, ['url' => route('feeds.update', ['id' => $data->id]), 'method' => 'PATCH'])
    : Form::open(['url' => route('feeds.store'), 'method' => 'POST'])
!!}
    {!! Form::bsText('description', 'Feed Description') !!}
    <div class="row">
        <div class="col-6">
            {!! Form::bsText('units', 'Unit of measure') !!}
        </div>
    </div>
    <div class="row">
        <div class="col"><button type="submit" class="btn btn-success">Save</button></div>
        <div class="col text-right"><a href="{{ route('feeds.index') }}" class="btn btn-default">Go back</a></div>
    </div>
{!! Form::close() !!}

@endsection
