<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Symfony\Component\Config\Definition\Processor;
use Blackhouseapp\Bundle\BluehouseappBundle\DependencyInjection\Driver\DatabaseDriverFactory;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BlackhouseappBluehouseappExtension extends Extension
{
    protected $applicationName = 'blackhouseapp_bluehouseapp';
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);



        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $config = $this->process($config, $container);
        $this->loadDatabaseDriver($config, $loader, $container);

    }
    protected function process(array $config, ContainerBuilder $container)
    {
        // Override if needed.
        return $config;
    }

    protected function loadDatabaseDriver(array $config, XmlFileLoader $loader, ContainerBuilder $container)
    {
        foreach ($config['classes'] as $model => $classes) {
            if (array_key_exists('model', $classes)) {
                DatabaseDriverFactory::get(
                    'orm',
                    $container,
                    $this->applicationName,
                    $model,
                    isset($config['object_manager']) ? $config['object_manager'] : 'default',
                    isset($config['templates'][$model]) ? $config['templates'][$model] : null
                )->load($classes);
            }
        }
    }
}
