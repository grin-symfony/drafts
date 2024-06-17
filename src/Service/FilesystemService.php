<?php

namespace App\Service;

use GS\Service\Service\FilesystemService as GSFilesystemService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\String\Slugger\SluggerInterface;

class FilesystemService extends GSFilesystemService
{
    public function __construct(
        DumpInfoService $dumpInfoService,
        StringService $stringService,
        SluggerInterface $slugger,
        #[Autowire(param: 'gs_service.local_drive_for_test')]
        string $gsServiceLocalDriveForTest,
        #[Autowire(param: 'gs_service.app_env')]
        string $gsServiceAppEnv,
        #[Autowire(service: 'gs_service.carbon_factory_immutable')]
        $gsServiceCarbonFactoryImmutable,
    ) {
        parent::__construct(
            dumpInfoService: $dumpInfoService,
            stringService: $stringService,
            slugger: $slugger,
            gsServiceLocalDriveForTest: $gsServiceLocalDriveForTest,
            gsServiceAppEnv: $gsServiceAppEnv,
            gsServiceCarbonFactoryImmutable: $gsServiceCarbonFactoryImmutable,
        );
    }
}
