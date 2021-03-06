<div class="form-group">
    @php $errName = MyHelper::replaceBrackets($name) @endphp
    @if($label)
        {{ Form::label($name, $label, ['class' => 'control-label']) }}
    @endif
     @php $attrs = array_merge(['class' => 'form-control'], $attributes) @endphp
     @if($errors->has($errName))
        @php $attrs['class'] .= ' is-invalid' @endphp
     @endif
    {{ Form::select($name, $options, $value, array_merge(['class' => 'custom-select w-100'], $attributes)) }}
    @if($errors->has($errName))
        <div class="invalid-feedback">{{ $errors->first($errName) }}</div>
    @endif
</div>
