<?php

namespace App\EventListener\Kernel;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Contract\EventListener\KernelEventListenerInterface;

class ControllerArgumentsEventListener implements KernelEventListenerInterface
{
    public function __invoke(
        ControllerArgumentsEvent $event,
    ): void {
		//TODO: current
        $arguments = $event->getArguments();
        $namedArguments = $event->getNamedArguments();
        $attributes = $event->getAttributes();
		
		\dd($attributes);
		\dd($namedArguments);
		\dd($arguments);
		
		return;
		
		$isMainRequest = $event->isMainRequest();
		$request = $event->getRequest();
		$requestType = $event->getRequestType();
		$kernel = $event->getKernel();
		
		\dump($isMainRequest, $requestType, get_debug_type($kernel), get_debug_type($request));
    }
}
