<?php

namespace Application\Service;

/**
 * This service is responsible for determining which items should be in the main menu.
 * The items may be different depending on whether the user is authenticated or not.
 */
class NavManager
{
    /**
     * Auth service.
     *
     * @var Laminas\Authentication\Authentication
     */
    private $authService;

    /**
     * Url view helper.
     *
     * @var Laminas\View\Helper\Url
     */
    private $urlHelper;

    /**
     * RBAC manager.
     *
     * @var User\Service\RbacManager
     */
    private $rbacManager;
    private $translator;

    /**
     * Constructs the service.
     *
     * @param mixed $authService
     * @param mixed $urlHelper
     * @param mixed $rbacManager
     * @param mixed $translator
     */
    public function __construct($authService, $urlHelper, $rbacManager, $translator)
    {
        $this->authService = $authService;
        $this->urlHelper = $urlHelper;
        $this->rbacManager = $rbacManager;
        $this->translator = $translator;
    }

    /**
     * This method returns menu items depending on whether user has logged in or not.
     */
    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];

        

        // Display "Login" menu item for not authorized user only. On the other hand,
        // display "Admin" and "Logout" menu items only for authorized users.
        if (!$this->authService->hasIdentity()) {
            $items[] = [
                'id' => 'login',
                'label' => $this->translator->translate('Sign in'),
                'link' => $url('login'),
                'location' => 'usermenu',
            ];
        } else {
			
			if ($this->rbacManager->isGranted(null, 'dashboard.manage')) {
				$items[] = [
					'id' => 'dashboard',
					'label' => $this->translator->translate('Dashboard'),
					'link'  => $url('dashboard')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'contacts.manage')) {
				$items[] = [
					'id' => 'contacts',
					'label' => $this->translator->translate('Contacts'),
					'link'  => $url('contacts')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'spt.manage')) {
				$items[] = [
					'id' => 'spt',
					'label' => $this->translator->translate('SPT Form'),
					'link'  => $url('spt')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'dcr.manage')) {
				$items[] = [
					'id' => 'dcr',
					'label' => $this->translator->translate('DCR Form'),
					'link'  => $url('dcr')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'pipeline.manage')) {
				$items[] = [
					'id' => 'pipeline',
					'label' => $this->translator->translate('Leads Pipeline'),
					'link'  => $url('pipeline')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'roadmap.manage')) {
				$items[] = [
					'id' => 'roadmap',
					'label' => $this->translator->translate('Road Map'),
					'link'  => $url('roadmap')
				];
			}
			
			if ($this->rbacManager->isGranted(null, 'reports.manage')) {
				$items[] = [
					'id' => 'reports',
					'label' => $this->translator->translate('Reports'),
					'link'  => $url('reports')
				];
			}

            //Settings Menu
            $settingsMenu = [];

            if ($this->rbacManager->isGranted(null, 'user.manage')) {
                $settingsMenu[] = [
                    'id' => 'users',
                    'label' => $this->translator->translate('Manage Users'),
                    'link' => $url('users'),
                ];
            }

            if ($this->rbacManager->isGranted(null, 'permission.manage')) {
                $settingsMenu[] = [
                    'id' => 'permissions',
                    'label' => $this->translator->translate('Manage Permissions'),
                    'link' => $url('permissions'),
                ];
            }

            if ($this->rbacManager->isGranted(null, 'role.manage')) {
                $settingsMenu[] = [
                    'id' => 'roles',
                    'label' => $this->translator->translate('Manage Roles'),
                    'link' => $url('roles'),
                ];
            }

            if ($this->rbacManager->isGranted(null, 'targets.manage')) {
                
                $settingsMenu[] = [
                    'id' => 'manage_targets',
                    'label' => $this->translator->translate('Manage Targets'),
                    'link' => $url('targets'),
                ];
            }
			
			if ($this->rbacManager->isGranted(null, 'settings.manage')) {
                
                $settingsMenu[] = [
                    'id' => 'manage_settings',
                    'label' => $this->translator->translate('Manage Settings'),
                    'link' => $url('settings'),
                ];
                
                $settingsMenu[] = [
                    'id' => 'logs',
                    'label' => $this->translator->translate('System Logs'),
                    'link' => $url('logs'),
                ];
            }

            if (0 != count($settingsMenu)) {
                $items[] = [
                    'id' => 'settings',
                    'label' => $this->translator->translate('Settings'),
                    'dropdown' => $settingsMenu,
                ];
            }

            //Masters Menu
            $masterDropdownItems = [];

            if ($this->rbacManager->isGranted(null, 'masters.manage')) {

                $masterDropdownItems[] = [
                    'id' => 'system-usertype',
                    'label' => $this->translator->translate('System UserType'),
                    'link' => $url('system-usertype'),
                ];
				
				$masterDropdownItems[] = [
                    'id' => 'contacted-type',
                    'label' => $this->translator->translate('Contacted Types'),
                    'link' => $url('contacted-type'),
                ];
				
				$masterDropdownItems[] = [
                    'id' => 'branch',
                    'label' => $this->translator->translate('Branch'),
                    'link' => $url('branch'),
                ];
				
				$masterDropdownItems[] = [
                    'id' => 'call-type',
                    'label' => $this->translator->translate('Call Types'),
                    'link' => $url('call-type'),
                ];

				$masterDropdownItems[] = [
					'id' => 'lead-source',
					'label' => $this->translator->translate('Lead Sources'),
					'link' => $url('lead-source'),
				];
				
				$masterDropdownItems[] = [
					'id' => 'lead-stage',
					'label' => $this->translator->translate('Lead Stages'),
					'link' => $url('lead-stage'),
				];
				$masterDropdownItems[] = [
					'id' => 'market-segment',
					'label' => $this->translator->translate('Market Segments'),
					'link' => $url('market-segment'),
				];
				$masterDropdownItems[] = [
					'id' => 'next-action',
					'label' => $this->translator->translate('Next Action'),
					'link' => $url('next-action'),
				];
				$masterDropdownItems[] = [
					'id' => 'probability',
					'label' => $this->translator->translate('Probability'),
					'link' => $url('probability'),
				];
				$masterDropdownItems[] = [
					'id' => 'products',
					'label' => $this->translator->translate('Products'),
					'link' => $url('products'),
				];
				$masterDropdownItems[] = [
					'id' => 'product-models',
					'label' => $this->translator->translate('Product Models'),
					'link' => $url('product-models'),
				];
				$masterDropdownItems[] = [
                    'id' => 'product-series',
                    'label' => $this->translator->translate('Product Series'),
                    'link' => $url('product-series'),
                ];
				$masterDropdownItems[] = [
					'id' => 'sales-stage',
					'label' => $this->translator->translate('Sales Stage'),
					'link' => $url('sales-stage'),
				];
				$masterDropdownItems[] = [
					'id' => 'travel-mode',
					'label' => $this->translator->translate('Travel Mode'),
					'link' => $url('travel-mode'),
				];
				$masterDropdownItems[] = [
					'id' => 'travel-type',
					'label' => $this->translator->translate('Travel Type'),
					'link' => $url('travel-type'),
				];

            }

            if (0 != count($masterDropdownItems)) {
                $items[] = [
                    'id' => 'masters',
                    'label' => $this->translator->translate('Masters'),
                    'dropdown' => $masterDropdownItems,
                ];
            }

        }

        return $items;
    }
}
