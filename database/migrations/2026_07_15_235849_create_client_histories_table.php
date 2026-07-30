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
        Schema::create('client_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('client_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('smart_card_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('employee_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
    |--------------------------------------------------------------------------
    | Event
    |--------------------------------------------------------------------------
    */

            $table->enum('type', [

                'interest_registered',

                'consultation',

                'phone_call',

                'whatsapp',

                'meeting',

                'visit',

                'project_sent',

                'offer_sent',

                'reservation',

                'contract',

                'payment',

                'smart_card_requested',

                'smart_card_under_review',

                'smart_card_approved',

                'smart_card_activated',

                'smart_card_rejected',

                'smart_card_blocked',

                'smart_card_unblocked',

                'smart_card_cancelled',

                'smart_card_expired',

                'smart_card_created',

                'smart_card_updated',

                'note',

                'status_changed',

                'follow_up',

                'other'

            ]);

            /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

            $table->enum('status', [

                'pending',

                'in_progress',

                'completed',

                'cancelled'

            ])->default('completed');

            /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

            $table->string('title');

            /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

            $table->longText('description')->nullable();

            /*
    |--------------------------------------------------------------------------
    | JSON Data
    |--------------------------------------------------------------------------
    */

            $table->json('meta')->nullable();

            /*
    |--------------------------------------------------------------------------
    | Follow Up
    |--------------------------------------------------------------------------
    */

            $table->timestamp('follow_up_at')->nullable();

            /*
    |--------------------------------------------------------------------------
    | Visibility
    |--------------------------------------------------------------------------
    */

            $table->boolean('visible_to_client')->default(true);

            /*
    |--------------------------------------------------------------------------
    | Priority
    |--------------------------------------------------------------------------
    */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_histories');
    }
};
