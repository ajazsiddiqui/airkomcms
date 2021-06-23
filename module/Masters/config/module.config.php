<?php

namespace Masters;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
			Controller\SystemUsertypeController::class => Controller\Factory\SystemUsertypeControllerFactory::class,
			Controller\ContactedTypeController::class => Controller\Factory\ContactedTypeControllerFactory::class,
			Controller\CallTypeController::class => Controller\Factory\CallTypeControllerFactory::class,
			Controller\LeadSourceController::class => Controller\Factory\LeadSourceControllerFactory::class,
			Controller\LeadStageController::class => Controller\Factory\LeadStageControllerFactory::class,
			Controller\MarketSegmentController::class => Controller\Factory\MarketSegmentControllerFactory::class,
			Controller\NextActionController::class => Controller\Factory\NextActionControllerFactory::class,
			Controller\ProbabilityController::class => Controller\Factory\ProbabilityControllerFactory::class,
			Controller\ProductsController::class => Controller\Factory\ProductsControllerFactory::class,
			Controller\ProductModelsController::class => Controller\Factory\ProductModelsControllerFactory::class,
			Controller\ProductSeriesController::class => Controller\Factory\ProductSeriesControllerFactory::class,
			Controller\SalesStageController::class => Controller\Factory\SalesStageControllerFactory::class,
			Controller\TravelModeController::class => Controller\Factory\TravelModeControllerFactory::class,
			Controller\TravelTypeController::class => Controller\Factory\TravelTypeControllerFactory::class,
			Controller\BranchController::class => Controller\Factory\BranchControllerFactory::class,

        ],
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'system-usertype' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/system-usertype[/:action[/:id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SystemUsertypeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
			'contacted-type' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/contacted-type[/:action[/:id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ContactedTypeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
			'call-type' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/call-type[/:action[/:id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\CallTypeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
			'lead-source' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/lead-source[/:action[/:id]]',
                    'constraints' => [
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\LeadSourceController::class,
                        'action' => 'index',
                    ],
                ],
            ],
			'lead-stage' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/lead-state[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\LeadStageController::class,
						'action' => 'index',
					],
				],
			],
			'market-segment' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/market-segment[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\MarketSegmentController::class,
						'action' => 'index',
					],
				],
			],
			'next-action' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/next-action[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\NextActionController::class,
						'action' => 'index',
					],
				],
			],
			'probability' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/probability[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\ProbabilityController::class,
						'action' => 'index',
					],
				],
			],
			'products' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/products[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\ProductsController::class,
						'action' => 'index',
					],
				],
			],
			'product-models' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/product-models[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\ProductModelsController::class,
						'action' => 'index',
					],
				],
			],
			'product-series' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/product-series[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\ProductSeriesController::class,
						'action' => 'index',
					],
				],
			],
			'sales-stage' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/sales-stage[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\SalesStageController::class,
						'action' => 'index',
					],
				],
			],
			'travel-mode' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/travel-mode[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\TravelModeController::class,
						'action' => 'index',
					],
				],
			],
			'travel-type' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/travel-type[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\TravelTypeController::class,
						'action' => 'index',
					],
				],
			],
			'branch' => [
				'type' => Segment::class,
				'options' => [
					'route' => '/branch[/:action[/:id]]',
					'constraints' => [
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					],
					'defaults' => [
						'controller' => Controller\BranchController::class,
						'action' => 'index',
					],
				],
			],

        ],
    ],

    'access_filter' => [
        'controllers' => [
            Controller\SystemUsertypeController::class => [
                ['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
            ],
			Controller\ContactedTypeController::class => [
                ['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
            ],
			Controller\CallTypeController::class => [
                ['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
            ],
			Controller\LeadSourceController::class => [
                ['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
            ],
			Controller\LeadStageController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\MarketSegmentController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\NextActionController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\ProbabilityController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\ProductsController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\ProductModelsController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\ProductSeriesController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\SalesStageController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\TravelModeController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\TravelTypeController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
			Controller\BranchController::class => [
				['actions' => ['index', 'add', 'edit', 'setstatus', 'delete'], 'allow' => '+masters.manage'],
			],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'masters' => __DIR__.'/../view',
        ],
        'display_exceptions' => true,
    ],
    'view_helpers' => [
        'factories' => [
            View\Helper\MasterDetails::class => View\Helper\Factory\MasterDetailsFactory::class,
        ],
        'aliases' => [
            'MasterDetails' => View\Helper\MasterDetails::class,
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
];
