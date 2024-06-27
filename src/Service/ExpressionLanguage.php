<?php

namespace App\Service;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;
use App\Extension\ExpressionLanguage\ExpressionLanguageFunctionProvider;

class ExpressionLanguage extends BaseExpressionLanguage
{
    public function __construct(?CacheItemPoolInterface $cache = null, array $providers = [])
    {
        // prepends the default provider to let users override it
        \array_unshift($providers, new ExpressionLanguageFunctionProvider);

        parent::__construct($cache, $providers);
    }

}
