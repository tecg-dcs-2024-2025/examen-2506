@php
    $links = [
        [
            'label' => 'déclarations',
            'url' => '/loss-declaration'
        ],
        [
            'label' => 'animaux',
            'url' => '/pet'
        ],
        [
            'label' => 'propriétaires',
            'url' => '/pet-owner'
        ]
];
@endphp
<div role="navigation">
    @auth
        <div class="profile">
            @component('auth.logout')
            @endcomponent
            @component('components.link',['link'=>['url'=>'/profile']])
                Profil
            @endcomponent
            @component('navigation.links',compact('links'))
            @endcomponent
        </div>
    @endauth
</div>