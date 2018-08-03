<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

trait EntityEventTrait
{
    private $eventName;
    private $entityType;
    private $userId;

    /**
     * Get the event name
     */
    final public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * Set the event name
     */
    final protected function setEventName(string $eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * Get entity type
     */
    final public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * Set entity type
     */
    final protected function setEntityType(string $entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * Get the user identifier which triggered the event
     *
     * @return int|string
     */
    final public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the user identifier which triggered the event
     *
     * @param int|string $userId
     */
    final protected function setUserId($userId)
    {
        $this->userId = $userId;
    }
}
