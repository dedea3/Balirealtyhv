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
        Schema::create('villa_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('villa_id')->constrained()->onDelete('cascade');
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->decimal('price_per_night', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('minimum_nights')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['villa_id', 'season_id']);
            $table->index(['villa_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villa_rates');
    }
};
