<?php
namespace Pinpoint\Shared;

use Countable;
use SeekableIterator;

class EntityCollection implements SeekableIterator, Countable
{
    protected $position = 0;
    protected $entities = array();

    public function addEntity(Entity $entity)
    {
        $this->entities[] = $entity;
    }

    public function removeEntity(Entity $entity)
    {
        while (list($key) = each($this->entities)) {
            if ($this->entities[$key]->sameIdAs($entity)) {
                unset($this->entities[$key]);
            }
        }
        $this->entities = array_values($this->entities);
    }

    public function getHash()
    {
        return sha1(serialize($this->entities));
    }

    public function sameHashAs(EntityCollection $entityCollection)
    {
        return (0 == strcmp($this->getHash(), $entityCollection->getHash()));
    }

    // Countable Method

    public function count()
    {
        return count($this->entities);
    }

    // SeekableIterator Methods

    public function seek($position)
    {
        if (!isset($this->entities[$position])) {
            throw new \OutOfBoundsException("invalid seek position ($position)");
        }

        $this->position = $position;
    }

    public function current()
    {
        return $this->entities[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->entities[$this->position]);
    }
}
