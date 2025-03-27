<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientPets extends Model
{
    use HasFactory;
    protected $table = 'patient_pets';
    protected $fillable = [
        'patient_id',
        'main_image',
        'images',
        'owner_appeal',
        'name',
        'breed',
        'sex',
        'date_of_birth',
        'age',
        'pet_weight',
        'hair_color',
        'eye_color',
        'social_media',
        'owner_name',
        'owner_phone_no',
        'owner_email',
        'owner_address',
        'owner_friend_phone_no',
        'clinic_name',
        'chip_info',
        'insurance_info',
        'food_allergy',
        'vaccine',
        'neuter_info',
        'other_info',
    ];

}
