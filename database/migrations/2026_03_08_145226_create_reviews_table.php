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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('villa_id')->constrained()->onDelete('cascade');
            $table->string('guest_name');
            $table->string('country')->nullable();
            $table->string('guest_type')->nullable(); // Family, Couple, Group, Solo
            $table->date('stay_date')->nullable();
            $table->text('review_text');
            $table->integer('rating')->nullable(); // 1-5 stars
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('response_text')->nullable(); // Admin response
            $table->timestamp('response_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['villa_id', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
