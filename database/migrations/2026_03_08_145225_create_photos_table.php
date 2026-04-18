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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('villa_id')->constrained()->onDelete('cascade');
            $table->string('path');
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->enum('category', ['hero', 'gallery', 'floor_plan', 'video_thumbnail'])->default('gallery');
            $table->integer('sort_order')->default(0);
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->integer('file_size')->nullable(); // in bytes
            $table->string('mime_type')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->boolean('is_primary')->default(false); // For hero image
            $table->timestamps();

            $table->index(['villa_id', 'category', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
