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
        Schema::create('nutrient_intakes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('food_id')->constrained()->references('id')->on('foods')->onDelete('cascade');
            $table->integer('kcal')->default(0);
            $table->integer('protein')->default(0);
            $table->integer('carbs')->default(0);
            $table->integer('fibre')->default(0);
            $table->integer('fats')->default(0);
            $table->integer('water')->default(0);
            $table->double('grams')->default(0);
            $table->dateTime('intake_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrient_intakes');
    }
};
