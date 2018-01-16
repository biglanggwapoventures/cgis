@extends('home')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ $data->id ? 'Update farm' : 'Create new farm' }}
                </div>
                <div class="card-body">
                    {!!
                        $data->id
                        ? Form::model($data, ['url' => route('farms.update', ['id' => $data->id]), 'method' => 'PATCH'])
                        : Form::open(['url' => route('farms.store'), 'method' => 'POST'])
                    !!}
                        {!! Form::bsText('name', 'Name') !!}
                        {!! Form::bsTextarea('description', 'Description') !!}
                        <div class="row">
                            <div class="col"><button type="submit" class="btn btn-success">Save</button></div>
                            <div class="col text-right"><a href="{{ route('farms.index') }}" class="btn btn-default">Go back</a></div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
