<?php


namespace App\Authorizations;

interface ResourceAccessCheckerInterface
{

    const MESSAGE_ERROR = "Ce n'est pas votre resource";

    public function canAccess(?int $id): void;
}
