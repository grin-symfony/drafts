<?php

namespace App\Service\Message\PrettyMessage;

use App\Attribute\NewClosureDefinitionWithTag;

#[NewClosureDefinitionWithTag('app.pretty_message')]
class ForManPrettyMessage {
	public function __invoke(): string {
		return 'hey_girl';
	}
}