# EventSubscriber

ZF2 Module. One place for manage application events.

# Problem

As usual your event handlers everywhere, and you (or team member) don't know what will be executed
when you see this code `$this->getEventManager()->trigger($event);`. You spend many time with 
`Crtl+F` in whole project.

# Solution

It just recommendation (or team rule) - describe all your handlers in one place in your 
`module.config.php`:

```php
    'events' => [
        'Zend\Mvc\Application' => [
            'render' => [
                SomeListenerOne::class,
            ],
        ],
        'Users\User\Infrastructure\Repository' => [
            'create' => [
                SomeListenerTwo::class,
                SomeListenerThree::class,
            ],
        ],
        'Users\User\Infrastructure\Repository' => [
            'status:change' => [
                CreateTimelineEntryListener::class,
                UserNotifyListener::class,
                ExpireUserTokensListener::class,
                AdminLogListener::class,
            ],
        ],
        
        // ...
        'EventIdentifier' => [
            'EventName' => [
                'Callback1',
                'Callback2',
                // ...
                'CallbackN',
            ],
        ],
    ],
```

`T4web\EventSubscriber` - read this config and attach every handler in described event.
