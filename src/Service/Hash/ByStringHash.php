<?php

namespace App\Service\Hash;

use App\Attribute\Hash\HashGetter;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[HashGetter('by_string', method: 'myMethod')]
class ByStringHash {
	public function myMethod(string $string): string {
		return md5($string);
	}
}