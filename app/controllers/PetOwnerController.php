<?php

namespace Animal\Controllers;

use Tecgdcs\View;

class PetOwnerController
{
    public function index()
    {
        View::make('petowner.index', ['title' => 'Propriétaires']);
    }
}