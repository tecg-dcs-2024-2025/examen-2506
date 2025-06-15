<?php

namespace Animal\Controllers;

use Animal\Models\Loss;
use Animal\Models\User;
use Tecgdcs\View;

class DashboardController
{
    public function index(): void
    {
        $title = 'Dashboard';

        $user = User::find($_SESSION['user']->id);

        $losses = $user->losses()->active()->get();

        View::make('lossdeclaration.index', compact('title', 'losses'));
    }
}