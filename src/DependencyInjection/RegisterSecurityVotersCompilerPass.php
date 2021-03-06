<?php

namespace MakinaCorpus\Drupal\Sf\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;

/**
 * This class was mostly copy/pasted from the Symfony SecurityBundle (v3.2)
 * all credits to its original author.
 *
 * --
 *
 * Adds all configured security voters to the access decision manager.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class RegisterSecurityVotersCompilerPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('security.access.decision_manager')) {
            return;
        }

        $voters = $this->findAndSortTaggedServices('security.voter', $container);
        if (!$voters) {
            return; // Removed the exception when there is no voter.
        }

        $adm = $container->getDefinition($container->hasDefinition('debug.security.access.decision_manager') ? 'debug.security.access.decision_manager' : 'security.access.decision_manager');
        if ($adm->getArguments()) {
            $adm->replaceArgument(0, [$voters]);
        } else {
            $adm->setArguments([$voters]);
        }
    }
}
