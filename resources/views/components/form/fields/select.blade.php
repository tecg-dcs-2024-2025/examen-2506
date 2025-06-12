<div class="field">
    <label for="{!! $field_name !!}">{!! $slot !!}</label>
    <select name="{!! $field_name !!}"
            id="{!! $field_name !!}">

        @foreach ($collection as $item)
            <option value="{!! $item->$key !!}"
                    @if((isset($_SESSION['old'][$field_name]) && $item->$key === $_SESSION['old'][$field_name]))
                        selected
                    @endif
            >{!! $item->translated_full_name !!}</option>
        @endforeach
    </select>
    @isset($_SESSION['errors'][$field_name])
        <div class="error"><p>{!! $_SESSION['errors'][$field_name]  !!}</p></div>
    @endisset
</div>