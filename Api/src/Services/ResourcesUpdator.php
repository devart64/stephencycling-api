<?php


namespace App\Services;

use App\Authorizations\AuthentificationCheckerInterface;
use App\Authorizations\ResourceAccessCheckerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ResourcesUpdator implements ResourcesUpdatorInterface
{

    protected $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];
    /**
     * @var ResourceAccessCheckerInterface
     */
    private $resourceAccessChecker;
    /**
     * @var AuthentificationCheckerInterface
     */
    private $authentificationChecker;

    public function __construct(ResourceAccessCheckerInterface $resourceAccessChecker, AuthentificationCheckerInterface $authentificationChecker)
    {
        $this->resourceAccessChecker = $resourceAccessChecker;
        $this->authentificationChecker = $authentificationChecker;
    }

    public function process(string $method, UserInterface $user): bool
    {
        if (in_array($method, $this->methodAllowed)) {
            $this->authentificationChecker->isAuthenticated();
            $this->resourceAccessChecker->canAccess($user->getgetId());
            // si pas d'exception de levée return true
            return true;
        }
        // sinon false
        return false;
    }
}
