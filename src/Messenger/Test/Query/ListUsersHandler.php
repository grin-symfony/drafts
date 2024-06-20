<?php

namespace App\Messenger\Test\Query;

use GS\WebApp\Contract\Messenger\QueryHandlerInterface;
use GS\WebApp\Contract\Messenger\QueryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Repository\UserRepository;

#[AsMessageHandler]
class ListUsersHandler {
	
	public function __construct(
		protected readonly UserRepository $userRepository,
	) {}
	
	public function __invoke(ListUsers $query): mixed {
		return $this->userRepository->findAll();
	}
	
}