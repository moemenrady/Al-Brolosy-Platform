<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add booking_phone to projects table
        if (Schema::hasTable('projects') && !Schema::hasColumn('projects', 'booking_phone')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('booking_phone')->nullable()->after('price_budget');
            });
        }

        // 2. Create platform_settings table
        if (!Schema::hasTable('platform_settings')) {
            Schema::create('platform_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('label_ar')->nullable();
                $table->string('group')->default('general');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('projects') && Schema::hasColumn('projects', 'booking_phone')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('booking_phone');
            });
        }

        Schema::dropIfExists('platform_settings');
    }
};
