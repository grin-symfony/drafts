<?php

namespace App\EventListener\Kernel;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class ExceptionEventListener
{
    public function __construct(
        //private readonly RequestStack $requestStack,
    ) {
    }

    public function __invoke(
        ExceptionEvent $event,
    ): void {
        
		//\dd('LISTENER');
		//if (!$event instanceof ExceptionEvent) return;
		
		$throwable = $event->getThrowable();
		$code = $throwable->getCode();
		$message = $throwable->getMessage();
		$message = \sprintf(
			'There was an Exception "%s" with the code "%s"',
			$message,
			$code,
		);
		
		$r = new Response();
		$r->setContent($message);
		
		if ($throwable instanceof HttpExceptionInterface) {
			$r->setStatusCode($throwable->getStatusCode());
			$r->headers->replace($throwable->getHeaders());
		} else {
			$r->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
		}
		
		$event->setResponse($r);
    }
}
