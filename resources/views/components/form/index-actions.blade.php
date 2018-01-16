@if(Auth::user()->isAdmin() || Auth::user()->can(MyHelper::resource('update', null, false)))
<a href="{{ MyHelper::resource('edit', compact('id')) }}" class="text-primary">
    <span class="fa fa-pencil"></span> Edit
</a>
@endif

@if(Auth::user()->isAdmin() || Auth::user()->can(MyHelper::resource('delete', null, false)))
{!! Form::open(['url'=> MyHelper::resource('destroy', compact('id')), 'method'=> 'DELETE' ,'class'=> 'form']) !!}
    <a class="text-danger deletePostion">
        <span class="fa fa-trash"></span> Delete
    </a>
{!! Form::close()!!}
@endif
