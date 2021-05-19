<?php

namespace Settings;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\SettingsController::class => Controller\Factory\SettingsControllerFactory::class,
            Controller\TaxController::class => Controller\Factory\TaxControllerFactory::class,
        ],
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'settings' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/settings[/:action[/:id][/:settings_id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SettingsController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'tax' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/tax[/:action[/:id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\TaxController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],

    'access_filter' => [
        'controllers' => [
            Controller\SettingsController::class => [
                ['actions' => ['index'], 'allow' => '+settings.manage'],
            ],
            Controller\TaxController::class => [
                ['actions' => ['index', 'add', 'edit', 'delete'], 'allow' => '+settings.manage'],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'settings' => __DIR__.'/../view',
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
