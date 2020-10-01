<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){

        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    /**
     * Encodage du password à la création de l'user
     * @param ViewEvent $event
     */
    public function encodePassword(ViewEvent $event):void
    {
        $user = $event->getControllerResult();

        if ($user instanceof User) {
            $passhash = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passhash);
        }
    }

}