<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\StopWorkerException;
use App\Service\OSService;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use App\Repository\ProductRepository;
use App\Repository\ProductPassportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Handler\Acknowledger;
use Symfony\Component\Messenger\Handler\BatchHandlerInterface;
use Symfony\Component\Messenger\Handler\BatchHandlerTrait;
use App\Contract\Messenger\CommandBusHandlerInterface;

class NotifierHandlers implements CommandBusHandlerInterface
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly ProductPassportRepository $productPassportRepository,
        private readonly EntityManagerInterface $em,
        private readonly MessageBusInterface $bus,
    ) {
    }

    #[AsMessageHandler]
    public function __invoke(
        ToAdminSendEmail $message,
        ?string $baseUrl = null,
        ?string $pathInfo = null,
    ): void {
        //throw new \Exception;

        /*
        $o = $this->productRepository->find(31);
        $o->setPassport($this->productPassportRepository->find(12));
        $o->setPassport(null);
        */

        \dump($baseUrl, $pathInfo);

        /*
        $this->bus->dispatch(new SendEmail('son5', 'son5'), [
            new DispatchAfterCurrentBusStamp,
        ]);

        throw new Exception;
        $this->em->flush();
        */
        //throw new RecoverableMessageHandlingException;
        //throw new UnrecoverableMessageHandlingException;
        //throw new StopWorkerException('Worker stop command');
        //$value = $this->osService('make', true, 11);
        //\dump('Sending email to "' . $message->getTo() . '"' . \PHP_EOL . $message);
    }

    #[AsMessageHandler]
    public function sendEmailHandler(SendEmail $message): void
    {
        //throw new \Exception;
        \dump('SENDING...');
    }
}
