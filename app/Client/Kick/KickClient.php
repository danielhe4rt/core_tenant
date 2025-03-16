<?php

namespace App\Client\Kick;

use App\Client\Kick\Resources\KickOAuthResource;

class KickClient
{
    public function oauth(): KickOAuthResource
    {
        return new KickOAuthResource();
    }
}
