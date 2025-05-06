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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username');
            $table->string('display_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('gender')->nullable();
            $table->string('sexual_orientation')->nullable();
            $table->text('bio')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tictok')->nullable();
            $table->string('x')->nullable();
            $table->string('website')->nullable();
            $table->string('google_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('facebook_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
