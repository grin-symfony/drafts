<?php

namespace App\Service;

use App\Contract\Some\SomeServiceInterface;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

//#[AsAlias]
class SomeService2 implements SomeServiceInterface
{
    public function __invoke() {
		\dump(__METHOD__);
	}
	
    public static function getGenerator(): \Generator
    {
        yield ['data' => 0];
        yield ['data' => 1];
        yield ['data' => 2];
    }
}
