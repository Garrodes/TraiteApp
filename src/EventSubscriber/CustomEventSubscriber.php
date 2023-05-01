<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
        # code...
    }
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::RESPONSE => [
                ['onPreResponseEvent',255],
                ['onPostResponseEvent', 254]
            ]
        ];
    }

    public function onPreResponseEvent(ResponseEvent $event):void
    {
      
        $this->logger->info(__METHOD__);
    }

    public function onPostResponseEvent(ResponseEvent $event):void
    {
      
        $this->logger->info(__METHOD__);
    }
}