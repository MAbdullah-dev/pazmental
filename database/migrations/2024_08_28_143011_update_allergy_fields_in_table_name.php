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
        Schema::table('patient_details', function (Blueprint $table) {
            $table->dropColumn(['medication_allergies', 'pet_allergies', 'organ_transplant', 'food_allergies', 'insect_allergies', 'removed_organs']);
        });

        Schema::table('patient_details', function (Blueprint $table) {
            $table->text('medication_allergies')->nullable();
            $table->text('pet_allergies')->nullable();
            $table->text('organ_transplant')->nullable();
            $table->text('food_allergies')->nullable();
            $table->text('insect_allergies')->nullable();
            $table->text('removed_organs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_details', function (Blueprint $table) {
            $table->dropColumn('medication_allergies');
            $table->dropColumn('pet_allergies');
            $table->dropColumn('organ_transplant');
            $table->dropColumn('food_allergies');
            $table->dropColumn('insect_allergies');
            $table->dropColumn('removed_organs');
        });
    }
};
