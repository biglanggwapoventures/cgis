@extends('home')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    {{ $data->id ? 'Update feed details' : 'New feed' }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="nav flex-column nav-pills" aria-orientation="vertical">
                            @if($data->id)

                                <a class="nav-link {{ Route::is('feeds.edit') ? 'active' : '' }}" href="{{ route('feeds.edit', ['id' => $data->id]) }}">Feed Details</a>
                                <a class="nav-link">Feed Usage Report</a>

                            @else

                                <a class="nav-link active">Feed Details</a>

                            @endif
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
