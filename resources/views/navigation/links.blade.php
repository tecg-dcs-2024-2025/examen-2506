<ul>
    @foreach($links as $link)
        <li>
            @component('components.link',compact('link'))
                {!! $link['label'] !!}
            @endcomponent
        </li>
    @endforeach
</ul>
