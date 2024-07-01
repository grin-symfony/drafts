<?php

namespace App\EventListener\Kernel;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestEventListener
{
    public function __invoke(
        RequestEvent $event,
    ): void {
        return;
		
		$isMainRequest = $event->isMainRequest();
		$request = $event->getRequest();
		$requestType = $event->getRequestType();
		$kernel = $event->getKernel();
		
		\dump($isMainRequest, $requestType, get_debug_type($kernel), get_debug_type($request));
    }
}
