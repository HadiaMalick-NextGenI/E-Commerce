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
        Schema::table('products', function (Blueprint $table) {
            $table->enum('discount_type', ['flat', 'percentage'])->nullable()->after('price');
            $table->decimal('discount_percentage', 5, 2)->nullable()->after('discount_type');
            $table->decimal('discount_price', 10, 2)->nullable()->after('discount_percentage');
            $table->timestamp('discount_end_date')->nullable()->after('discount_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('discount_price');
            $table->dropColumn('discount_end_date');
        });
    }
};