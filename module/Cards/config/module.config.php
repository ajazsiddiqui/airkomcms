<?php
/**
 * @see      http://github.com/zendframework/ZendSkeletonCards for the canonical source repository
 *
 * @copyright Copyright (c) 2005-2016 Zend Technocardies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cards;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;
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
            'cards' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/cards[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\CardsController::class,
                        'action' => 'index',
                    ],
                ],
            ],
			'gallery' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/gallery[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ],
                    'defaults' => [
                        'controller'    => Controller\GalleryController::class,
                        'action'        => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\CardsController::class => Controller\Factory\CardsControllerFactory::class,
			Controller\GalleryController::class => Controller\Factory\GalleryControllerFactory::class,
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive',
        ],
        'controllers' => [
            Controller\CardsController::class => [
                ['actions' => ['index','add'], 'allow' => '+cards.manage'],
                ['actions' => ['view','vcard','addContact'], 'allow' => '*'],
            ],
			Controller\GalleryController::class => [
                ['actions' => ['index','upload','file','delete'], 'allow' => '+cards.manage'],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\GalleryManager::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'cards' => __DIR__.'/../view',
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
