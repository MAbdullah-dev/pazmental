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
        Schema::create('patient_pets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('patient_id')->nullable();
            $table->string('name');
            $table->string('breed');
            $table->string('age');
            $table->string('social_media');
            $table->string('owner_name');
            $table->string('owner_phone_no');
            $table->string('owner_email')->nullable();
            $table->string('owner_message')->nullable();
            $table->text('owner_address');
            $table->string('owner_friend_name')->nullable();
            $table->string('owner_friend_phone_no')->nullable();
            $table->string('vaccine')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('reward_notice')->nullable();
            $table->string('chip_info')->nullable();
            $table->string('neuter_info')->nullable();
            $table->string('food_allergy')->nullable();
            $table->string('other_info')->nullable();
            // Additional Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_pets');
    }
};
