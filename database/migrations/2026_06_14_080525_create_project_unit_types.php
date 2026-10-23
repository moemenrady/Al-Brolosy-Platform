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
    Schema::create('project_unit_types', function (Blueprint $table) {
      $table->id();
      $table->foreignId('project_id')
        ->constrained()
        ->cascadeOnDelete();
      $table->string('name_ar')->nullable();
      $table->string('name_en')->nullable();
      $table->string('unit_type'); // residential / commercial / administrative
      $table->string('floor')->nullable();
      $table->decimal('area', 10, 2)->nullable();
      $table->decimal('price_per_meter', 15, 2)->nullable();
      $table->decimal('unit_price', 15, 2)->nullable();
      $table->string('finishing_type')->nullable();
      $table->unsignedInteger('total_units')->default(0);
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('project_unit_types');
  }
};
