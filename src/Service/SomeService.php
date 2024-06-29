<?php

namespace App\Service;

use App\Contract\Some\SomeServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Lazy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedLocator;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Psr\Container\ContainerInterface;

class SomeService extends AbstractStringService
{
	use \App\Trait\RequireEntityManager;
	
	private ?EntityManagerInterface $em = null;
	
	public function __construct(
		#[TaggedIterator('app.command_bus_handler')]
		//private readonly ServiceLocator $service,
		private $service,
	) {
	}
	
	function &getEntityManagerRef(): ?EntityManagerInterface {
		return $this->em;
	}
	
	// uncomment to deny #[Required]
	//public function requireEntityManager() {}
	
    public static function create(): static {
		\dump(__METHOD__);
		return new static;
	}
	
    public function publicMethod(): void {
		\dump(__METHOD__);
	}
	
    public function __invoke() {
		\dump(\get_debug_type($this->v));
	}
	
    public function getGenerator(...$args): \Generator
    {
        yield ['data' => $args];
    }
}
