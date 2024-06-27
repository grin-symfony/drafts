<?php

namespace App\Extension\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunction;

class ExpressionLanguageFunctionProvider implements ExpressionFunctionProviderInterface {
	
	private array $store = [];
	
	public function getFunctions(): array {
		return [
			new ExpressionFunction(
				'strtolower',
				// don't care about compile method
				function($values, $funcArg) {
					return \sprintf('strtolower(%1$s)', $funcArg);
				},
				// only evaluate
				function($values, $funcArg) {
					$this->onEvaluateFunctionStartClearStore();
					return $this->strtolower($funcArg);
				},
			),
		];
	}
	
	
	//###> FUNCTIONS ###
	
	private function strtolower($funcArg): mixed {
		if (\is_array($funcArg)) {
			foreach($funcArg as $arg) {
				$this->store[] = $this->strtolower($arg);				
			}
			return $this->store;
		}
		
		try {
			$funcArg = (string) $funcArg;
		} catch (\Exception $e) {
		}
		
		if (\is_string($funcArg)) {
			return \strtolower($funcArg);
		}
		
		return $funcArg;
	}
	
	//###< FUNCTIONS ###
	
	private function onEvaluateFunctionStartClearStore(): void {
		$this->store = [];
	}
}