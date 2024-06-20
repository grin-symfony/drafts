<?php

namespace App\Service;

use GS\Service\Service\OSService as GSOSService;
use Symfony\Contracts\Service\ResetInterface;

class OSService extends GSOSService implements ResetInterface
{
	public function reset() {}
}
