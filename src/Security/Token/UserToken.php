<?php

namespace MakinaCorpus\Drupal\Sf\Security\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class UserToken extends AbstractToken
{
    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        $user = $this->getUser();

        return [$user ? $user->getUsername() : null, $user ? $this->getPassword() : null];
    }
}
