<?php
// database/migrations/xxxx_create_cart_items_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->decimal('height', 10, 2); // ارتفاع العميل
            $table->decimal('weight', 10, 2); // وزن العميل
            $table->integer('quantity')->default(1);
            $table->decimal('price_snapshot', 10, 2); // سعر المنتج وقت الإضافة
            $table->json('options')->nullable(); // لون، مقاس، ...الخ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
