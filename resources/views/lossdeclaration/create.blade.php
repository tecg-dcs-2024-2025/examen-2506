@component('layouts.app',compact('title'))
    <h1>Déclaration de perte d'animal</h1>
    <form action="/loss-declaration"
          method="post">
        {!! csrf_token() !!}
        <fieldset>
            <legend>Vos coordonn&eacute;es</legend>
            <div class="fields">
                <!-- First Name -->
                @component('components.form.fields.input_text',
[
   'type' => 'text',
   'field_name' => 'first-name',
   'placeholder' => 'Jean'
])
                Prénom
                @endcomponent
                <!-- Last Name -->
                @component('components.form.fields.input_text',
[
'type' => 'text',
'field_name' => 'last-name',
'placeholder' => 'Valjean'
])
                Nom
                @endcomponent
                <!-- Email field -->
                @component('components.form.fields.input_text',
[
'type' => 'email',
'field_name' => 'email',
'placeholder' => 'jean.valjean@miserables.fr',
'required' => 'required'
])
                    <abbr title="requis">*</abbr>&nbsp;Email
                @endcomponent
                <!-- Email verification -->
                @component('components.form.fields.input_text',
[
'type' => 'email',
'field_name' => 'vemail',
'required' => 'required'
])
                    <abbr title="requis">*</abbr>&nbsp;Vérification de l’email
                @endcomponent
                <!-- Phone number -->
                @component('components.form.fields.input_text',
[
'type' => 'tel',
'field_name' => 'phone',
'placeholder' => '+32 (0)4 279 75 01',
])
                Numéro de téléphone
                @endcomponent
                <!-- Country -->
                @component('components.form.fields.select',
[
    'field_name' => 'country',
    'collection' => $countries,
    'key' => 'code',
])
                Pays
                @endcomponent
            </div>
        </fieldset>

        <fieldset>
            <legend>Description de l&rsquo;animal disparu</legend>
            <div class="fields">
                <!-- Pet Type -->
                @component('components.form.fields.select',
[
    'field_name' => 'pet-type',
    'collection' => $pet_types,
    'key' => 'code',
])
                Type d&rsquo;animal
                @endcomponent
                <!-- Pet Name -->
                @component('components.form.fields.input_text',
[
'field_name' => 'pet-name',
'required' => 'required',
'placeholder' => 'Rex',
])
                    <abbr title="requis">*</abbr>&nbsp;Nom de l&rsquo;animal
                @endcomponent
                <!-- Pet chip -->
                @component('components.form.fields.input_text',
[
'field_name' => 'pet-chip',
'required' => 'required',
'placeholder' => '688587',
])
                    <abbr title="requis">*</abbr>&nbsp;Puce
                @endcomponent
                <!-- Pet Gender -->
                <div class="field row-radio">
                    <p>Sexe</p>
                    <input type="radio"
                           name="pet-gender"
                           id="pet-gender-female"
                           value="female"
                           <?php
                           if (isset($_SESSION['old']['pet-gender']) && $_SESSION['old']['pet-gender'] === 'female') : ?>
                           checked
                        <?php
                        endif ?>
                    ><label for="pet-gender-female">Femelle</label>

                    <input type="radio"
                           name="pet-gender"
                           id="pet-gender-male"
                           value="male"
                           <?php
                           if (isset($_SESSION['old']['pet-gender']) && $_SESSION['old']['pet-gender'] === 'male') : ?>
                           checked
                        <?php
                        endif ?>
                    ><label for="pet-gender-male">Male</label>

                    <?php
                    if (isset($_SESSION['errors']['pet-gender'])) : ?>
                    <div class="error"><p><?= $_SESSION['errors']['pet-gender'] ?></p></div>
                    <?php
                    endif ?>
                </div>
                <!-- Pet Age -->
                @component('components.form.fields.input_text',
[
'type' => 'number',
'field_name' => 'pet-age',
'placeholder' => '5',
])
                    &Acirc;ge de l&rsquo;animal
                <br><small>Approximativement en ann&eacute;es</small>
                @endcomponent

                <!-- Pet Race -->
                @component('components.form.fields.input_text',
[
'field_name' => 'pet-race',
'placeholder' => 'Caniche',
])
                Race de l&rsquo;animal
                @endcomponent

                <!-- Pet tattoo -->
                <div class="field row-radio">
                    <label for="pet-tattoo-location">Tatouage</label>
                    <select name="pet-tattoo-location"
                            id="pet-tattoo-location">
                        <option value="0">Pas de tatouage</option>
                        <option value="left-ear">Oreille gauche</option>
                        <option value="right-ear">Oreille droite</option>
                        <option value="mouth">Bouche</option>
                    </select>
                    <label for="pet-tattoo">Code</label>
                    <input type="text"
                           value="<?= $_SESSION['old']['pet-tattoo'] ?? '' ?>"
                           name="pet-tattoo"
                           id="pet-tattoo"
                           placeholder="898HH0">
                    <?php
                    if (isset($_SESSION['errors']['pet-tattoo'])) : ?>
                    <div class="error"><p><?= $_SESSION['errors']['pet-tattoo'] ?></p></div>
                    <?php
                    endif ?>
                </div>
                <!-- Pet Description -->
                @component('components.form.fields.textarea',
[
    'field_name' => 'pet-description',
    'placeholder' => 'C’est un bon gamin',
])
                Description de l’animal
                @endcomponent
                <!-- Pet Race -->
                <div class="field">
                    <label for="pet-picture">Photo de l&rsquo;animal</label>
                    <input type="file"
                           name="pet-picture"
                           id="pet-picture">
                    <?php
                    if (isset($_SESSION['errors']['pet-picture'])) : ?>
                    <div class="error">
                        <p><?= $_SESSION['errors']['pet-picture'] ?></p>
                    </div>
                    <?php
                    elseif (!empty($_SESSION['errors'])) : ?>
                    <div class="error">
                        <p>Il faut res&eacute;lectionner l&rsquo;image que vous aviez choisie, sinon, elle sera
                           perdue.</p>
                    </div>
                    <?php
                    endif ?>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Date et localit&eacute; de la disparition</legend>
            <div class="fields">
                <!-- Date field -->
                @component('components.form.fields.input_text',
[
    'type' => 'date',
    'field_name' => 'disparition-date',
    'required' => 'required'
])
                Date de la disparition
                    <br><small>Ann&eacute;e/mois/jour ou s&eacute;lection dans le calendrier</small>
                @endcomponent

                <!-- Disparition time -->
                @component('components.form.fields.input_text',
[
    'type' => 'time',
    'field_name' => 'disparition-time',
    'required' => 'required'
])
                Heure
                    <br><small>Heures:minutes ou s&eacute;lection de l&rsquo;heure</small>
                @endcomponent
                <!-- Disparition postal code -->
                @component('components.form.fields.input_text',
[
    'type' => 'number',
    'field_name' => 'disparition-postal-code',
    'required' => 'required',
    'placeholder' => '4000',
    'minlength' => '4',
    'maxlength' => '5',
])
                Code postal
                @endcomponent
                <!-- Disparition Country -->
                @component('components.form.fields.select',
                [
                    'field_name' => 'disparition-country',
                    'collection' => $countries,
                    'key' => 'code',
                ])
                Pays
                @endcomponent
            </div>
        </fieldset>
        @component('components.form.buttons.normal')
            D&eacute;clarer la perte de mon animal
        @endcomponent
    </form>
@endcomponent