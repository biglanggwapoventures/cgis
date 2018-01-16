@extends('layouts.app')

@section('content')

    <div class="d-flex row justify-content-center align-items-center" style="height:100%">
        <div class="p-2 col-sm-12 col-md-4 col-xs-12">
            <div class="card">
                <div class="card-header">
                    CGIS
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => route('login'), 'method' => 'POST' ]) !!}

                        {!! Form::bsText('email', 'Email') !!}
                        {!! Form::bsPassword('password', 'Password') !!}
                        <div class="text-right">
                            <button type="submit"  class="btn btn-primary">Login</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
