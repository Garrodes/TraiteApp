<?php

namespace App\Event;

use symfony\Contracts\EventDispatcher\Event;


/**
 * Knowledge Purpose Only, example to make an EventListener 
 * Prequel to an the UserListener which will hash password on the Event of a new one ? 
 */
class CustomEvent extends Event
{
    private \DateTimeImmutable $timestamp;

    public function __construct()
    {
        $this->timestamp = new \DateTimeImmutable() ;
    }

    public function getDateTime() : \DateTimeImmutable
    {
        return $this->timestamp;
    }
}