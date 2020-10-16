<?php


namespace App\Services;


use Symfony\Component\Security\Core\User\UserInterface;

interface ResourcesUpdatorInterface
{
    public function process(string $method, UserInterface $user): bool;
}