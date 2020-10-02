<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Authorizations\ArticleAuthorizationChecker;
use App\Authorizations\UserAuthorizationChecker;
use App\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ArticleSubscriber implements EventSubscriberInterface
{

    private $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];
    /**
     * @var ArticleAuthorizationChecker
     */
    private $articleAuthorizationChecker;

    public function __construct(ArticleAuthorizationChecker $articleAuthorizationChecker){


        $this->articleAuthorizationChecker = $articleAuthorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    /**
     * check de l'article
     * @param ViewEvent $event
     */
    public function check(ViewEvent $event):void
    {
        $article = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        // on recherche la method dans notre tableau
        if ($article instanceof Article && !in_array($method, $this->methodNotAllowed, true)) {
            $this->articleAuthorizationChecker->check($article, $method);
            $article->setUpdatedAt(new \DateTimeImmutable());
        }
    }

}