<?php

namespace Pinpoint\Shared\EventCentric\AggregateRoot;

use Pinpoint\Shared\EventCentric\DomainEvents\DomainEvent;
use Pinpoint\Shared\EventCentric\DomainEvents\DomainEvents;
use Pinpoint\Shared\EventCentric\DomainEvents\DomainEventsArray;

/**
 * Implements TracksChanges
 */
trait EventSourcing
{
    private $recordedEvents = [];

    /**
     * Determine whether the object's state has changed since the last clearChanges();
     * @return bool
     */
    public function hasChanges()
    {
        return !empty($this->recordedEvents);
    }

    /**
     * Get all changes to the object since the last the last clearChanges();
     * @return DomainEvents
     */
    public function getChanges()
    {
        return new DomainEventsArray($this->recordedEvents);
    }

    /**
     * Clear all state changes from this object.
     * @return void
     */
    public function clearChanges()
    {
        $this->recordedEvents = [];
    }

    /**
     * @param DomainEvent $event
     * @return static
     */
    protected function recordThat(DomainEvent $event)
    {
        $this->recordedEvents[] = $event;
        $this->when($event);
        return $this;
    }
}
