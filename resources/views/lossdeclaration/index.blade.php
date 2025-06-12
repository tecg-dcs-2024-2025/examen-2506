@component('layouts.app')
    <h1>Les déclarations de perte</h1>
    @if($losses)
        <table>
            <tr>
                <th scope="col">Date de la perte</th>
                <th scope="col">Nom du propriétaire</th>
                <th scope="col">Nom de l’animal</th>
            </tr>
            @foreach($losses as $loss)
                <tr>
                    <td>
                        <a href="/loss-declaration/show?id={!! $loss->id !!}">
                            {!! $loss->lost_at->locale('fr')->isoFormat('LL') !!}
                        </a>
                    </td>
                    <td>{!! $loss->pet_owner->name !!}</td>
                    <td><a href="/pet/edit?id={!! $loss->pet->id !!}">{!! $loss->pet->name !!}</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Il n’y a encore aucune déclaration enregistrée</p>
    @endif
@endcomponent