<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'spt' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/spt[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\SPTController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'dcr' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dcr[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\DCRController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'pipeline' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/pipeline[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\PipelineController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'roadmap' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/roadmap[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\RoadmapController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'reports' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/reports[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\ReportsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'dashboard' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/dashboard[/:action]',
                    'defaults' => [
                        'controller' => Controller\DashboardController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
			'contacts' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/contacts[/:action[/:id]]',
                    'defaults' => [
                        'controller' => Controller\ContactsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Controller\Factory\IndexControllerFactory::class,
            Controller\SPTController::class => Controller\Factory\SPTControllerFactory::class,
            Controller\DCRController::class => Controller\Factory\DCRControllerFactory::class,
            Controller\PipelineController::class => Controller\Factory\PipelineControllerFactory::class,
            Controller\RoadmapController::class => Controller\Factory\RoadmapControllerFactory::class,
            Controller\ReportsController::class => Controller\Factory\ReportsControllerFactory::class,
            Controller\DashboardController::class => Controller\Factory\DashboardControllerFactory::class,
            Controller\ContactsController::class => Controller\Factory\ContactsControllerFactory::class,
        ],
    ],
    'access_filter' => [
        'options' => [
            'mode' => 'restrictive',
        ],
        'controllers' => [
            Controller\IndexController::class => [
                ['actions' => ['index','add','edit','delete'], 'allow' => '+dashboard.manage'],
            ],
            Controller\SPTController::class => [
                ['actions' => ['getContact','index','add','edit','delete','close'], 'allow' => '+spt.manage'],
            ],
		
            Controller\DCRController::class => [
                ['actions' => ['index','add','edit','delete'], 'allow' => '+dcr.manage'],
            ],
			Controller\PipelineController::class => [
                ['actions' => ['index'], 'allow' => '+pipeline.manage'],
				 ['actions' => ['changeStage'], 'allow' => '*'],
            ],
            Controller\RoadmapController::class => [
                ['actions' => ['getCity','index','add','edit','delete'], 'allow' => '+roadmap.manage'],
            ],
            Controller\ReportsController::class => [
                ['actions' => ['index','add','edit','delete'], 'allow' => '+reports.manage'],
            ],
            Controller\DashboardController::class => [
                ['actions' => ['index','sptreport','dcrreport','roadmapreport'], 'allow' => '+dashboard.manage'],
            ],
			Controller\ContactsController::class => [
                ['actions' => ['index','add','edit','delete'], 'allow' => '+contacts.manage'],
            ]
        ],
    ],
    'rbac_manager' => [
        'assertions' => [Service\RbacAssertionManager::class],
    ],
    'service_manager' => [
        'factories' => [
			Service\NavManager::class => Service\Factory\NavManagerFactory::class,
			Service\RbacAssertionManager::class => Service\Factory\RbacAssertionManagerFactory::class,
            Service\ExtranetUtilities::class => Service\Factory\ExtranetUtilitiesFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            // View\Helper\SearchEngine::class => View\Helper\Factory\SearchEngineFactory::class,
            // View\Helper\TaxDetails::class => View\Helper\Factory\TaxDetailsFactory::class,
            View\Helper\SystemSettings::class => View\Helper\Factory\SystemSettingsFactory::class,
            View\Helper\ContactDetail::class => View\Helper\Factory\ContactDetailFactory::class,
            View\Helper\Menu::class => View\Helper\Factory\MenuFactory::class,
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
            View\Helper\PageActions::class => InvokableFactory::class,
        ],
        'aliases' => [
            // 'SearchEngine' => View\Helper\SearchEngine::class,
            // 'TaxDetails' => View\Helper\TaxDetails::class,
            'SystemSettings' => View\Helper\SystemSettings::class,
            'ContactDetail' => View\Helper\ContactDetail::class,
            'mainMenu' => View\Helper\Menu::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
            'PageActions' => View\Helper\PageActions::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
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
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format' => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
            'message_close_string' => '</div>',
            'message_separator_string' => '</div><div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>',
        ],
    ],
    'session_containers' => [
        'airkom',
    ],
];
