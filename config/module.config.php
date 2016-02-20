<?php

namespace T4web\EventSubscriber;

return [
    'service_manager' => [
        'factories' => [
            Subscriber::class => SubscriberFactory::class
        ],
    ],
];
