<?php

namespace App\Attribute\Hash;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class HashGetter {
	public function __construct(
		public readonly ?string $index = null,
		public readonly ?string $method = null,
	) {}
	
	public function __sleep(): array {
		return [
			'index' => $this->index,
			'method' => $this->method,
		];
	}
}