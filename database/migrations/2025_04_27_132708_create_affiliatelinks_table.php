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
        Schema::create('affiliatelinks', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('offer_by');
            $table->string('cost')->nullable();
            $table->string('offer_name')->nullable();
            $table->text('coutries')->nullable();
            $table->string('is_smartlink');
            $table->string('tags');
            $table->string('media')->nullable();
            $table->string('media_dimension')->nullable();
            $table->boolean('is_tangible')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliatelinks');
    }
};
