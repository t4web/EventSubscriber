<?php

namespace T4web\EventSubscriberTest;

use Zend\ServiceManager\ServiceLocatorInterface;
use T4web\EventSubscriber\Subscriber;
use T4web\EventSubscriber\SubscriberFactory;

class PhpArrayFactoryTest extends \PHPUnit_Framework_TestCase
{
    private $serviceLocator;

    public function setUp()
    {
        $this->serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
    }

    public function testAuthenticate()
    {
        $factory = new SubscriberFactory();

        $adapter = $factory->createService($this->serviceLocator->reveal());

        $this->assertTrue($adapter instanceof Subscriber);
    }
}
