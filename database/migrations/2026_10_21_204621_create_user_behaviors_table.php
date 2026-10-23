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
        Schema::create('user_behaviors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('identity_id')->nullable()->constrained('identities')->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('session_id')->nullable();
            $table->string('event_type'); // page_view, project_view, unit_view, quiz_step, quiz_complete, whatsapp_click, brochure_download, consultation_request, calculator_calc, search_filter
            $table->string('page_url')->nullable();
            $table->string('page_title')->nullable();
            $table->json('metadata')->nullable();
            $table->string('device')->nullable(); // mobile, tablet, desktop
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['event_type', 'created_at']);
            $table->index('identity_id');
            $table->index('client_id');
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_behaviors');
    }
};
