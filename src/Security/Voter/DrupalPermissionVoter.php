<?php

namespace MakinaCorpus\Drupal\Sf\Security\Voter;

use MakinaCorpus\Drupal\Sf\Security\DrupalUser;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * Use the Symfony security component voter interface to vote using Drupal
 * permissions for granting access
 */
class DrupalPermissionVoter implements VoterInterface
{
    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $subject, array $attributes)
    {
        if (null !== $subject && 'permission' !== $subject) {
            return self::ACCESS_ABSTAIN;
        }

        $user = $token->getUser();
        if (!$user instanceof DrupalUser) {
            return self::ACCESS_ABSTAIN;
        }

        $vote = self::ACCESS_ABSTAIN;
        $account = $user->getDrupalAccount();

        foreach ($attributes as $attribute) {
            if (\is_string($attribute)) {

                // As soon as we support one attribute, defaults to deny.
                $vote = self::ACCESS_DENIED;

                if ($account->hasPermission($attribute)) {
                    return self::ACCESS_GRANTED;
                }
            }
        }

        return $vote;
    }
}
