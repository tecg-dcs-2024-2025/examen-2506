<?php

namespace Animal\Controllers;

use Animal\Models\User;
use Tecgdcs\Response;
use Tecgdcs\Validator;
use Tecgdcs\View;

class AuthenticatedSessionController
{
    public function create(): void
    {
        View::make('auth.login');
    }

    public function store(): void
    {
        Validator::check([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $_REQUEST['email'])->first();
        if (!$user) {
            $_SESSION['old']['email'] = $_REQUEST['email'];
            $_SESSION['errors']['email'] = 'Cette adresse email n’existe pas dans notre base de données';
            Response::back();
        }
        if (!password_verify($_REQUEST['password'], $user->password)) {
            $_SESSION['old']['email'] = $_REQUEST['email'];
            $_SESSION['errors']['password'] = 'Donnée d’authentification non correcte';
            Response::back();
        }
        $_SESSION = [];
        $_SESSION['user'] = $user;
        Response::redirect('/dashboard');
    }

    public function destroy(): void
    {
        $_SESSION = [];
        session_destroy();
        Response::redirect('/');
    }
}