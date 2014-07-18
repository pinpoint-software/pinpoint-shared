<?php

namespace Pinpoint\Shared\EventCentric\When\ConventionBased;

use Pinpoint\Shared\EventCentric\DomainEvents\DomainEvent;
use Pinpoint\Shared\EventCentric\DomainEvents\DomainEvents;
use Pinpoint\Shared\EventCentric\When\When;
use Pinpoint\Shared\Verraes\ClassFunctions\ClassFunctions;

trait ConventionBasedWhen
{
    use When;

    /**
     * @param DomainEvent $event
     * @return void
     */
    protected function when(DomainEvent $event)
    {
        $method = 'when' . ClassFunctions::short($event);
        if(is_callable([$this, $method])) {
            $this->{$method}($event);
        }
    }

    /**
     * @param DomainEvents $events
     * @return void
     */
    protected function whenAll(DomainEvents $events)
    {
        foreach($events as $event) {
            $this->when($event);
        }
    }
}
