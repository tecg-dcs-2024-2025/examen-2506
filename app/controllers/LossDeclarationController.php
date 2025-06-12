<?php

namespace Animal\Controllers;

use Animal\Models\Country;
use Animal\Models\Loss;
use Animal\Models\Pet;
use Animal\Models\PetOwner;
use Animal\Models\PetType;
use Animal\Models\User;
use Carbon\Carbon;
use JetBrains\PhpStorm\NoReturn;
use Tecgdcs\Response;
use Tecgdcs\Validator;
use Tecgdcs\View;

class LossDeclarationController
{
    public function index(): void
    {
        $title = 'Dashboard';

        $user = User::find($_SESSION['user']->id);

        View::make('lossdeclaration.index', compact('title', 'losses'));
    }

    #[NoReturn]
    public function store(): void
    {
        $_SESSION['errors'] = null;
        $_SESSION['old'] = null;

        Validator::check([
            'email' => 'required|email',
            'vemail' => 'required|same:email',
            'phone' => 'phone',
            'country' => 'exists:countries,code',
        ]);

        $owner = PetOwner::upsert(
            [
                [
                    'email' => $_REQUEST['email'],
                    'phone' => $_REQUEST['phone'],
                ],
            ],
            uniqueBy: ['email'],
            update: ['phone']
        );
        // Cette méthode n'est pas terminée
        // Idéalement, elle devrait créer une déclaration qui crée une perte, stockée dans loss
        //Ici, je vais le simuler sans utiliser les données du formulaire.
        $user = $_SESSION['user'] ?? null;
        $loss = Loss::create([
            'pet_id' => Pet::inRandomOrder()->first()->id,
            'pet_owner_id' => $owner->id,
            'country_id' => Country::inRandomOrder()->first()->id,
            'postal_code' => random_int(1000, 9999),
            'lost_at' => Carbon::now(),
            'user_id' => $user?->id
        ]);

        Response::redirect('/loss-declaration/show?id='.$loss->id);
    }

    public function create()
    {
        $countries = Country::all();
        $pet_types = PetType::all();
        $title = "J’ai perdu mon animal";
        View::make('lossdeclaration.create', compact('pet_types', 'countries', 'title'));
    }

    public function show(): void
    {
        $id = (int) trim($_REQUEST['id']);

        $title = 'Détails de la déclaration de perte';

        View::make('lossdeclaration.show', compact('title', 'loss'));
    }
}
