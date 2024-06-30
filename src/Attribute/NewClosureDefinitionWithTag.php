<?php

namespace App\Attribute;

//TODO (NewClosureDefinitionWithTagPass)
#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class NewClosureDefinitionWithTag {
	
	/**
	* NewClosureDefinitionWithTagPass reads only @tag parameter
	*/
	public function __construct(
		public readonly string $tag,
		public readonly ?string $index = null,
		public readonly ?string $method = null,
	) {}
	
	public function __sleep(): array {
		return [
			'tag' => $this->tag,
			'index' => $this->index,
			'method' => $this->method,
		];
	}
}