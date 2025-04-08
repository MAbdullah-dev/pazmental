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
            // Adding allow_notification fields after emergency emails
            $table->boolean('allow_notification_emrg_email')->default(false)->after('emrg_email');
            $table->boolean('allow_notification_emrg_email2')->default(false)->after('emrg_email2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_details', function (Blueprint $table) {
            // Dropping the allow_notification fields
            $table->dropColumn(['allow_notification_emrg_email', 'allow_notification_emrg_email2']);
        });
    }
};
