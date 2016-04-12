<?php

namespace T4web\EventSubscriber;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventInterface;
use Zend\EventManager\Exception\InvalidCallbackException;

class Subscriber
{
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param array $events
     */
    public function __invoke(array $events)
    {
        /** @var EventManager $em */
        $em = $this->serviceLocator->get('EventManager');
        $sem = $em->getSharedManager();

        foreach ($events as $eventId => $event) {
            foreach ($event as $name => $callbacks) {
                foreach ($callbacks as $callback) {
                    $handlerName = $callback;
                    $priority = 1;
                    if (is_array($callback)) {
                        $handlerName = $callback['handler'];
                        $priority = $callback['priority'];
                    }

                    $sem->attach($eventId, $name, function (EventInterface $e) use ($handlerName) {
                        $handler = $this->serviceLocator->get($handlerName);

                        if (!is_callable($handler)) {
                            throw new InvalidCallbackException("Callback $handlerName if not callable");
                        }

                        return $handler($e);
                    }, $priority);
                }
            }
        }
    }
}
