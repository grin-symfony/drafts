<?php

namespace App\EventListener\Kernel\SubRequest;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionEventListener extends AbstractEventListener {
	protected function doOnKernelException(ExceptionEvent $event): void {
		
		$throwable = $event->getThrowable();
		
		$code = $throwable->getCode();
		$mess = $throwable->getMessage();
		$mess = \sprintf(
			'DURING A SUBREQUEST!!! %sThere was an Exception "%s" with the code "%s"',
			'<br>',
			$mess,
			$code,
		);
		$r = new Response();
		$r->setContent($mess);
		
		if ($throwable instanceof HttpExceptionInterface) {
			$r->setStatusCode($throwable->getStatusCode());
			$r->headers->replace($throwable->getHeaders());
		} else {
			$r->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		$event->setResponse($r);
	}
}