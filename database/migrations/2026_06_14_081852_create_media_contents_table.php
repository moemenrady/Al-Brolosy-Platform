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
        Schema::create('media_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('media_post_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->enum('type', [
                'text',
                'image',
                'video'
            ]);
            // للنصوص
            $table->longText('content_ar')->nullable();
            $table->longText('content_en')->nullable();
            // للصورة أو الفيديو
            $table->string('media_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_contents');
    }
};
