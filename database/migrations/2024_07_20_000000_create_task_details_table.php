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
        Schema::create('task_details', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->integer('t_id');
            $table->integer('u_id');
            $table->string('name');
            $table->string('description');
            $table->date('assign_start_date');
            $table->date('assign_end_date');
            $table->date('finish_start_date')->nullable();
            $table->date('finish_end_date')->nullable();
            $table->timestamps();
            $table->smallinteger('status')->default(1);

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_details');
    }
};
