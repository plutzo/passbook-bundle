<?php

namespace Marlinc\PassbookBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MarlincPassbookExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {

        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.xml');

        // Register all config values as parameters to inject them into services
        foreach ($configs as $subconfig) {
            $config = $this->unNest($subconfig, null, null, 2);
            foreach ($config as $key => $value) {
                $container->setParameter('marlinc_passbook.'.$key, $value);
            }
        }
    }

    protected function unNest($elem, $path = null, $result = null, $maxDepth = 10)
    {
        if ($result === null) {
            $result = [];
        }

        if (is_array($elem) && $maxDepth) {
            foreach ($elem as $key => $value) {
                $newPath = $path ? $path . '.' . $key : $key;
                $result = $this->unNest($value, $newPath, $result, $maxDepth - 1);
            }
        } else {
            $result[$path] = $elem;
        }

        return $result;
    }
}
