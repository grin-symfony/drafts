<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class NotifierHandlers
{
	#[AsMessageHandler]
    public function sendEmailHandler(SendEmail $message): void
    {
        \dump('Sending email to "' . $message->getTo() . '"' . \PHP_EOL . $message);
    }
}
