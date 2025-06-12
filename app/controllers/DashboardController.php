<?php

namespace Animal\Controllers;

use Animal\Models\Loss;
use Tecgdcs\Response;
use Tecgdcs\View;

class DashboardController
{
    public function index(): void
    {
        $title = 'Les déclarations de perte';
        $losses = Loss::all();

        View::make('lossdeclaration.index', compact('title', 'losses'));
    }
}