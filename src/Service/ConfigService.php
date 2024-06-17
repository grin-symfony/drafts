<?php

namespace App\Service;

use GS\Service\Service\ConfigService as GSConfigService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class ConfigService extends GSConfigService
{
    public function __construct(
        BoolService $boolService,
        StringService $stringService,
        #[Autowire(param: 'kernel.project_dir')]
        string $gsServiceProjectDir,
        #[Autowire(param: 'gs_service.load_packs_configs')]
        array $gsServicePackageFilenames,
        #[Autowire(service: 'Symfony\Contracts\Translation\TranslatorInterface')]
        $gsServiceT,
    ) {
        parent::__construct(
            boolService: $boolService,
            stringService: $stringService,
            gsServiceProjectDir: $gsServiceProjectDir,
            gsServicePackageFilenames: $gsServicePackageFilenames,
            gsServiceT: $gsServiceT,
        );
    }


    //###> ABSTRACT REALIZATION ###

    protected function configureConfigOptions(
        string $uniqPackId,
        OptionsResolver $resolver,
        array $inputData,
    ): void {

        /*
        if ($this->getUniqPackId('', 'config/packages') == $uniqPackId) {
            return;
        }
        */

        parent::configureConfigOptions($uniqPackId, $resolver, $inputData);
    }

    //###< ABSTRACT REALIZATION ###


    //###> HELPER ###

    //###< HELPER ###
}
