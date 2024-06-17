<?php

namespace GS\GenericParts\Exception;

use GS\GenericParts\Contracts\AbstractGSException;
use Symfony\Component\HttpFoundation\{
    Response
};

class GSCarbonInvalidTimezone extends AbstractGSException
{
    public const MESSAGE        = 'exception.carbon_invalid_timezone';
    public const HTTP_CODE      = Response::HTTP_BAD_REQUEST;
}
