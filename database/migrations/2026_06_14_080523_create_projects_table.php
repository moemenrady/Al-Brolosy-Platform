<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('projects', function (Blueprint $table) {

      $table->id();

      $table->foreignId('sector_id')
        ->constrained()
        ->cascadeOnDelete();

      // =========================
      // BASIC INFO
      // =========================
      $table->string('name_ar');
      $table->string('name_en');

      $table->string('logo')->nullable();

      $table->string('copyright_sentence_ar')->nullable();
      $table->string('copyright_sentence_en')->nullable();

      $table->text('description_ar')->nullable();
      $table->text('description_en')->nullable();

      $table->string('location_ar')->nullable();
      $table->string('location_en')->nullable();

      // =========================
      // LOCATION
      // =========================
      $table->decimal('latitude', 10, 7)->nullable();
      $table->decimal('longitude', 10, 7)->nullable();

      // =========================
      // MEDIA
      // =========================
      $table->string('image');
      $table->string('hover_image')->nullable();

      // =========================
      // PRICING
      // =========================
      $table->string('price_budget')->nullable();

      // =========================
      // STATUS
      // =========================
      $table->enum('status', [
        'launched',
        'coming_soon',
        'under_construction',
        'immediate'
      ])->default('coming_soon');

      // =========================
      // CONTROL
      // =========================
      $table->integer('sort_order')->default(0);
      $table->boolean('featured')->default(false);
      $table->boolean('is_active')->default(true);

      $table->string('delivery_time')->nullable();

      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('projects');
  }
};
