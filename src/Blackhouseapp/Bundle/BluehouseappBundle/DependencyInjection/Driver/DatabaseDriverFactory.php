<?php


namespace  Blackhouseapp\Bundle\BluehouseappBundle\DependencyInjection\Driver;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class DatabaseDriverFactory
{
    public static function get(
        $type ,
        ContainerBuilder $container,
        $prefix,
        $resourceName,
        $managerName,
        $templates = null
    ) {

                return new DoctrineORMDriver($container, $prefix, $resourceName, $managerName, $templates);

    }
}
