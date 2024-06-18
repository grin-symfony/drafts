<?php

namespace App\Messenger\Notifier;

class ToAdminSendEmail extends SendEmail
{
    public function __construct(
        string $toEmail,
        string $title = '',
        string $body = '',
        string $bottom = '',
    ) {
		parent::__construct(
			toEmail: $toEmail,
			title: $title,
			body: $body,
			bottom: $bottom,
		);
    }
}
