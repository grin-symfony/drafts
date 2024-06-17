<?php

namespace App\ValueResolver;

use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\HttpKernel\Attribute\AsTargetedValueResolver;

class CarbonValueResolver implements ValueResolverInterface
{
    public function resolve(
        Request $request,
        ArgumentMetadata $argument
    ): array {
        if ($argument->getName() != 'now') {
            return [];
        }
        if (
            $argument->getType() != Carbon::class
            && !\is_subclass_of($argument->getType(), Carbon::class, true)
        ) {
            return [];
        }

        $now = Carbon::now();

        return [$now];
    }
}
