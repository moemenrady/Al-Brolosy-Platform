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
        Schema::create('smart_cards', function (Blueprint $table) {
            $table->id();
            // رقم الكارت (يتم توليده عند الموافقة)
            $table->string('card_number', 15)->nullable()->unique();
            // حالة الطلب
            $table->enum('status', [
                'pending',     // العميل قدم الطلب وينتظر المراجعة
                'under_review', // الموظف يراجع الطلب
                'approved',    // تمت الموافقة ولم يتم التسليم بعد (اختياري)
                'active',      // الكارت مفعل
                'rejected',    // تم رفض الطلب
                'blocked',     // تم حظر الكارت
                'expired',     // انتهت صلاحيته (لو هتضيف صلاحية مستقبلاً)
                'cancelled',   // العميل ألغى الطلب
            ])->default('pending');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('status_note')->nullable();
            $table->foreignId('client_id')->nullable()
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_cards');
    }
};
