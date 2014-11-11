<?php


namespace  Blackhouseapp\Bundle\BluehouseappBundle\DependencyInjection\Driver;


interface DatabaseDriverInterface
{
    public function load(array $classes);


}
