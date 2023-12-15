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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->double('height')->nullable();
            $table->double('weight')->nullable();
            $table->double('basal_metabolism')->nullable();
            $table->double('BMI')->nullable();
            $table->string('gender')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age');
            $table->dropColumn('height');
            $table->dropColumn('weight');
            $table->dropColumn('basal_metabolism');
            $table->dropColumn('BMI');
            $table->dropColumn('gender');
        });
    }
};
