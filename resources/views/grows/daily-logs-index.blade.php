@extends('grows.layout', ['data' => $grow])

@section('manage-section')

<a href="{{ route('grows.daily-logs.create', ['grow' => $grow->id]) }}" class="btn btn-info mb-1">Create new log</a>
<table class="table">
    <thead class="thead-inverse">
        <tr>
            <th>Day #</th>
            <th>Date Created</th>
            <th>Remarks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($grow->dailyLogs as $row)
            <tr>
                <td>Day # {{ $row->day_count }}</td>
                <td>{{ date_create($row->created_at)->format('m/d/Y') }}</td>
                <td>{{ $row->remarks }}</td>
                <td>
                    <a href="{{ route('grows.daily-logs.edit', ['dailyLog' => $row->id, 'grow' => $row->grow_id]) }}" class="btn btn-info">
                        Details
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
