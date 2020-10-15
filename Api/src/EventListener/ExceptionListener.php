<?php


namespace App\EventListener;


use App\Normalizer\NormalizerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener implements EventSubscriberInterface
{

    private static $normalizers;

    public function __construct(SerializerInterface $serializer)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [['processException', 0]]
        ];
    }

    public function processException(ExceptionEvent $event)
    {

    }

    public function addNormalizer(NormalizerInterface $normalizer)
    {
        self::$normalizers[] = $normalizer;
    }

}