<?php


namespace App\Authorizations;

interface AuthentificationCheckerInterface
{

    const MESSAGE_ERROR = "Vous n'êtes pas authentifié";

    public function isAuthenticated(): void;
}
