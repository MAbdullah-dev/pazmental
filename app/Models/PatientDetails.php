<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'images',
        'date_of_birth',
        'emergency_contact_name',
        'gender',
        'age',
        'emergency_phone_no',
        'emrg_email',
        'emergency_contact_name2',
        'emergency_phone_no2',
        'emrg_email2',
        'cedula_no',
        'marital_status',
        'other_id_document',
        'home_address',
        'blood_group',
        'medical_condition',
        'primary_doctor',
        'current_medication',
        'doctors_no',
        'doc_email',
        'primary_doctor2',
        'doctors_no2',
        'doc_email2',
        'medication_allergies',
        'pet_allergies',
        'organ_transplant',
        'food_allergies',
        'insect_allergies',
        'removed_organs',
        'insurance_name',
        'prefered_hospital',
        'affiliates',
        'insurance_plan',
    ];
    protected $casts = [
        'images' => 'array',
    ];
}
