@extends('home')

@section('body')
<nav class="breadcrumb">
    <a class="breadcrumb-item" href="{{ route('buildings.index', ['farm' => $deck->building->farm->id]) }}">{{ $deck->building->farm->name }}</a>
    <a class="breadcrumb-item" href="{{ route('decks.index', ['building' => $deck->building->id]) }}">{{ $deck->building->name }}</a>
    <a class="breadcrumb-item active" href="#">{{ $deck->name }} columns</a>
</nav>
<div class="row">
    <div class="col">
         <div class="card">
             <div class="card-header">Create new column</div>
             <div class="card-body">
                 {!! Form::open(['url' => route('columns.store', ['deck' => $deck->id]), 'method' => 'POST']) !!}
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
            <div class="card-body p-0">
                <table class="table mb-0 table-sm">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Name</td>
                            <th>Description</td>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deck->columns as $item)
                            <tr data-role="form">
                                <td>{!! Form::text('', $item->name, ['class' => 'form-control form-control-sm field', 'data-name' => 'name']) !!}</td>
                                <td>{!! Form::text('', $item->description, ['class' => 'form-control form-control-sm field', 'data-name' => 'description']) !!}</td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm"
                                        data-method="patch"
                                        data-url="{{ route('columns.update', ['deck' => $deck->id, 'id' => $item->id]) }}">
                                            <i class="fa fa-check"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-method="delete"
                                        data-url="{{ route('columns.destroy', ['deck' => $deck->id, 'id' => $item->id]) }}">
                                            <i class="fa fa-trash"></i>
                                    </button>
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

@push('js')

@endpush
