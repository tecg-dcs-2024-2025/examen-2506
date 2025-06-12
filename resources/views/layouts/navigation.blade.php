<div role="navigation">
    @auth
        <div class="profile">
            <form action="/logout"
                  method="post">
                {!!  csrf_token()  !!}
                @component('components.form.buttons.normal')
                    Me déconnecter
                @endcomponent
            </form>
            <a href="/profile">Profil</a>
        </div>
    @endauth
</div>