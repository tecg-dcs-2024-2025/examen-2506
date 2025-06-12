<?php

namespace Animal\Middlewares;

use Animal\Models\Loss;
use Tecgdcs\Contracts\Middleware;
use Tecgdcs\Response;

class OwnsLoss implements Middleware
{

    public function handle(): void
    {
        // Notez que le code suivant ne prend pas beaucoup de précautions
        // Ce middleware n'a de sens que si un utilisateur est connecté
        // et si un id a été fourni dans la QueryString.
        // Il est donc important de l'utiliser conjointement aux middlewares
        // Auth et RequestRequiresId.
        // Attention que l’ordre de l'attachement des MW à la route est important

        $loss = Loss::findOrFail((int) $_GET['id']);

        $user_id = $_SESSION['user']->id;

        if ($loss->user_id !== $user_id) {
            Response::abort(Response::UNAUTHORIZED);
        }
    }
}