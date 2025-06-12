<div class="field">
    <label for="{!! $field_name !!}">{!! $slot !!}</label>
    <input type="{!! $type ?? 'text' !!}"
           value="{!! $value ?? $_SESSION['old'][$field_name] ?? '' !!}"
           name="{!! $field_name !!}"
           id="{!! $field_name !!}"
           placeholder="{!! $placeholder ?? '' !!}"
           {!! $required ?? '' !!}
           @isset($minlength) minlength="{!! $minlength !!}"
           @endisset
           @isset($maxlength) maxlength="{!! $maxlength !!}"
            @endisset
    >
    @isset($_SESSION['errors'][$field_name])
        <div class="error"><p>{!! $_SESSION['errors'][$field_name]  !!}</p></div>
    @endisset
</div>