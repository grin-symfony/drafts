<?php

namespace App\Service;

use GS\Service\Service\DoctrineService as GSDoctrineService;
use Symfony\Contracts\Translation\TranslatorInterface;

class DoctrineService extends GSDoctrineService
{
    public function __construct(
        TranslatorInterface $t,
    ) {
        parent::__construct(
            t: $t,
        );
    }
}
