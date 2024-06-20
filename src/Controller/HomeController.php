<?php

namespace App\Controller;

use function Symfony\component\string\u;

use Symfony\Component\Config\FileLocator;
use App\Type\Product\ProductType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Doctrine\Common\Collections\Criteria;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use App\Messenger\Test\TestMessage;
use App\Messenger\Test\TestMessageHandler;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Service\SomeService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpFoundation\IpUtils;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\HeaderUtils;
use App\Exception\E404;
use Symfony\Component\WebLink\Link;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use App\Dto\User\NullUserDto;
use App\Dto\User\UserDto;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\UriSigner;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Type\Shop\ShopType;
use App\Type\User\UserPlatformType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Requirement\EnumRequirement;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Attribute\MapDateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver;
use App\ValueResolver\CarbonValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\BackedEnumValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestPayloadValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\DateTimeValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\ServiceValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\UidValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver;
use App\Service\DoctrineService;
use App\Service\StringService;
use App\Attribute\TakePayload;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RequestMatcher\MethodRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\AttributesRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\ExpressionRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\HeaderRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\HostRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\IpsRequestMatcher;
use Symfony\Component\HttpFoundation\RequestMatcher\QueryParameterRequestMatcher;
use Symfony\Component\HttpFoundation\StreamedJsonResponse;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\HttpKernel\Attribute\Cache;
use App\Service\ConfigService;
use App\Service\FilesystemService;
use App\Service\CarbonService;
use App\Entity\Product\FoodProduct;
use App\Entity\Product\FurnitureProduct;
use App\Entity\Product\ToyProduct;
use App\Entity\Product\Product;
use App\Entity\MappedSuperclass\Passport;
use App\Entity\UserPassport;
use App\Entity\ProductPassport;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Context\Encoder\JsonEncoderContextBuilder;
use App\Messenger\Notifier\SendEmail;
use App\Messenger\Notifier\ToAdminSendEmail;
use App\Messenger\Notifier\NotifierHandlers;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\Exception\StopWorkerException;
use App\Messenger\Test\Query\ListUsers;
use Symfony\Component\Messenger\Handler\Acknowledger;

