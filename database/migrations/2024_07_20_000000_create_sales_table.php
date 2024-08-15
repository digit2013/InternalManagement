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
        Schema::create('sales', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('warehouse_id');
            $table->string('invoice_id');
            $table->integer('stock_id');
            $table->decimal('unit_price');
            $table->decimal('discount_amt');
            $table->decimal('amount');
            $table->integer('qty');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->smallinteger('status')->default(1);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
