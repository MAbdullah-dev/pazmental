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
        Schema::table('patient_pets', function (Blueprint $table) {
            $table->dropColumn(['sex']);
        });

        Schema::table('patient_pets', function (Blueprint $table) {
            $table->string('sex')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_pets', function (Blueprint $table) {
            $table->dropColumn('sex');
        });
    }
};
