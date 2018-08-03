<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\EventDispatcher\Event;

class NodeAccessEvent extends Event
{
    use VoterTrait;

    const EVENT_NODE_ACCESS = 'node:access';

    private $node;
    private $account;
    private $op;

    /**
     * Default constructor
     */
    public function __construct($node, AccountInterface $account, string $op, bool $byVote = false)
    {
        // And yes, node can a string...
        $this->node = $node;
        $this->account = $account;
        $this->op = $op;
        $this->byVote = $byVote;
    }

    /**
     * Get node
     */
    public function getNode(): NodeInterface
    {
        return $this->node;
    }

    /**
     * Get account
     */
    public function getAccount(): AccountInterface
    {
        return $this->account;
    }

    /**
     * Get operation
     */
    public function getOperation(): string
    {
        return $this->op ?? '';
    }
}
