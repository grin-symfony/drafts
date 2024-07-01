<?php

namespace App\EventListener\Kernel\SubRequest;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

abstract class AbstractEventListener {
	public function onKernelException(ExceptionEvent $event) {
		if ($event->isMainRequest()) return;
		$this->doOnKernelException($event);
	}
	
	abstract protected function doOnKernelException(ExceptionEvent $event): void;
}