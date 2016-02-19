<?php

namespace T4web\EventSubscriber;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class SubscriberFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Subscriber
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Subscriber($serviceLocator);
    }
}
