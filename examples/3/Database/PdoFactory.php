<?php

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
class PDOFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return PDO
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PDO(
            'sqlite:' . __DIR__ . '/../example.db'
        );
    }
}
