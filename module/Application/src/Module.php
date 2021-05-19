<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }
	
    /**
     * This method is called once the MVC bootstrapping is complete.
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();

        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one to avoid passing the
        // session manager as a dependency to other models.

        $sessionManager = $serviceManager->get(SessionManager::class);

        $eventManager = $application->getEventManager();
        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_DISPATCH, array($this, 'onDispatchError'), -100);
        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), -100);
        $eventManager->getSharedManager()->attach('*', MvcEvent::EVENT_RENDER_ERROR, array(
        $this,
        'onDispatchError'
        ), - 100);

        //Invalid Session Error Resolver
        $this->forgetInvalidSession($sessionManager);

        // Setup json strategy
        $strategy = $serviceManager->get('ViewJsonStrategy');
        $view = $serviceManager->get('ViewManager')->getView();
        $strategy->attach($view->getEventManager(), 100);
    }

    public function onDispatchError(MvcEvent $event)
    {
        $response = $event->getResponse();
		// $vm = $event->getViewModel();
		// $vm->setTemplate('error/index');
        // if (404 == $response->getStatusCode()) {
            // $vm = $event->getViewModel();
            // $vm->setTemplate('error/404');
        // } elseif (500 == $response->getStatusCode()) {
            // $vm = $event->getViewModel();
            // $vm->setTemplate('error/500');
        // }
    }

    protected function forgetInvalidSession($sessionManager)
    {
        try {
            $sessionManager->start();

            return;
        } catch (\Exception $e) {
        }
        // Session validation failed: toast it and carry on.
        // @codeCoverageIgnoreStart
        session_unset();
        // @codeCoverageIgnoreEnd
    }
}
