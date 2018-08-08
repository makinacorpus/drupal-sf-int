<?php

namespace MakinaCorpus\Drupal\Sf\Security;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DrupalRoutingAccessVoter implements AccessInterface
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     *
     */
    public function access(Route $route, RouteMatchInterface $route_match)
    {
        $requirement = $route->getRequirement('_is_granted');
        if (!\is_string($requirement) || !\strpos($requirement, '.')) {
            throw new \InvalidArgumentException(sprintf("'_is_granted' requirement awaits a string such as 'attribute.parameter_name'"));
        }

        list($parameter, $attribute) = explode('.', $requirement, 2);

        if (!$object = $route_match->getParameter($parameter)) {
            AccessResult::forbidden();
        }

        if ($this->authorizationChecker->isGranted($attribute, $object)) {
            return AccessResult::allowed();
        }

        return AccessResult::forbidden();
    }
}
