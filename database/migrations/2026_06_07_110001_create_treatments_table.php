<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();           // heroicon key
            $table->string('color')->default('#15a3a8');   // accent for the card
            $table->string('image_url')->nullable();
            $table->string('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->json('benefits')->nullable();          // bullet list
            $table->decimal('price_from', 10, 2)->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(45);
            $table->boolean('featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->string('seo_title')->nullable();
            $table->string('seo_description', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
