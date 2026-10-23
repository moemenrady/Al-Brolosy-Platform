<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('concierge_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('step_number')->default(1);
            $table->string('title_ar');
            $table->string('title_en')->nullable();
            $table->text('subtitle_ar')->nullable();
            $table->text('subtitle_en')->nullable();
            $table->string('step_type')->default('options_grid'); // options_grid, lead_form, text_input
            $table->string('target_field')->default('purpose'); // purpose, unit_type, project_or_city, budget, payment_method, contact_info, etc.
            $table->json('options')->nullable(); // [{"title_ar": "سكن فاخر", "title_en": "Residential", "value": "residential", "icon": "🏡"}]
            $table->boolean('is_required')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concierge_steps');
    }
};
