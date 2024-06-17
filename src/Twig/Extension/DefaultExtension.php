<?php

namespace GS\GenericParts\Twig\Extension;

use GS\GenericParts\Contracts\{
    GSIsoFormat
};
use GS\GenericParts\Service\{
    GSCarbonService,
    GSBufferService,
    GSHtmlService
};
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\{
    Response,
    JsonResponse,
    Request
};
use Twig\Extension\AbstractExtension;

class DefaultExtension extends AbstractExtension
{
    public function __construct(
        private $faker,
        private $carFacImm,
        private FormFactoryInterface $formFactory,
    ) {
    }

    //###> FILTERS ###

    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('gs_trim',						$this->trim(...)),
            new \Twig\TwigFilter('gs_for_user',					$this->forUser(...)),
            new \Twig\TwigFilter('gs_array_to_attribute',		$this->arrayToAttribute(...), ['is_safe' => ['html']]),
            new \Twig\TwigFilter('gs_binary_img',				$this->binary_img(...)),
			/* Usage:	<>|gs_local_money(app.request.locale) */
            new \Twig\TwigFilter('gs_local_money',				$this->localMoney(...)),
        ];
    }

    public function localMoney(string|int|float $input, string $locale): string|int|float {
		$output	= $input;
		
		$try	= (new \NumberFormatter($locale, \NumberFormatter::DEFAULT_STYLE))->format((float) $input);
		if ($try !== false) $output = $try;
		
		return $output;
	}
	
    public function trim(mixed $input, ?string $string = null)
    {
        return ($string !== null) ? \trim($input, $string) : \trim($input);
    }

    public function forUser(
        \DateTime|\DateTimeImmutable $data,
        ?string $tz = null,
        ?string $locale = null,
        \DateTime|\DateTimeImmutable $sourceOfMeta = null,
        ?GSIsoFormat $isoFormat = null,
        ?Request $request = null,
    ): string {
        $carbon         = $this->carFacImm->make($data)->toMutable();

        $carbon = GSCarbonService::forUser(
            origin:             $carbon,
            sourceOfMeta:       $sourceOfMeta,
            tz:                 $tz,
            locale:             $request?->attributes?->get('_locale'),
        );

        return GSCarbonService::isoFormat($carbon, $isoFormat);
    }
	
	/* Usage:
		{{- attr|gs_array_to_attribute -}}
	*/
    public function arrayToAttribute(
        array $input,
    ): string {
        \array_walk($input, static fn(&$v, $k) => $v = ( (string) $k ) . '="' . ( \is_bool($v) ? ( $v ? 'true' : 'false' ) : $v ) . '"');
        $outputString			= \implode(' ', $input);
		//if ($outputString != '') \dd($outputString);
		return $outputString;
    }

    public function binary_img(string $input)
    {
        return GSHtmlService::getImgHtmlByBinary($input);
    }

    //###< FILTERS ###

    //###> TESTS ###

    public function getTests()
    {
        return [
        ];
    }

    //###< TESTS ###

    //###> FUNCTIONS ###

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('gs_dump_array', $this->dumpArray(...)),
            new \Twig\TwigFunction('gs_lorem', $this->lorem(...)),
            new \Twig\TwigFunction('gs_create_form', $this->createForm(...)),
            new \Twig\TwigFunction('gs_time', \time(...)),
            new \Twig\TwigFunction('gs_microtime', $this->microtime(...)),
            new \Twig\TwigFunction('gs_echo', $this->echo(...)),
            new \Twig\TwigFunction('gs_clear_output_buffer', $this->clearOutputBuffer(...)),
        ];
    }

    public function clearOutputBuffer(): void
    {
        GSBufferService::clear();
    }


    public function dumpArray($input)
    {
        \array_walk($input, static function ($v, $k) {
            echo \nl2br($k . ' => ' . $v . \PHP_EOL . \PHP_EOL);
        });
    }

    public function echo($string)
    {
        echo($string);
    }

    public function microtime()
    {
        $offset = 2;
        $microtime = \microtime();
        return \substr($microtime, $offset, \strpos($microtime, ' ') - ($offset + 1));
    }

    public function createForm(string $type, object $entity = null, array $options = [])
    {
        return $this->formFactory->create($type, $entity, $options)->createView();
    }

    public function lorem(
        int $quantity = 1000,
    ): string {
        return $this->faker->realText($quantity);
    }

    //###< FUNCTIONS ###

    public function getTokenParsers()
    {
        return [];
    }

    public function getNodeVisitors()
    {
        return [];
    }

    public function getOperators()
    {
        return [];
    }

    public static function getPriority(): int
    {
        return -3;
    }

    public static function getDefaultIndexName(): int|string
    {
        return self::class;
    }
}
