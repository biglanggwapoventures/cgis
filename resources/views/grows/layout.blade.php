@extends('home')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ $data->id ? 'Update grow details' : 'New grow' }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" iaria-orientation="vertical">
                                <a class="nav-link {{ Route::is('grows.edit') ? 'active' : '' }}" href="{{ route('grows.edit', ['id' => $data->id]) }}">Grow Info</a>
                                <a class="nav-link {{ Route::is('grows.report') ? 'active' : '' }}" href="{{ route('grows.report', ['id' => $data->id]) }}">Summary</a>
                                <a class="nav-link {{ Route::is('grows.chick-in.index') ? 'active' : '' }}" href="{{ route('grows.chick-in.index', ['grow' => $data->id]) }}">Bird Chick In</a>
                                <a class="nav-link {{ Route::is('grows.daily-logs.index') || Route::is('grows.daily-logs.create') ? 'active' : '' }}" href="{{ route('grows.daily-logs.index', ['grow' => $data->id]) }}">Daily Logs</a>
                                <a class="nav-link {{ Route::is('grows.harvests.index') ? 'active' : '' }}" href="{{ route('grows.harvests.index', ['grow' => $data->id]) }}">Harvest</a>
                            </div>
                        </div>
                        <div class="col">
                            @yield('manage-section')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
