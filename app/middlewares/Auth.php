<?php

namespace Animal\Middlewares;

use Tecgdcs\Contracts\Middleware;
use Tecgdcs\Response;

class Auth implements Middleware
{

    public function handle(): void
    {
        if (!isset($_SESSION['user'])) {
            Response::redirect('/login');
        }
    }
}