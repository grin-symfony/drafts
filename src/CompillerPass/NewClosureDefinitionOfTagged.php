<?php

namespace App\CompillerPass;

use App\Attribute\Hash\HashGetter;
use App\Type\Hash\HashType;
use App\Messenger\MessengerManager;
use Symfony\Component\DependencyInjection\Reference;
use function Symfony\component\string\u;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use App\Extractor\DefaultValueExtractor;
use Symfony\Component\DependencyInjection\Argument\ServiceClosureArgument;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Alias;

class NewClosureDefinitionOfTagged extends AbstractCompillerPass {
	
	/**
	* Service that uses this @tag leaves without this @tag
	* But a new \Closure Definition creates with this tag
	* and references to the method of the origin service.
	* 
	* Optional:
	* You can use @indexOf argument if you use !tagged_locator or !tagged_iterator for @tag
	*/
	public function __construct(
		public readonly string $tag,
		public readonly ?string $indexOf = null,
	) {}
	
	public function process(ContainerBuilder $container): void {
		
		$ids = $container->findTaggedServiceIds($this->tag);
		
		foreach($ids as $id => $originTagAttributes) {
			$originDefinition = $container->findDefinition($id);
			if (null === $originDefinition) continue;
			
			$originClass = $originDefinition->getClass();
			$originDefinition->clearTag($this->tag);
			
			$method = self::getFirstTagAttribute('method', $originTagAttributes);
			$isInvokeable = self::getFirstTagAttribute('is_invokeable', $originTagAttributes);
			$method ??= '__invoke';
			
			if('__invoke' === $method && !$isInvokeable) {
				throw new \Exception(
					\sprintf(
						'The class: "%s" must have "%s" method, or pass "%s" argument to the "%s" attribute',
						$originClass,
						$method,
						'method',
						HashGetter::class,
					),
				);
			}
			$callableMethodOfService = [new Reference($originClass), $method];
			
			$clearTagAttributes = [];
			$class = 'Closure';
			$factory = 'Closure::fromCallable';
			if (null !== $this->indexOf) {
				$indexOf = self::getFirstTagAttribute($this->indexOf, $originTagAttributes);	
				$clearTagAttributes[$this->indexOf] = $indexOf;				
			}
			$tags = [
				$this->tag => [
					$clearTagAttributes,
				],
			];
			$arguments = [
				$callableMethodOfService,
			];
			$newDefinition = (new Definition($class))
				->setFactory($factory)
				->setArguments($arguments)
				->setTags($tags)
			;
			//\dd($newDefinition);
			$newDefinitionId = \strtolower($class).'.'.$originClass.'::'.$method;
			$container->setDefinition($newDefinitionId, $newDefinition);
		}	
	}
	
	//###> HELPER ###
	
}