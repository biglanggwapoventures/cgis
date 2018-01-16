@extends('home')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Grows Master List</div>
                        <div class="col text-right"><a href="{{ route('grows.create') }}">New grow</a></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Grow Code</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->grow_code }}</td>
                                    <td>{{ date_create($item->start_date)->format('m/d/Y') }}</td>
                                    <td>{{ $item->end_date ? date_create($item->end_date)->format('m/d/Y') : '' }}</td>
                                    <td>
                                        <a href="{{ route('grows.edit', ['id' => $item->id]) }}" class="btn btn-info">Manage</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
