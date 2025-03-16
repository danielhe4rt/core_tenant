<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socialite_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('provider');
            $table->string('provider_id');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->string('profile_picture_url')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socialite_users');
    }
};
