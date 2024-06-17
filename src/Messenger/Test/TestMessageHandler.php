<?php

namespace App\Messenger\Test;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TestMessageHandler
{
    public function __invoke(TestMessage $message): void
    {
        \dump($message);
    }
}
