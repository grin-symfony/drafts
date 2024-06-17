<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendEmailHandler
{
    public function __invoke(SendEmail $message): void
    {
        \dump('Sending email to "' . $message->getTo() . '"' . \PHP_EOL . $message);
    }
}
