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
        Schema::create('person', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('countryCode');
            $table->string('stateCode')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('occupation');
            $table->integer('gender');
            $table->string('material')->nullable();
            $table->string('phonecode');
            $table->string('phone')->nullable();
            $table->string('currency');
            $table->string('mail')->nullable();
            $table->integer('age');
            $table->decimal('avgIncome')->defaul(0.00);
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
        Schema::dropIfExists('person');
    }
};
