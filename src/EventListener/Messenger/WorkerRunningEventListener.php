<?php

namespace App\EventListener\Messenger;

use Symfony\Component\Messenger\Event\WorkerRunningEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[AsEventListener(
	event: WorkerRunningEvent::class,
	method: '__invoke',
)]
class WorkerRunningEventListener {
	
	public function __invoke(
		WorkerRunningEvent $event,
		string $eventClassName,
		EventDispatcherInterface $dispatcher,
	) {
		//\dump($event->getWorker()->getMetadata());
	}
	
}