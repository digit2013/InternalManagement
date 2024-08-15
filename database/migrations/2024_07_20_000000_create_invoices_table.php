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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('warehouse_id');
            $table->string('invoice_id');
            $table->integer('customer_id');
            $table->integer('discount_id');
            $table->decimal('commission');
            $table->smallinteger('price_type');
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
        Schema::dropIfExists('invoices');
    }
};
