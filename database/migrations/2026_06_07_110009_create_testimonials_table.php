<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('patient_name');
            $table->string('treatment_label')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);  // 1-5
            $table->text('body');
            $table->string('avatar_url')->nullable();
            $table->boolean('is_approved')->default(false);     // moderasyon
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
