<?php

namespace App\EventListener;

use App\Event\CustomEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: CustomEvent::class, method: 'onCustomEvent')]
class CustomEventListener  
{
    public function __construct( private readonly LoggerInterface $logger)
    {
        # code...
    }

    public function onCustomEvent(CustomEvent $event):void
    {
       $this->logger->info("Un CustomEvent est survenu au timestamp suivant : {$event->getDateTime()->getTimestamp()}");

    }
   

}

