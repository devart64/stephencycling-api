<?php

namespace App\Authorizations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class UserAuthorizationChecker
{
    private $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];
    /**
     * @var ?UserInterface|null
     */
    private $user;

    public function __construct(Security $security) {
        $this->user = $security->getUser();
    }

    public function check(UserInterface $user, string $method): void
    {
        $this->isAuthenticated();

        if ($this->isMethodAllowed($method) && $user->getId() !== $this->user->getId()  ) {
            $errorMessage = "Ceci ne t'appartient pas !";
            throw new UnauthorizedHttpException($errorMessage, $errorMessage);
        }
    }

    /**
     * l'utilisateur est il connecté
     */
    public function isAuthenticated(): void
    {
        if (null === $this->user) {
            $errorMessage = "Tu n'es pas connecté !";
            throw new UnauthorizedHttpException($errorMessage, $errorMessage);
        }
    }

    /**
     * Vérificaiton de la méthode http
     * @param string $method
     * @return bool
     */
    public function isMethodAllowed(string $method): bool
    {
        return in_array($method, $this->methodAllowed, true);
    }


}