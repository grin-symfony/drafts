<?php

namespace App\Service;

use App\Contract\Some\SomeServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Lazy;
use Doctrine\ORM\EntityManagerInterface;

//#[AsAlias]
#[Lazy]
class SomeService implements SomeServiceInterface
{
	use \App\Trait\RequireEntityManager;
	
	private ?EntityManagerInterface $em = null;
	
	function &getEntityManagerRef(): ?EntityManagerInterface {
		return $this->em;
	}
	
	// uncomment to deny #[Required]
	//public function requireEntityManager() {}
	
    public function __construct(
		public $v = null,
		public $a = null,
	) {
		\dump(__METHOD__);
	}
	
    public static function create(): static {
		\dump(__METHOD__);
		return new static;
	}
	
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
