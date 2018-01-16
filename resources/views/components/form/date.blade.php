<div class="form-group">
    @if($label)
        {{ Form::label($name, $label, ['class' => 'control-label']) }}
    @endif
    {{ Form::date($name, $value, array_merge(['class' => 'form-control'. ($errors->has($name) ? ' is-invalid' : '')], $attributes)) }}
    @if($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
