<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->string('user_id')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('os')->nullable();
            $table->json('preferences')->nullable();
            $table->boolean('age_verified')->default(false);
            $table->boolean('is_adult')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
