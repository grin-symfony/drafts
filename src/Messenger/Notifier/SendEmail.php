<?php

namespace App\Messenger\Notifier;

class SendEmail
{
    public function __construct(
        public readonly string $toEmail,
        public readonly string $title,
        public readonly string $body,
        public readonly string $bottom = '',
    ) {
    }

    /* Alias */
    public function getTo(): string
    {
        return $this->getToEmail();
    }

    public function getToEmail(): string
    {
        return $this->toEmail;
    }

    /* Alias */
    public function __invoke(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return $this->title . ': "' . $this->body . '"' . \PHP_EOL . $this->bottom;
    }
}
