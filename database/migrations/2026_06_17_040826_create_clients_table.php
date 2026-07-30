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
   Schema::create('clients', function (Blueprint $table) {

    $table->id();

    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    */

    $table->string('full_name');

    $table->string('phone')->index();

    $table->string('email')->nullable()->index();

    // صورة العميل (اختيارية)
    $table->string('photo')->nullable();

    // المحافظة (إجباري)
    $table->string('governorate');

    // المدينة
    $table->string('city')->nullable();


    /*
    |--------------------------------------------------------------------------
    | Personal Information
    |--------------------------------------------------------------------------
    */

    $table->enum('marital_status', [
        'single',
        'married',
        'divorced',
        'widowed'
    ])->nullable();

    $table->enum('family_size', [
        '1',
        '2-3',
        '4-5',
        '6+'
    ])->nullable();


    /*
    |--------------------------------------------------------------------------
    | Real Estate Interest
    |--------------------------------------------------------------------------
    */

    $table->enum('purpose', [
        'residential',
        'investment',
        'summer',
        'clinic',
        'office',
        'commercial_shop'
    ])->nullable();

    $table->enum('unit_type', [
        'apartment',
        'villa',
        'townhouse',
        'twinhouse',
        'duplex',
        'penthouse',
        'studio',
        'chalet',
        'clinic',
        'office',
        'shop'
    ])->nullable();

    // المشروع أو المنطقة
    $table->string('project_or_city')->nullable();

    // المساحة المطلوبة
    $table->integer('required_area')->nullable();

    // عدد الغرف
    $table->tinyInteger('bedrooms')->nullable();


    /*
    |--------------------------------------------------------------------------
    | Financial Information
    |--------------------------------------------------------------------------
    */

    $table->enum('budget', [
        'lt_2m',
        '2_4m',
        '4_6m',
        '6_10m',
        '10_20m',
        'gt_20m'
    ])->nullable();

    // طريقة الدفع
    $table->enum('payment_method', [
        'cash',
        'installments',
        'either'
    ])->nullable();

    // المقدم المتوقع
    $table->decimal('expected_down_payment',12,2)->nullable();


    /*
    |--------------------------------------------------------------------------
    | Purchase Timeline
    |--------------------------------------------------------------------------
    */

    $table->enum('purchase_time', [
        'immediately',
        '3_months',
        '6_months',
        '1_year',
        'more_than_year'
    ])->nullable();


    /*
    |--------------------------------------------------------------------------
    | Communication
    |--------------------------------------------------------------------------
    */

    $table->enum('preferred_contact', [
        'call',
        'whatsapp',
        'email'
    ])->nullable();

    $table->enum('contact_time', [
        'morning',
        'afternoon',
        'evening',
        'anytime'
    ])->nullable();


    /*
    |--------------------------------------------------------------------------
    | CRM Information
    |--------------------------------------------------------------------------
    */

    // القديم (للتوافق مع النظام)
    $table->string('source')->nullable();

    // الجديد
    $table->enum('lead_source', [
        'facebook',
        'instagram',
        'google',
        'tiktok',
        'website',
        'whatsapp',
        'referral',
        'broker',
        'walk_in',
        'other'
    ])->nullable();

    $table->enum('lead_status', [
        'new',
        'contacted',
        'qualified',
        'proposal_sent',
        'negotiation',
        'reserved',
        'won',
        'lost'
    ])->default('new');

    $table->foreignId('assigned_employee_id')
        ->nullable()
        ->constrained('users')
        ->nullOnDelete();

    $table->timestamp('last_contact_at')->nullable();

    $table->timestamp('next_follow_up_at')->nullable();

    $table->boolean('agree_marketing')->default(false);

    $table->text('notes')->nullable();


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    $table->foreignId('identity_id')
        ->nullable()
        ->constrained()
        ->nullOnDelete();

    $table->timestamps();

});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
