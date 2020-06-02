<?php

namespace Codeception\PHPUnit;

use Symfony\Component\EventDispatcher\Event as ComponentEvent;
use Symfony\Contracts\EventDispatcher\Event as ContractEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Debug\TraceableEventDispatcherInterface;

trait DispatcherWrapper
{
    /**
     * Compatibility wrapper for dispatcher change between Symfony 4 and 5
     * @param EventDispatcher $dispatcher
     * @param string $eventType
     * @param ComponentEvent|ContractEvent $eventObject
     */
    protected function dispatch(EventDispatcher $dispatcher, $eventType, $eventObject)
    {
        //TraceableEventDispatcherInterface was introduced in symfony/event-dispatcher 2.5 and removed in 5.0
        if (!interface_exists(TraceableEventDispatcherInterface::class)) {
            //Symfony 5
            $dispatcher->dispatch($eventObject, $eventType);
        } else {
            //Symfony 2,3 or 4
            $dispatcher->dispatch($eventType, $eventObject);
        }

    }
}