class HomeController extends AbstractController
{
    #[Route(path: '/{id?1}')]
    public function home(
        Request $r,
        RequestStack $requestStack,
        ParameterBagInterface $parameters,
        $t,
        #[Autowire(param: 'kernel.project_dir')]
        $projectDir,
        UrlHelper $url,
        EntityManagerInterface $em,
        $faker,
		$adminSendEmailMessage,
		$adminEmail,
		MessageBusInterface $bus,
		//UserPassport $obj,
		$get,
    ): Response {
		
		
		//throw $this->createNotFoundException();
		//throw new StopWorkerException;
		
		$message = new ToAdminSendEmail(
			'Event happened HIGH PRIORITY',
			__METHOD__,
		);
		
		$ack = new Acknowledger(
			NotifierHandlers::class,
			static fn($e, $r) => true,
		);
		$bus->dispatch($message, $ack);
		//$bus->dispatch($message);
		//$rest = $bus->dispatch($message);
		//$rest = $bus->dispatch($message);
		
		//\dump('$rest', $rest);
		
		return $this->render('home/home.html.twig');

        $result = $em->createQuery('
			SELECT p.id + p.price, p.name AS HIDDEN name 
			FROM ' . Product::class . ' p
			WHERE p INSTANCE OF ' . FurnitureProduct::class . '
			ORDER BY name DESC
		')
            //GROUP BY p.id
            ->getResult()
            //->getSingleScalarResult()
        ;

        \dd($result);

        array_walk($result, static fn($obj) => \dump($obj->getId()));

        //\dd($user->getName(), DoctrineService::getStateName($t, $em, $user));


        $accept = $r->headers->get('accept');
        $keyValues = [
            //['key0', ['val00', 'val01', 'val02']],
            ['key1', 'val1'],
            ['key2', 'val2'],
        ];
        $stringLikeQueryOne = 'arr[key0]=11&arr[key1]=2&a=b';

        $aH = AcceptHeader::fromString($accept);

        $isGet = new MethodRequestMatcher('GET');
        $isPost = new MethodRequestMatcher('POST');
        $isRouteParamsAttribute = new AttributesRequestMatcher([
            'defVal' => '.*',
        ]);
        $isExpression = new ExpressionRequestMatcher(
            new ExpressionLanguage(),
            'path matches "~.*~" and path in ["a"]'
        );
        $isHeader = new HeaderRequestMatcher([
            'accept',
        ]);
        $isHost = new HostRequestMatcher('127.*');
        $isIps = new IpsRequestMatcher([
            '127.0.0.0',
            '127.0.0.1',
        ]);
        $isQueryParameters = new QueryParameterRequestMatcher([
            'req',
            'a',
        ]);





        //$response = new Response('{"a": 13}', Response::HTTP_OK);
        $response = $this->render('home/home.html.twig');

        $response->headers->set('Content-Type', 'text/html');
        $response->setCharset('UTF-8');
        $response->prepare($r);
        //$response->send();

        //return new StreamedJsonResponse(SomeService::getGenerator());

        //$r->headers->set('X-Sendfile', '1');
        //$r->deleteFileAfterSend();


        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'some-html-file-content.php',
        );


        return $response;

        /*
        \dump($r->cookies->all());
        $cookieString = HeaderUtils::toString([
            'PHP_TEST_COOKIE' => 'YeS',
            'Expires' => $carbon->now()->add(10, 'seconds')->format(\DateTimeInterface::COOKIE),
        ], ';');
        $response->headers->setCookie(Cookie::fromString($cookieString));
        */
        //$response->setPublic();
        //$response->setPrivate();
        //$response->expire();
        //$response->setExpires($carbon->now()->tz('00')->add(1, 'day'));

            /*
        \dd(
            $r->getClientIps(),
            $r->getScriptName(),
            $r->getRequestUri(),
            $r->getRelativeUriForPath('lasa/gola'),
            $r->getContentTypeFormat(),
            $r->getProtocolVersion(),
            $r->getETags(),
            $r->getPreferredFormat(),
            */

            /*
            $isGet->matches($r),
            $isPost->matches($r),
            $isRouteParamsAttribute->matches($r),
            $r->attributes->all(),
            $isExpression->matches($r),
            $isHeader->matches($r),
            $isHost->matches($r),
            $isIps->matches($r),
            $isQueryParameters->matches($r),
            */

            /*
            $ip = '127.0.0.1',
            IpUtils::isPrivateIp($ip),
            IpUtils::isPrivateIp('77.82.215.52'),
            IpUtils::anonymize($ip),
            */

            /*
            $aH->all(),
            $aH->get('application/json')->getQuality(),
            $r->getAcceptableContentTypes(),
            $aH->has('text/html'),
            $aH->get('application/xml')->getAttributes(),
            */

            /*
            $accept,
            $r->getAcceptableContentTypes(),
            $r->getLanguages(),
            $r->getCharsets(),
            $r->getEncodings(),
            */

            /*
            HeaderUtils::split($accept, ',;'),
            $combine = HeaderUtils::combine($keyValues),
            HeaderUtils::toString($combine, '&'),
            HeaderUtils::quote('a" "строка'),
            HeaderUtils::unquote('a строка'),
            HeaderUtils::parseQuery($stringLikeQueryOne),
            */

            /*
            $r->getPathInfo(),
            $r->getPayload(),
            $r->getContent(),
            $r->toArray(),
            'request: ' , $r->request,
            'query: ' , $r->query,
            'cookies: ' , $r->cookies,
            'files: ' , $r->files,
            //'server: ' , $r->server,
            'headers: ' , $r->headers,

            'attributes: ' , $r->attributes,
        );
            */

        return $response;
    }

    #[Route(
        path: '/product/{id}',
        methods: [
            'GET',
        ],
    )]
    //#[Cache(public: true, maxage: 10)]
    public function condition(
        Request $r,
        UrlHelper $url,
        MessageBusInterface $bus,
        EntityManagerInterface $em,
        ProductRepository $productRep,
        UserRepository $userRep,
        $enUtcCarbon,
        $t,
        #[Autowire(service: 'gs_service.carbon_factory_immutable')]
        $carbon,
        //#[ValueResolver(DefaultValueResolver::class)]
        //#[ValueResolver(EntityValueResolver::class, disabled: true)]
        //Product $product,
        //User $user,
    ): Response {

        \dd(
            $carbon->now()->tz(),
        );

        $resp = $this->render('condition/condition.html.twig', [
            'value' => 123,
        ]);

        $category = $em->getRepository(ProductCategory::class)->find(1);
        $products = $category->getProducts();

        /*
        foreach([
            ProductType::EAT,
            ProductType::FURNITURE,
            ProductType::MILK,
        ] as $category) {
            $productCategory = new ProductCategory($category);
            $em->persist($productCategory);
        }
        $em->flush();
        */


        \dump(
            \get_class($product->getCategory()),
            //$products,
            //$product->getCategory()->getType()->value,
            //$product,
            //$user,
        );

        /*

        $product = $productRep->findBy([], [
            'id' => Criteria::DESC,
        ]);

        // ~~i
        $product = $productRep->findOneBy([
            'name' => 'швабра',
            'price' => '1000',
        ], [
            'id' => Criteria::DESC,
        ]);

        $product = new Product('Швабра', '2000', $enUtcCarbon->now()->add(10, 'days'));
        $em->persist($product);
        $em->flush();
        */

        return $resp;
    }

    #[Route(path: '/product/remove/{id}')]
    public function removeProduct(
        EntityManagerInterface $em,
        ?Product $product = null,
    ) {
        if (\is_null($product)) {
            return $this->redirectToRoute('app_home_home');
        }

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute('app_home_home');
    }
}
