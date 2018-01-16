@extends('home')

@section('body')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">Feeds Master List</div>
                        <div class="col text-right"><a href="{{ route('feeds.create') }}">Create new feed</a></div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Unit</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->units }}</td>
                                    <td>
                                    <a href="{{ route('feeds.edit', ['id' => $item->id]) }}" class="btn btn-info">Manage</a>
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
