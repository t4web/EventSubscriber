<?php

namespace T4web\EventSubscriber;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventInterface;

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
            foreach($event as $name => $callback) {
                $sem->attach($eventId, $name, function(EventInterface $e) use ($callback) {
                    die(var_dump($callback, $this->serviceLocator->has($callback)));
                    $handler = $this->serviceLocator->get($callback);

                    if (!is_callable($handler)) {
                        throw new Exception("Callback $callback if not callable");
                    }

                    $handler($e);
                });
            }
        }
    }
}