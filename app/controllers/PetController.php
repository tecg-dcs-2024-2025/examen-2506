<?php

namespace Animal\Controllers;

use Animal\Models\Pet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tecgdcs\Response;
use Tecgdcs\Validator;
use Tecgdcs\View;

class PetController
{
    public function edit()
    {
        $id = (int) trim($_REQUEST['id']);

        try {
            $pet = Pet::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Response::abort();
        }

        $title = 'Mettre à jour la fiche de '.$pet->name;

        View::make('pet.edit', compact('title', 'pet'));
    }

    public function update()
    {
        $id = (int) trim($_REQUEST['id']);

        Validator::check([
            'name' => 'required',
        ]);

        $pet = Pet::findOrFail($id);
        $pet->name = trim($_REQUEST['name']);
        $pet->save();

        Response::back();
    }
}