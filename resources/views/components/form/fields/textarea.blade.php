<div class="field">
    <label for="{!! $field_name !!}">{!! $slot !!}</label>
    <textarea name="{!! $field_name !!}"
              id="{!! $field_name !!}"
              rows="10"
              placeholder="{!! $placeholder ?? '' !!}">{!! $_SESSION['old'][$field_name] ?? ''  !!}</textarea>
    @isset($_SESSION['errors'][$field_name])
        <div class="error"><p>{!! $_SESSION['errors'][$field_name]  !!}</p></div>
    @endisset
</div>