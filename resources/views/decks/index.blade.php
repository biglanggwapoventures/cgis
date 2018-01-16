@extends('home')

@section('body')
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('buildings.index', ['farm' => $building->farm->id]) }}">{{ $building->farm->name }}</a>
    <a class="breadcrumb-item active" href="#">{{ $building->name }} decks</a>
</nav>
<div class="row">
    <div class="col">
        @include('notifications.message')
    </div>
</div>
<div class="row">
    <div class="col">
         <div class="card">
             <div class="card-header">Create new deck</div>
             <div class="card-body">
                 {!! Form::open(['url' => route('decks.store', ['building' => $building->id]), 'method' => 'POST']) !!}
                    {!! Form::bsText('name', 'Name') !!}
                    {!! Form::bsTextarea('description', 'Description') !!}
                    <div class="row">
                        <div class="col"><button type="submit" class="btn btn-success">Save</button></div>
                    </div>
                {!! Form::close() !!}
             </div>
         </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                {!! Form::open(['url' => route('decks.update', ['building' => $building->id, 'deck' => 'bulk']), 'method' => 'PATCH', 'class' => 'ajax']) !!}
                <table class="table mb-0" id="entries" data-delete-url="{{ route('decks.destroy', ['building' => $building->id, 'id' => 'idx']) }}">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Deck</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($building->decks as $item)
                            <tr data-role="form" class="d-none">
                                <td>
                                    {!! Form::text("item[{$loop->index}][name]", $item->name, ['class' => 'form-control field']) !!}
                                    {!! Form::hidden("item[{$loop->index}][id]", $item->id, ['class' => 'form-control field']) !!}
                                </td>
                                <td>{!! Form::text("item[{$loop->index}][description]", $item->description, ['class' => 'form-control field']) !!}</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-danger delete-button" data-id="{{ $item->id }}"><i class="fa fa-trash"></i></button>
                                    <a href="{{ route('columns.index', ['building' => $item->id]) }}" class="btn btn-primary"><i class="fa fa-columns"></i> Columns</a>
                                </td>
                            </tr>
                            <tr data-role="display">
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-right">
                                    <a href="{{ route('columns.index', ['building' => $item->id]) }}" class="btn btn-primary"><i class="fa fa-columns"></i> Columns</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <hr>
                <button type="button" class="btn btn-info edit-button"><i class="fa fa-pencil"></i> Edit</button>
                <button type="submit" class="btn btn-success save-button d-none"><i class="fa fa-check"></i> Save</button>
                <button type="button" class="btn btn-warning cancel-button d-none"><i class="fa fa-times"></i> Cancel</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
