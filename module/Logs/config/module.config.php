<?php
/**
 * @see      http://github.com/zendframework/ZendSkeletonLogs for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Logs;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;

return [
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__.'/../public',
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'logs' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/logs',
                    'defaults' => [
                        'controller' => Controller\LogsController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\LogsController::class => Controller\Factory\LogsControllerFactory::class,
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive',
        ],
        'controllers' => [
            Controller\LogsController::class => [
                ['actions' => ['index'], 'allow' => '+logs.manage'],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\LogManager::class => Service\Factory\LogManagerFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'logs' => __DIR__.'/../view',
        ],
        'display_exceptions' => true,
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__.'_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__.'/../src/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__.'\Entity' => __NAMESPACE__.'_driver',
                ],
            ],
        ],
    ],
];
