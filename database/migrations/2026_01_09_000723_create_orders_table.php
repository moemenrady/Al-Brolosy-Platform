<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('orders', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
      $table->string('email')->nullable();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('phone');
      $table->string('address');
      $table->string('apartment')->nullable();
      $table->string('city');
      $table->string('governorate');
      $table->string('postal_code')->nullable();
      $table->boolean('is_deposited')->default(false);
      $table->decimal('total', 10, 2);

      $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orders');
  }
};
