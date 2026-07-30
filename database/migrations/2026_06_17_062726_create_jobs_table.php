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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // =========================
            // BASIC INFO (MULTI LANGUAGE)
            // =========================
            $table->string('title_ar');
            $table->string('title_en');
            $table->text('description_ar');
            $table->text('description_en');
            $table->string('location_ar')->nullable();
            $table->string('location_en')->nullable();
            // =========================
            // JOB DETAILS
            // =========================
            $table->string('type'); // full-time, part-time, etc
            $table->text('main_tasks_ar')->nullable();
            $table->text('main_tasks_en')->nullable();
            $table->text('required_skills_ar')->nullable();
            $table->text('required_skills_en')->nullable();
            // =========================
            // CONTROL
            // =========================
            $table->boolean('is_active')->default(true);
            $table->boolean('featured')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
