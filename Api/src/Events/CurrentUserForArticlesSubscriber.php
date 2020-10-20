<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CurrentUserForArticlesSubscriber implements EventSubscriberInterface
{
    private $Security;

    public function __construct(Security $Security)
    {
        $this->Security = $Security;
    }

    public static function getSubscribedEvents()
    {
        return[
           KernelEvents::VIEW => ['currentUserForArticles', EventPriorities::PRE_VALIDATE]
        ];
    }

    /**
     * Injeciton de l'autheur dans l'article créé.
     * @param ViewEvent $event
     */
    public function currentUserForArticles(ViewEvent $event): void
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        // on set l'author avec l'utilisateur connecté
        if ($article instanceof Article && Request::METHOD_POST == $method) {
            $article->setAuthor($this->Security->getUser());
        }
    }
}
