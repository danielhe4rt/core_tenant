<?php

namespace App\Client\Kick\DTOs;

class KickUserDTO
{
    public string $id;

    public string $username;

    public string $email;

    public string $profile_picture_url;

    public function __construct(
        string $id,
        string $username,
        string $email,
        string $profile_picture_url
    ) {
        $this->id                  = $id;
        $this->username            = $username;
        $this->email               = $email;
        $this->profile_picture_url = $profile_picture_url;
    }

    public static function fromArray(array $data): KickUserDTO
    {
        return new KickUserDTO(
            id: (string) ($data['user_id'] ?? ''),
            username: (string) ($data['name'] ?? ''),
            email: (string) ($data['email'] ?? ''),
            profile_picture_url: (string) ($data['profile_picture'] ?? '')
        );
    }
}
