<?php

namespace GS\GenericParts\Service;

class GSRandomPassword
{
    public static function get(
		int $len = 10,
	): string {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = [];
		$alphaLength = \strlen($alphabet) - 1;
		for ($i = 0; $i < $len; $i++) {
			$n = \rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return \implode($pass);
    }
}
