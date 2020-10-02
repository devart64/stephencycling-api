<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorizations\UserAuthorizationChecker;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSubscriber implements EventSubscriberInterface
{

    private $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];
    /**
     * @var UserAuthorizationChecker
     */
    private $userAuthorizationChecker;

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker){


        $this->userAuthorizationChecker = $userAuthorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    /**
     * check de l'user
     * @param ViewEvent $event
     */
    public function check(ViewEvent $event):void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        // on recherche la method dans notre tableau
        if ($user instanceof User && !in_array($method, $this->methodNotAllowed, true)) {
            $this->userAuthorizationChecker->check($user, $method);
            $user->setUpdatedAt(new \DateTimeImmutable());
        }
    }

}