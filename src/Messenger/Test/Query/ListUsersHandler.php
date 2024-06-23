<?php

namespace App\Messenger\Test\Query;

use GS\WebApp\Contract\Messenger\QueryHandlerInterface;
use GS\WebApp\Contract\Messenger\HasSyncTransportInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Repository\UserRepository;
use GS\WebApp\Type\Messenger\BusTypes;
use App\Contract\Messenger\CommandBusHandlerInterface;

#[AsMessageHandler(
    bus: BusTypes::QUERY_BUS,
)]
class ListUsersHandler
{
    public function __construct(
        protected readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(ListUsers $query): mixed
    {
        return $this->userRepository->findAll();
    }
}
