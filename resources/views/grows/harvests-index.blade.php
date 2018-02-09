@extends('grows.layout', ['data' => $grow])

@section('manage-section')

<a href="{{ route('grows.harvests.create', ['grow' => $grow->id]) }}" class="btn btn-info mb-1">New harvest log</a>
<table class="table">
    <thead class="thead-inverse">
        <tr>
            <th>Ref #</th>
            <th>Harvest Date</th>
            <th>Remarks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($grow->harvests as $row)
            <tr>
                <td># {{ $row->id }}</td>
                <td>{{ date_create($row->harvest_date)->format('m/d/Y') }}</td>
                <td>{{ $row->remarks }}</td>
                <td>
                    <a href="{{ route('grows.harvests.edit', ['harvest' => $row->id, 'grow' => $row->grow_id]) }}" class="btn btn-info">
                        Details
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
