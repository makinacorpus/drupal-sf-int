<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Drupal\node\NodeInterface;

class NodeEvent extends EntityEvent
{
    const EVENT_DELETE        = 'node:delete';
    const EVENT_INSERT        = 'node:insert';
    const EVENT_PREINSERT     = 'node:preinsert';
    const EVENT_PREPARE       = 'node:prepare';
    const EVENT_PREUPDATE     = 'node:preupdate';
    const EVENT_PRESAVE       = 'node:presave';
    const EVENT_SAVE          = 'node:save';
    const EVENT_UPDATE        = 'node:update';
    const EVENT_VIEW          = 'node:view';
    const EVENT_ACCESS_CHANGE = 'node:accesschange';

    /**
     * Default constructor
     */
    public function __construct(string $eventName, NodeInterface $node, $userId = null, array $arguments = [])
    {
        parent::__construct($eventName, 'node', $node, $userId, $arguments);
    }

    /**
     * Is the current event a clone operation
     */
    public function isClone(): bool
    {
        return self::EVENT_INSERT === $this->getEventName() && !$this->getNode()->get('parent_nid')->isEmpty();
    }

    /**
     * Get the node
     */
    public function getNode(): NodeInterface
    {
        return $this->getEntity();
    }
}
