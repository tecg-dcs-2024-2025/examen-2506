@component('layouts.app',compact('title'))
    <h1>Récapitulatif de votre déclaration</h1>

    <dl>
        <div>
            <dt>Nom de l'animal&nbsp;:</dt>
            <dd>{!! $loss?->pet?->name  !!}</dd>
        </div>
        <div>
            <dt>Date de la perte&nbsp;:</dt>
            <dd>{!! $loss?->lost_at?->locale('fr')->isoFormat('LL') !!}</dd>
        </div>
    </dl>
@endcomponent