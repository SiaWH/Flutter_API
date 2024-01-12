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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->string('image')->nullable();
            $table->integer('age')->nullable();
            $table->String('gender')->nullable();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->double('basal_metabolism')->default(0);
            $table->double('BMI')->nullable();
            $table->integer('lvl')->default(1);
            $table->integer('lvl-stream')->default(0);
            $table->double('experience')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->integer('status')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
