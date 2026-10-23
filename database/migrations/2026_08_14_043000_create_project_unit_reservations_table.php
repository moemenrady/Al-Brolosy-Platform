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
        Schema::create('project_unit_reservations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('project_unit_id')
                ->constrained('project_units')
                ->cascadeOnDelete();

            $table->string('customer_name');

            $table->string('phone');

            $table->text('notes')->nullable();

            $table->enum('status', [
                'pending',
                'confirmed',
                'cancelled',
                'expired',
            ])->default('pending');

            $table->timestamp('reserved_until')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_unit_reservations');
    }
};
