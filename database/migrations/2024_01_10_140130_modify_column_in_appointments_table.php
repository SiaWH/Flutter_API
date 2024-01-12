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
        // Schema::dropIfExists('appointments');
        Schema::table('users', function (Blueprint $table) {
            // Add your new column here
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained()->references('id')->on('coaches')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->cascadeOnDelete();
            $table->dateTime('appointment_date_time');
            $table->string('status')->default('upcoming');
            $table->double('rate')->nullable();
            $table->timestamps();
        });
    }
};
