<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

class NodeCollectionEvent extends EntityCollectionEvent
{
    const EVENT_LOAD = 'node:load';

    /**
     * Default constructor
     */
    public function __construct(string $eventName, array $nodes, $userId = null, array $arguments = [])
    {
        parent::__construct($eventName, 'node', $nodes, $userId, $arguments);
    }

    /**
     * Get the nodes
     *
     * @return \Drupal\node\NodeInterface[]
     */
    public function getNodes(): array
    {
        return parent::getEntities();
    }
}
