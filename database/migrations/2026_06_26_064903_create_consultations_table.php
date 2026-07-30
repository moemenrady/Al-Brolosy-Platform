<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->string('phone');

            $table->enum('preferred_contact', [
                'phone',
                'whatsapp',
                'email'
            ]);

            $table->text('message');

            $table->enum('status', [
                'new',
                'contacted'
            ])->default('new');

            $table->timestamp('contacted_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
