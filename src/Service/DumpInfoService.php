<?php

namespace App\Service;

use GS\Service\Service\DumpInfoService as GSDumpInfoService;
use Symfony\Contracts\Translation\TranslatorInterface;

class DumpInfoService extends GSDumpInfoService
{
    public function __construct(
        StringService $stringService,
        TranslatorInterface $gsServiceT,
        ConfigService $configService,
    ) {
        parent::__construct(
            stringService: $stringService,
            gsServiceT: $gsServiceT,
            configService: $configService,
        );
    }
}
