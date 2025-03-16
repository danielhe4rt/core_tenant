<?php

namespace App\Client\DTOs;

class AccessTokenDTO
{
    public string $access_token;

    public int $expires_in;

    public string $refresh_token;

    public string $scope;

    public string $token_type;

    public function __construct(
        string $access_token,
        int $expires_in,
        string $refresh_token,
        string $scope,
        string $token_type
    ) {
        $this->access_token  = $access_token;
        $this->expires_in    = $expires_in;
        $this->refresh_token = $refresh_token;
        $this->scope         = $scope;
        $this->token_type    = $token_type;
    }

    public static function fromArray(array $data): AccessTokenDTO
    {
        return new AccessTokenDTO(
            $data['access_token'],
            $data['expires_in'],
            $data['refresh_token'],
            $data['scope'],
            $data['token_type']
        );
    }
}
