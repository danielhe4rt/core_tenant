<?php

namespace App\Client\Contracts;

use App\Client\DTOs\AccessTokenDTO;

interface OAuthContract
{
    public function redirectUrl(): string;

    public function authenticate(string $code): AccessTokenDTO;

    public function getAuthenticatedUser(AccessTokenDTO $accessTokenDTO);
}
