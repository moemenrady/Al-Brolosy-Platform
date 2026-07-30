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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            // =========================
            // APPLICANT INFO
            // =========================
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('cv_path');
            $table->text('message')->nullable();
            // =========================
            // STATUS
            // =========================
            $table->enum('status', [
                'pending',
                'reviewed',
                'accepted',
                'rejected'
            ])->default('pending');
            // =========================
            // ANALYTICS
            // =========================
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
