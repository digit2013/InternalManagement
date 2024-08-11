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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->decimal('fr_price');
            $table->decimal('to_price');
            $table->smallInteger('type');
            $table->decimal('amount');
            $table->timestamps();
            $table->smallinteger('status')->default(1);

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
