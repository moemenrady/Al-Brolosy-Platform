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
    Schema::create('project_payment_plans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('project_id')
        ->constrained()
        ->cascadeOnDelete();

      // =========================
      // PAYMENT DATA
      // =========================
      $table->string('down_payment')->nullable(); // 10% / 20%
      $table->string('installment_years')->nullable(); // 3 years etc
      $table->string('maintenance')->nullable(); // 5% / 8%
      $table->text('notes')->nullable();
      $table->timestamps();
    });
  }
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('project_payment_plans');
  }
};
