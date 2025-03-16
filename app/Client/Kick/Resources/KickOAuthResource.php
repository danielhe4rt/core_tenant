<?php

namespace App\Client\Kick\Resources;

use App\Client\Contracts\OAuthContract;
use App\Client\DTOs\AccessTokenDTO;
use Illuminate\Support\Facades\{Http, Session};

class KickOAuthResource implements OAuthContract
{

    public function authenticate(string $code): AccessTokenDTO
    {
        // Retrieve the code_verifier stored in the session
        $codeVerifier = Session::get('code_verifier');

        if (! $codeVerifier) {
            // Handle error appropriately if the code verifier is missing
            throw new \RuntimeException('Code verifier not found in session.');
        }

        // Post to Kick's token endpoint using PKCE
        $response = Http::asForm()->post('https://id.kick.com/oauth/token', [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => config('services.kick.redirect_uri'),
            'client_id'     => config('services.kick.client_id'),
            'client_secret' => config('services.kick.client_secret'),
            'code_verifier' => $codeVerifier,
        ]);

        if ($response->failed()) {
            // Optionally, log the error or handle it as needed
            throw new \RuntimeException('Failed to retrieve access token: ' . $response->body());
        }

        return AccessTokenDTO::fromArray($response->json());
    }


    public function getAuthenticatedUser(AccessTokenDTO $accessTokenDTO): array
    {
        $uri = 'https://api.kick.com/public/v1/users';

        $response = Http::withToken($accessTokenDTO->access_token)->get($uri)->json();

        return $response ?? [];
    }

    /**
     * Build the authorization URL to redirect the user.
     */
    public function redirectUrl(): string
    {
        $codeVerifier  = $this->generateCodeVerifier();
        $codeChallenge = $this->generateCodeChallenge($codeVerifier);

        // Store the code_verifier in the session for later use
        Session::put('code_verifier', $codeVerifier);

        return sprintf('https://id.kick.com/oauth/authorize?%s', http_build_query([
            'client_id'             => config('services.kick.client_id'),
            'redirect_uri'          => config('services.kick.redirect_uri'),
            'response_type'         => 'code',
            'scope'                 => 'user:read',
            'state'                 => md5(time()),
            'code_challenge'        => $codeChallenge,
            'code_challenge_method' => 'S256',
        ]));
    }

    /**
     * Generate a secure code verifier.
     */
    public function generateCodeVerifier(int $length = 128): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    /**
     * Generate a code challenge from the code verifier.
     */
    public function generateCodeChallenge(string $codeVerifier): string
    {
        return rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
    }
}
