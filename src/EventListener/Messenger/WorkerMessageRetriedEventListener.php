<?php

namespace App\EventListener\Messenger;

use Symfony\Component\Messenger\Event\WorkerMessageRetriedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsEventListener(
    event: WorkerMessageRetriedEvent::class,
    method: '__invoke',
)]
class WorkerMessageRetriedEventListener
{
    public function __invoke(
        WorkerMessageRetriedEvent $event,
        string $eventClassName,
        EventDispatcherInterface $dispatcher,
    ) {
        \dump(__CLASS__);
    }
}
