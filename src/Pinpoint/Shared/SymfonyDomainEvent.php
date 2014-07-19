<?php

namespace Pinpoint\Shared;

use Pinpoint\Shared\EventCentric\DomainEvents\DomainEvent;
use Symfony\Component\EventDispatcher\Event;

class SymfonyDomainEvent extends Event
{
    private $domainEvent;

    public function __construct(DomainEvent $domainEvent)
    {
        $this->domainEvent = $domainEvent;
    }

    public function domainEvent()
    {
        return $this->domainEvent;
    }
}
