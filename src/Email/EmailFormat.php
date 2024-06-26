<?php

namespace App\Email;

use App\Contract\Email\EmailInterface;
use App\Contract\Email\EmailFormatInterface;
use App\Type\Email\EmailType;

class EmailFormat implements EmailFormatInterface {
	
	public function __construct(
		private readonly EmailInterface $email,
	) {
		$this->format = null;
	}
	
	public function __invoke(): string {
		return match(true) {
			$this->email instanceof DefaultEmail => EmailType::DEFAULT,
			default => EmailType::DEFAULT,
		};
	}
}