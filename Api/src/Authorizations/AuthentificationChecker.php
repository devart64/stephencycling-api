<?php


namespace App\Authorizations;


use AppBundle\Exceptions\AuthentificationException;
use AppBundle\Exceptions\ResourceAccessException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthentificationChecker implements AuthentificationCheckerInterface
{
    /**
     * @var ?UserInterface
     */
    private $user;

    public function __construct(Security $security) {

        $this->user = $security->getUser();
    }

    public function isAuthenticated(): void
    {
        if (null === $this->user) {
            throw new AuthentificationException(
                Response::HTTP_UNAUTHORIZED,
                self::MESSAGE_ERROR
            );
        }
    }
}