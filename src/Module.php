<?php

namespace T4web\EventSubscriber;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\EventManager\EventInterface;

class Module implements
    ConfigProviderInterface,
    BootstrapListenerInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $serviceManager  = $e->getApplication()->getServiceManager();
        $config = $serviceManager->get('Config');

        if (!isset($config['events']) || empty($config['events'])) {
            return;
        }

        /** @var Subscriber $subscriber */
        $subscriber = $serviceManager->get(Subscriber::class);
        $subscriber($config['events']);
    }

    public function getConfig($env = null)
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }
}
