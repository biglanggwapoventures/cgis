@extends('layouts.app')

@section('content')
<nav class="navbar navbar-dark navbar-expand-lg bg-success mb-2">
    <a class="navbar-brand" href="#">Chick Growers</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('grows.index') }}">Grows</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Maintain</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('feeds.index') }}">Feeds</a>
                    <a class="dropdown-item" href="{{ route('farms.index') }}">Farms</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"  id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create new log</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach($grows as $grow)
                        <a class="dropdown-item" href="{{ route('grows.daily-logs.create', ['grow' => $grow->id]) }}">
                            {{ $grow->grow_code }}
                        </a>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</nav>
<div>
    @yield('body')
</div>

@endsection
