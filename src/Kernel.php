<?php

namespace App;

use App\Type\Hash\HashType;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use App\Attribute\NewClosureDefinitionWithTag;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use App\DependencyInjection\Compiler\CustomPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use App\CompillerPass\AppDtoTagPass;
use App\CompillerPass\NewClosureDefinitionWithTagPass;
use App\CompillerPass\MessengerManagerPass;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use App\Extension\Test\ExtensionExample;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ChildDefinition;

class Kernel extends BaseKernel implements CompilerPassInterface
{
    use MicroKernelTrait;
	
	public function __construct(
        string $environment,
        bool $debug,
    ) {
        parent::__construct($environment, $debug);
    }
	
	protected function build(ContainerBuilder $container): void {
		$container->registerExtension($e = new ExtensionExample);
		$container->loadFromExtension($e->getAlias());
		$container->addCompilerPass(new AppDtoTagPass);
		//$container->addCompilerPass(new MessengerManagerPass);
		
		
		//TODO (NewClosureDefinitionWithTagPass)
		//processes the tag
		$container->addCompilerPass(new NewClosureDefinitionWithTagPass(
			new NewClosureDefinitionWithTag(HashType::TAG),
			new NewClosureDefinitionWithTag('app.pretty_message'),
		));
		
		//TODO (NewClosureDefinitionWithTagPass)
		//sets tag for us, by Attribute
		$container->registerAttributeForAutoconfiguration(
			NewClosureDefinitionWithTag::class,
			static function(
				ChildDefinition $d,
				NewClosureDefinitionWithTag $attr,
				\ReflectionClass|\ReflectionMethod $refl,
			) {
				$isInvokeable = false;
				$method = null;
				if ($refl instanceof \ReflectionClass) {
					$isInvokeable = $refl->hasMethod('__invoke');
				}
				if ($refl instanceof \ReflectionMethod) {
					$isInvokeable = $refl->getDeclaringClass()->hasMethod('__invoke');
					$method = $refl->getName();
				}
				$tagAttributes = \array_filter(\array_merge(
					[
						'method' => $method,
					],
					\array_filter((array) $attr, static fn($e) => !\is_null($e)),
					[
						'is_invokeable' => $isInvokeable,
					],
				), static fn($e) => !\is_null($e));
				$d->addTag($attr->tag, $tagAttributes);
			},
		);
	}
	
	public function process(ContainerBuilder $container): void {
		$serviceId = 'App\Service\SomeService';
		
		$d = $container->findDefinition($serviceId);
		
		/*
		$d
			->setArgument('$service', new Reference('App\Service\SomeService2'))
		;
		*/
		
		/*
		\dd(
			ServiceLocatorTagPass::register($container, ['logger' => new Reference('Psr\Log\LoggerInterface $messengerEmailLogger')])
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
