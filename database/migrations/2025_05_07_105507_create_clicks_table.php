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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('session_id', 255)->nullable();
            $table->timestamp('click_time')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referrer')->nullable();
            
            // Source identification
            $table->enum('source_type', ['affiliate_link', 'video', 'shop']);
            $table->unsignedBigInteger('source_id');
            
            // Conversion tracking
            $table->boolean('is_converted')->default(false);
            $table->timestamp('conversion_time')->nullable();
            $table->decimal('conversion_value', 10, 2)->nullable();
            
            // Additional metadata
            $table->string('device_type', 50)->nullable();
            $table->string('country_code', 2)->nullable();
            
            // Indexes
            $table->index(['source_type', 'source_id']);
            $table->index('user_id');
            $table->index('click_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
