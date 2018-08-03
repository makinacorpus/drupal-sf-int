<?php

namespace MakinaCorpus\Drupal\Sf\EventDispatcher;

use Drupal\Core\Access\AccessResult;

trait VoterTrait
{
    private $byVote = false;
    private $ignored = 0;
    private $allowed = 0;
    private $denied = 0;
    private $result = Vote::IGNORE;

    /**
     * You don't care about this node
     */
    public function ignore()
    {
        ++$this->ignored;
    }

    /**
     * You say I grant access to this node
     */
    public function allow()
    {
        ++$this->allowed;

        if (Vote::DENY !== $this->result) {
            $this->result = Vote::ALLOW;
        }
    }

    /**
     * You say you shall not pass (it takes precedence over allow)
     */
    public function deny()
    {
        ++$this->denied;

        $this->result = Vote::DENY;

        // Where the actual magic happens please read the README.md file.
        if (!$this->byVote) {
            $this->stopPropagation();
        }
    }

    /**
     * Get the normal result
     */
    public function getResult(): AccessResult
    {
        if (Vote::IGNORE === $this->result) {
            return AccessResult::neutral();
        }
        if (Vote::ALLOW === $this->result) {
            return AccessResult::allowed();
        }
        return AccessResult::forbidden();
    }

    /**
     * Get the result by voter count
     */
    public function getResultByVote(): AccessResult
    {
        if (Vote::IGNORE === $this->result) {
            return AccessResult::neutral();
        }
        if ($this->denied < $this->allowed) {
            return AccessResult::allowed();
        }
        return AccessResult::forbidden();
    }
}
