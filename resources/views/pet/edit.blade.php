@component('layouts.app',compact('title'))
    <h1>{!! $pet->name !!}</h1>
    <form action="/pet/edit"
          method="post">
        {!! csrf_token() !!}
        <input type="hidden"
               name="id"
               value="{!! $pet->id !!}">
        <fieldset>
            <div class="fields">
                @component('components.form.fields.input_text',[
            'field_name' => 'name',
            'value' => $pet->name,
            'placeholder' => $pet->name,
            'required' => 'required'
        ])
                    <abbr title="requis">*</abbr>&nbsp;Nom
                @endcomponent
            </div>
        </fieldset>
        @component('components.form.buttons.normal')
            Enregistrer
        @endcomponent
    </form>
@endcomponent