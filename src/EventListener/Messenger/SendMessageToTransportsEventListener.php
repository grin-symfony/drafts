<?php

namespace App\EventListener\Messenger;

use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsEventListener(
    event: SendMessageToTransportsEvent::class,
    method: '__invoke',
)]
class SendMessageToTransportsEventListener
{
    public function __invoke(
        SendMessageToTransportsEvent $event,
        string $eventClassName,
        EventDispatcherInterface $dispatcher,
    ) {
        \dump(__CLASS__);
    }
}
