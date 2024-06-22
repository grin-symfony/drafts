<?php

namespace App\EventListener\Messenger;

use Symfony\Component\Messenger\Event\WorkerMessageReceivedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsEventListener(
    event: WorkerMessageReceivedEvent::class,
    method: '__invoke',
)]
class WorkerMessageReceivedEventListener
{
    public function __invoke(
        WorkerMessageReceivedEvent $event,
        string $eventClassName,
        EventDispatcherInterface $dispatcher,
    ) {
        \dump(__CLASS__);
    }
}
