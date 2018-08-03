<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;
use Drupal\Core\Session\AccountInterface;

final class NodeAddAccessEvent extends Event
{
    use VoterTrait;

    const EVENT = 'node:add:access';

    private $account;
    private $bundle;

    /**
     * Default constructor
     */
    public function __construct(AccountInterface $account, string $bundle)
    {
        $this->account = $account;
        $this->bundle = $bundle;
    }

    /**
     * Get account
     */
    public function getAccount(): AccountInterface
    {
        return $this->account;
    }

    /**
     * Get node type
     */
    public function getBundle(): string
    {
        return $this->bundle ?? '';
    }
}
