<?php

namespace App\Service\Hash;

use App\Attribute\Hash\HashGetter;

class RandomHash {
	#[HashGetter('random')]
	public function dsklfjsdlf(): string {
		return md5(rand(0, 10_000));
	}
}