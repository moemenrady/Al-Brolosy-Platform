<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (! Schema::hasColumn('clients', 'source')) {
                $table->string('source')->nullable();
            }
            if (! Schema::hasColumn('clients', 'assigned_employee_id')) {
                $table->foreignId('assigned_employee_id')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('clients', 'lead_status')) {
                $table->enum('lead_status', ['new', 'contacted', 'qualified', 'negotiation', 'won', 'lost', 'inactive'])->default('new');
            }
            if (! Schema::hasColumn('clients', 'last_contact_at')) {
                $table->timestamp('last_contact_at')->nullable();
            }
            if (! Schema::hasColumn('clients', 'next_follow_up_at')) {
                $table->timestamp('next_follow_up_at')->nullable();
            }
        });

        Schema::table('smart_cards', function (Blueprint $table) {
            if (! Schema::hasColumn('smart_cards', 'requested_at')) {
                $table->timestamp('requested_at')->nullable();
            }
            if (! Schema::hasColumn('smart_cards', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('smart_cards', 'activated_by')) {
                $table->foreignId('activated_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('smart_cards', 'blocked_by')) {
                $table->foreignId('blocked_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('smart_cards', 'rejected_by')) {
                $table->foreignId('rejected_by')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('smart_cards', 'expires_at')) {
                $table->timestamp('expires_at')->nullable();
            }
            if (! Schema::hasColumn('smart_cards', 'last_status_changed_at')) {
                $table->timestamp('last_status_changed_at')->nullable();
            }
        });

        Schema::table('client_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('client_histories', 'created_by')) {
                $table->string('created_by')->nullable();
            }
            if (! Schema::hasColumn('client_histories', 'origin')) {
                $table->string('origin')->nullable();
            }
            if (! Schema::hasColumn('client_histories', 'device')) {
                $table->string('device')->nullable();
            }
            if (! Schema::hasColumn('client_histories', 'ip')) {
                $table->string('ip')->nullable();
            }
            if (! Schema::hasColumn('client_histories', 'user_agent')) {
                $table->text('user_agent')->nullable();
            }
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement('ALTER TABLE client_histories MODIFY COLUMN type VARCHAR(255) NOT NULL');
        }
    }

    public function down(): void
    {
        Schema::table('client_histories', function (Blueprint $table) {
            $table->dropColumn(['created_by', 'origin', 'device', 'ip', 'user_agent']);
        });

        Schema::table('smart_cards', function (Blueprint $table) {
            $table->dropColumn(['requested_at', 'approved_by', 'activated_by', 'blocked_by', 'rejected_by', 'expires_at', 'last_status_changed_at']);
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['source', 'assigned_employee_id', 'lead_status', 'last_contact_at', 'next_follow_up_at']);
        });
    }
};
