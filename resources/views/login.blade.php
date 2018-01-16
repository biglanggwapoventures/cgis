<!doctype html>
<html lang="{{ app()->getLocale() }}"  style="height:100%">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>{{ config('app.name') }}</title>
    </head>
    <body style="height:100%">
        <div class="container" style="height:100%">
            <div class="d-flex row justify-content-center align-items-center" style="height:100%">
                <div class="p-2 col-sm-12 col-md-5 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            Chick Growers Integrated System
                        </div>
                        <div class="card-body">
                            @if($errors->count())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled mb-0">
                                        <li>{!! implode('</li><li>', $errors->all()) !!}</li>
                                    </ul>
                                </div>
                            @endif
                            {!! Form::open(['url' => route('do.login'), 'method' => 'POST']) !!}
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        {!! Form::text('username', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit"  class="btn btn-primary">Login</a>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
