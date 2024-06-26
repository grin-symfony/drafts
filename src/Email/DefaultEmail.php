<?php

namespace App\Email;

use App\Contract\Email\EmailInterface;
use App\Contract\Email\EmailFormatInterface;
use App\Type\Email\EmailType;

class DefaultEmail implements EmailInterface {
	
	protected ?string $format;
	
	public function __construct() {
		$this->format = null;
	}
	
	public function setFormat(EmailFormatInterface $emailFormat): static {
		
		$this->format = $emailFormat($this);
		
		return $this;
	}
}