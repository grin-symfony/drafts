<?php

namespace App\Service;

use GS\Service\Service\StringService as GSStringService;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use GS\Service\Service\ArrayService;
use GS\Service\Service\CarbonService;
use GS\Service\Service\BoolService;
use GS\Service\Service\RegexService;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

//#[When(env: 'dev')]
//#[AsAlias(StringService::class)]
class StringService extends GSStringService
{
	public function __construct(
        ArrayService $arrayService,
        CarbonService $carbonService,
        BoolService $boolService,
        RegexService $regexService,
		#[Autowire(param: 'gs_service.year_regex')]
        string $gsServiceYearRegex,
		#[Autowire(param: 'gs_service.year_regex_full')]
        string $gsServiceYearRegexFull,
		#[Autowire(param: 'gs_service.ip_v4_regex')]
        string $gsServiceIpV4Regex,
		#[Autowire(param: 'gs_service.slash_of_ip_regex')]
        string $gsServiceSlashOfIpRegex,
		//
		$v = null,
    ) {
		parent::__construct(
			arrayService: $arrayService,
			carbonService: $carbonService,
			boolService: $boolService,
			regexService: $regexService,
			gsServiceYearRegex: $gsServiceYearRegex,
			gsServiceYearRegexFull: $gsServiceYearRegexFull,
			gsServiceIpV4Regex: $gsServiceIpV4Regex,
			gsServiceSlashOfIpRegex: $gsServiceSlashOfIpRegex,
		);
		
		\dump($v);
    }
}
