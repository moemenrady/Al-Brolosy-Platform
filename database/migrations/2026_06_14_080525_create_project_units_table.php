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
    Schema::create('project_units', function (Blueprint $table) {

      $table->id();

      $table->foreignId('project_id')
        ->constrained()
        ->cascadeOnDelete();

      // =========================
      // UNIT INFO
      // =========================
      $table->string('unit_type'); // Residential / Commercial / Admin

      $table->string('floor')->nullable(); // Ground / First / etc

      $table->string('start_area')->nullable(); // ranges

      $table->string('price_per_meter')->nullable();

      $table->string('unit_price')->nullable();

      $table->string('finishing_type')->nullable(); // semi / core / full

      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('project_units');
  }
};
