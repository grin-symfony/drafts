<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\StopWorkerException;
use App\Service\OSService;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;

class NotifierHandlers
{
	public function __construct(
		//private readonly OSService $osService,
	) {
		//$osService->setCallback('win', 'make'.\rand(0, 100), static fn($v) => $v);
	}

	#[AsMessageHandler]
    public function sendEmailHandler(SendEmail $message): void
    {
		//throw new RecoverableMessageHandlingException;
		throw new \Exception;
		//throw new UnrecoverableMessageHandlingException;
		//throw new StopWorkerException('Worker stop command');
		//$value = $this->osService('make', true, 11);
		\dump('Sending email to "' . $message->getTo() . '"' . \PHP_EOL . $message);
    }
}
