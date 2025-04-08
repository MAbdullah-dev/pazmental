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
            $table->dropColumn(['affiliates', 'insurance_plan']);
        });

        Schema::table('patient_details', function (Blueprint $table) {
            $table->string('affiliates')->nullable();
            $table->string('insurance_plan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_details', function (Blueprint $table) {
            $table->dropColumn('affiliates');
            $table->dropColumn('insurance_plan');
        });
    }
};
