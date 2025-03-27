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
        Schema::create('patient_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            // Step 1: Personal Information
            $table->json('images')->nullable();
            $table->string('name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('emergency_phone_no')->nullable();
            $table->string('emrg_email')->nullable();
            $table->string('emergency_contact_name2')->nullable();
            $table->string('emergency_phone_no2')->nullable();
            $table->string('emrg_email2')->nullable();
            $table->string('cedula_no')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('other_id_document')->nullable();
            $table->text('home_address')->nullable();

            // Step 2: Medical History
            $table->string('blood_group')->nullable();
            $table->string('primary_doctor')->nullable();
            $table->string('current_medication')->nullable();
            $table->string('doctors_no')->nullable();
            $table->string('doc_email')->nullable();
            $table->string('primary_doctor2')->nullable();
            $table->string('doctors_no2')->nullable();
            $table->string('doc_email2')->nullable();
            $table->json('medication_allergies')->nullable();
            $table->json('pet_allergies')->nullable();
            $table->json('organ_transplant')->nullable();
            $table->json('food_allergies')->nullable();
            $table->json('insect_allergies')->nullable();
            $table->json('removed_organs')->nullable();

            // Step 3: Health Insurance Plan
            $table->string('insurance_name')->nullable();
            $table->integer('affiliates')->nullable();
            $table->integer('insurance_plan')->nullable();
            $table->string('prefered_hospital')->nullable();

            // Additional Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_details');
    }
};
