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

        foreach($events as $eventId => $event) {
            foreach($event as $name => $callbacks) {
                foreach($callbacks as $callback) {

                    $sem->attach($eventId, $name, function(EventInterface $e) use ($callback) {
                        $handler = $this->serviceLocator->get($callback);

                        if (!is_callable($handler)) {
                            throw new InvalidCallbackException("Callback $callback if not callable");
                        }

                        $handler($e);
                    });
                }
            }
        }
    }
}