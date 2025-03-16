<?php

namespace App\Http\Controllers;

use App\Client\Contracts\OAuthContract;
use App\Client\DTOs\AccessTokenDTO;
use App\Client\Kick\DTOs\KickUserDTO;
use App\Client\Kick\KickClient;
use Filament\Facades\Filament;
use App\Models\{User};
use Auth;
use Hash;
use Illuminate\Http\{RedirectResponse, Request};

class OAuthController extends Controller
{
    public function redirectToProvider(string $provider): RedirectResponse
    {
        return redirect()->away($this->getProvider($provider)->redirectUrl());
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        $providerClient = $this->getProvider($provider);
        $accessTokenDTO = $providerClient->authenticate($request->input('code'));

        $fetchUserResponse = $providerClient->getAuthenticatedUser($accessTokenDTO);
        $user              = KickUserDTO::fromArray($fetchUserResponse['data'][0]);

        $this->createUserAndTenant($provider, $accessTokenDTO, $user);

        return redirect()->to('/');
    }

    private function getProvider(string $provider): OAuthContract
    {
        return match ($provider) {
            'kick'  => app(KickClient::class)->oauth(),
            default => throw new \RuntimeException('Unknown provider: ' . $provider),
        };
    }

    private function createUserAndTenant(string $provider, AccessTokenDTO $accessTokenDTO, KickUserDTO $payload): void
    {

        $user = User::query()->firstOrCreate([
            'email' => $payload->email,
        ], [
            'name'              => $payload->username,
            'email'             => $payload->email,
            'password'          => Hash::make(md5(time())),
            'is_active'         => true,
            'email_verified_at' => now(),
            'is_tenant_admin'   => true,
        ]);

        $user->connectedAccounts()
            ->firstOrCreate([
                'provider'    => $provider,
                'provider_id' => $payload->id,
            ], [
                'access_token'        => $accessTokenDTO->access_token,
                'refresh_token'       => $accessTokenDTO->refresh_token,
                'expires_at'          => now()->addSeconds($accessTokenDTO->expires_in),
                'profile_picture_url' => $payload->profile_picture_url,
            ]);

        if ($user->organizations()->exists()) {
            return;
        }

        $user->organizations()->firstOrCreate([
            'provider'    => $provider,
            'provider_id' => $payload->id,
        ], [
            'name'      => $payload->username,
            'slug'      => str($payload->username)->slug(),
            'is_active' => true,
        ]);

        Auth::login($user);
    }
}
