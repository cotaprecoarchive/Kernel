<?php

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
use Zend\ServiceManager\ServiceLocatorInterface;

return [
    'factories' => [
        PDO::class => PdoFactory::class,
        GetUserList::class => function (ServiceLocatorInterface $serviceLocator) {
            /* @var PDO $db */
            $db = $serviceLocator->get(PDO::class);

            return new GetUserList($db);
        }
    ]
];
