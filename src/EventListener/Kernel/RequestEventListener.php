<?php

namespace App\EventListener\Kernel;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsEventListener(event: 'kernel.request')]
class RequestEventListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function onKernelRequest(
        RequestEvent $event,
    ): void {
        \ob_start();
    }
}
