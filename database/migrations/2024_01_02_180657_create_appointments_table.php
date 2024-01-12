<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained()->references('id')->on('coaches')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('appointment_date_time');
            $table->string('status')->default('upcoming');
            $table->double('rate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
