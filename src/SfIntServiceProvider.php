<?php

namespace Drupal\sf_int;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderInterface;
use MakinaCorpus\Drupal\Sf\DependencyInjection\PropertyInfoCompilerPass;
use MakinaCorpus\Drupal\Sf\DependencyInjection\RegisterSecurityVotersCompilerPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class SfIntServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/Resources/config'));

        if (\class_exists('Symfony\\Component\\PropertyAccess\\PropertyAccess') && !$container->has('property_info')) {
            $loader->load('property_access.yml');
        }
        if (\class_exists('Symfony\\Component\\PropertyInfo\\PropertyInfoExtractor') && !$container->has('property_info')) {
            $loader->load('property_info.yml');
            $container->addCompilerPass(new PropertyInfoCompilerPass());
        }

        if (\in_array('Symfony\\Bundle\\SecurityBundle\\SecurityBundle', [] /* $bundles */)) {
            if (!$container->hasParameter('drupal.custom_firewall') || !$container->getParameter('drupal.custom_firewall')) {
                $loader->load('security.firewall.yml');
            }
        } else {
            $loader->load('security.downgrade.yml');
            $container->addCompilerPass(new RegisterSecurityVotersCompilerPass());
        }
        $loader->load('security.yml');
    }
}
