<?php

namespace App\Service;

class SomeService
{
    public static function getGenerator(): \Generator
    {
        yield ['data' => 0];
        yield ['data' => 1];
        yield ['data' => 2];
    }
}
