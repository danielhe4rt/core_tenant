<?php

namespace Database\Factories;

use App\Models\{SocialiteUser, User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\{Carbon, Str};

class SocialiteUserFactory extends Factory
{
    protected $model = SocialiteUser::class;

    public function definition(): array
    {
        return [
            'provider'      => $this->faker->word(),
            'provider_id'   => $this->faker->word(),
            'access_token'  => Str::random(10),
            'refresh_token' => Str::random(10),
            'expires_at'    => Carbon::now(),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
