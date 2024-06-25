<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Contract\Some\SomeServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Contracts\Service\Attribute\Required;

//#[AsAlias]
class SomeService implements SomeServiceInterface
{
    public function __construct(
		public $v = null,
		public $a = null,
	) {
		\dump(__METHOD__);
	}
	
	#[Required]
    public function setRequired(
		$v = 11,
	): static {
		\dump(__METHOD__);
		$n = clone $this;
		
		$n->v = $v;
		
		return $n;
	}
	
    public function __invoke() {
		\dump(\get_debug_type($this->v));
	}
	
    public function getGenerator(...$args): \Generator
    {
        yield ['data' => $args];
    }
}
