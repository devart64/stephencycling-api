<?php


namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Article;
use App\Entity\User;
use App\Services\ResourcesUpdatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResourceUpdatorSubscriber implements EventSubscriberInterface
{


    /**
     * @var ResourcesUpdatorInterface
     */
    private $resourcesUpdator;

    public function __construct(ResourcesUpdatorInterface $resourcesUpdator)
    {


        $this->resourcesUpdator = $resourcesUpdator;
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
        $objet = $event->getControllerResult();
        // on recherche la method dans notre tableau
        if ($objet instanceof User || $objet instanceof Article) {
            $user = $objet instanceof User ? $objet : $objet->getAuthor();
            $canProcess = $this->resourcesUpdator->process($event->getRequest()->getMethod(), $user);
            if ($canProcess) {
                $user->setUpdatedAt(new \DateTimeImmutable());
            }
        }
    }
}
