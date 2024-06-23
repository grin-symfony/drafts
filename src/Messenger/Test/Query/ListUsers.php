<?php

namespace App\Messenger\Test\Query;

use GS\WebApp\Contract\Messenger\HasSyncTransportInterface;

class ListUsers implements HasSyncTransportInterface
{
    public function __construct()
    {
    }
}
