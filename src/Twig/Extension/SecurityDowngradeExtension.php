<?php

namespace MakinaCorpus\Drupal\Sf\Twig\Extension;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Provides a thin compatibility layer for when the security component is not enabled.
 */
class SecurityDowngradeExtension extends \Twig_Extension
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('is_granted', [$this, 'isGranted']),
        ];
    }

    /**
     * Is current user granted with
     */
    public function isGranted($attributes, $subject = null): bool
    {
        return $this->authorizationChecker->isGranted($attributes, $subject);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'drupal_security_downgrade';
    }
}
