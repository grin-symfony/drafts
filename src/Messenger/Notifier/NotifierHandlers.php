<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\StopWorkerException;

class NotifierHandlers
{
	#[AsMessageHandler]
    public function sendEmailHandler(SendEmail $message): void
    {
		//throw new StopWorkerException('Worker stop command');
		\dump('Sending email to "' . $message->getTo() . '"' . \PHP_EOL . $message);
    }
}
