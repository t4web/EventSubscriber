<?php

namespace T4web\EventSubscriber;

return [
    'service_manager' => array(
        'factories' => array(
            Subscriber::class => SubscriberFactory::class
        ),
    ),
];
