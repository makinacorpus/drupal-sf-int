<?php

namespace MakinaCorpus\Drupal\Sf\Security;

use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

class DrupalUser implements AdvancedUserInterface
{
    private $account;

    public function __construct(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Get associated Drupal account
     */
    public function getDrupalAccount(): AccountInterface
    {
        return $this->account;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->account->getRoles();
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->account->getAccountName();
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return true; // @todo return (bool)$this->account->status;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return true; // @todo return (bool)$this->account->status;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return true; // @todo return (bool)$this->account->status;
    }
}
