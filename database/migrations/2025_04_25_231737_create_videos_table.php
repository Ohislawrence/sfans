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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->text('link');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('duration');
            $table->string('thumbnail');
            $table->text('iframe')->nullable();
            $table->text('tags');
            $table->text('pornstars')->nullable();
            $table->string('numbers')->unique();
            $table->string('category');
            $table->string('quality')->nullable();
            $table->string('channel')->nullable();
            $table->string('empty')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
