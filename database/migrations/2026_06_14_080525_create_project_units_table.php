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

    $table->foreignId('project_unit_type_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->string('unit_number');

    $table->decimal('area', 10, 2)->nullable();

    $table->decimal('price_per_meter', 15, 2)->nullable();

    $table->decimal('unit_price', 15, 2)->nullable();

    $table->enum('status', [
        'available',
        'reserved',
        'sold',
    ])->default('available');

    $table->timestamps();

    $table->unique([
        'project_id',
        'unit_number'
    ]);
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
