<?php

use App\Http\Controllers\{EvolutionWebhookController, OAuthController, StripeWebhookController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/app');
});

// Rota do webhook custom stripe
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

// Rota do webhook custom evolution
Route::post('/evolution/webhook', [EvolutionWebhookController::class, 'handle']);

Route::get('/oauth/{provider}/redirect', [OAuthController::class, 'redirectToProvider']);
Route::get('/oauth/{provider}', [OAuthController::class, 'handleProviderCallback']);
