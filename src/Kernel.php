<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use App\DependencyInjection\Compiler\CustomPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\CompillerPass\AppDtoTagPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use App\Extension\Test\ExtensionExample;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;
	
	public function __construct(
        string $environment,
        bool $debug,
    ) {
        parent::__construct($environment, $debug);
    }
	
	protected function build(ContainerBuilder $containerBuilder): void {
		//$containerBuilder->addCompilerPass(new AppDtoTagPass);
		$containerBuilder->registerExtension($e = new ExtensionExample);
		//$containerBuilder->loadFromExtension($e->getAlias());
	}
	
	public function process(ContainerBuilder $container): void {
		$serviceId = 'App\Service\SomeService';
		
		$d = $container->findDefinition($serviceId);
		$d
			//->setProperty('age', null)
		;
		
		/*
		\dd(
			$d,
			$d->getMethodCalls($serviceId),
			$container->hasDefinition($serviceId),
			$container->has($alias = $serviceId),
			//$container->getDefinition($serviceId),
			$container->findDefinition($alias = $serviceId),
		);
		*/
	}
}
