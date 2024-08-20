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
        Schema::create('meeting_mintues', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->date('meeting_date');
            $table->longText('description');
            $table->integer('host');
            $table->longText('attendees');
            $table->timestamps();
            $table->smallinteger('status')->default(1);

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_mintues');
    }
};
