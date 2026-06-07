<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Öncesi/sonrası galeri vakaları. */
    public function up(): void
    {
        Schema::create('gallery_cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('treatment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('before_url');
            $table->string('after_url');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_cases');
    }
};
