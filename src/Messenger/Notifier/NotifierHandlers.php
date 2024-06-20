<?php

namespace App\Messenger\Notifier;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\StopWorkerException;
use App\Service\OSService;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Handler\Acknowledger;
use Symfony\Component\Messenger\Handler\BatchHandlerInterface;
use Symfony\Component\Messenger\Handler\BatchHandlerTrait;

class NotifierHandlers implements BatchHandlerInterface
{
	use BatchHandlerTrait;
	
	public function __construct(
		private readonly ProductRepository $productRepository,
		private readonly EntityManagerInterface $em,
		private readonly MessageBusInterface $bus,
	) {
	}

    public function sendToAdminEmailHandler(ToAdminSendEmail $message): void
    {
		//throw new \Exception;
		
		// mail
		/*
		$e = $this->bus->dispatch(new SendEmail('son5', 'son5'), [
			new DispatchAfterCurrentBusStamp,
		]);
		$o = $this->productRepository->find(31);
		$o->setPassport(null);
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
		throw new \Exception;
		//\dump('SENDING...');
    }
	
	#[AsMessageHandler]
	public function __invoke(ToAdminSendEmail $message, ?Acknowledger $ack = null): mixed
    {
        return $this->handle($message, $ack);
    }
	
	private function process(array $jobs): void
    {
        foreach ($jobs as [$message, $ack]) {
            try {
				\dump($message());
                $ack->ack($message());
            } catch (\Throwable $e) {
                $ack->nack($e);
            }
        }
    }
	
	private function shouldFlush(): bool
    {
        return $this->getBatchSize() <= \count($this->jobs);
    }

	private function getBatchSize(): int
    {
        return 3;
    }

}
