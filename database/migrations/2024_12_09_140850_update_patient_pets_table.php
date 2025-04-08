<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePatientPetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('patient_pets');

        // Recreate the table with the updated fields
        Schema::create('patient_pets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            $table->string('main_image')->nullable(); // Field for the main image
            $table->json('images')->nullable(); // JSON field for multiple images
            $table->longText('owner_appeal')->nullable(); // Long text for owner appeal
            $table->string('name')->nullable();
            $table->string('breed')->nullable();
            $table->integer('sex')->nullable(); // Assume sex as 0 = Male, 1 = Female
            $table->date('date_of_birth')->nullable();
            $table->string('age')->nullable();
            $table->integer('pet_weight')->nullable();
            $table->string('hair_color')->nullable();
            $table->string('eye_color')->nullable();
            $table->string('social_media')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone_no')->nullable();
            $table->string('owner_email')->nullable();
            $table->text('owner_address')->nullable();
            $table->string('owner_friend_phone_no')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('chip_info')->nullable();
            $table->string('insurance_info')->nullable();
            $table->longText('food_allergy')->nullable(); // Long text for detailed allergy info
            $table->string('vaccine')->nullable();
            $table->string('neuter_info')->nullable();
            $table->string('other_info')->nullable();
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table when rolling back
        Schema::dropIfExists('patient_pets');
    }
}
