<?php

namespace App\Livewire;

use App\Rules\ValidAge;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PatientDetails;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Nakanakaii\Countries\Countries;
use Illuminate\Support\Facades\Storage;

class WizardForm extends Component
{
    use WithFileUploads;

    public int $step = 1;
    public $patient_id;
    public $name;
    public $date_of_birth;
    public $emergency_contact_name;
    public $gender;
    public $age;
    public $emergency_phone_no;
    public $emrg_email;
    public bool $allow_notification_emrg_email = false;
    public $emergency_contact_name2;
    public $emergency_phone_no2;
    public $emrg_email2;
    public bool $allow_notification_emrg_email2 = false;
    public $cedula_no;
    public $marital_status;
    public $other_id_document;
    public $home_address;
    public $blood_group;
    public $medical_condition;
    public $primary_doctor;
    public $current_medication;
    public $doctors_no;
    public $doc_email;
    public $primary_doctor2;
    public $doctors_no2;
    public $doc_email2;
    public $medication_allergies;
    public $pet_allergies;
    public $organ_transplant;
    public $food_allergies;
    public $insect_allergies;
    public $removed_organs;
    public $insurance_name;
    public $affiliates;
    public $insurance_plan;
    public $prefered_hospital;
    public $images = [];
    public int $totalsteps = 3;
    public $banners;
    public $countries;

    // protected $rules = [
    //     1 => [
    //         'name' => 'required|string',
    //         'gender' => 'required|string',
    //         'date_of_birth' => 'required|date|before:today',
    //         'emergency_phone_no' => 'required|string',
    //         'home_address' => 'required|string',
    //         'cedula_no' => 'nullable|string',
    //     ],
    //     2 => [
    //         'blood_group' => 'nullable|string',
    //     ],
    //     3 => [
    //         'insurance_name' => 'nullable|string',
    //     ],
    // ];

    protected $listeners = ['updateDateOfBirth'];

    public function updateDateOfBirth()
    {
        $this->age = $this->calculateAge($this->date_of_birth);
    }

    public function calculateAge($value)
    {
        $dob = Carbon::parse($value);
        $currentDate = Carbon::now();
        $calculatedAge = $currentDate->diffInYears($dob);
        $calculatedAge = abs($calculatedAge);
        $calculatedAge = floor($calculatedAge);
        return $calculatedAge;
    }
    public function mount($patientId = null)
    {
        dd("in wizard, patient id:", $patientId);
        $this->countries = Countries::all();
        $patientId = auth()->id();
        if ($patientId) {
            $patientDetails = PatientDetails::where('patient_id', $patientId)->first();
            if ($patientDetails) {
                $this->name = $patientDetails->name;
                $this->date_of_birth = $patientDetails->date_of_birth;
                $this->emergency_contact_name = $patientDetails->emergency_contact_name;
                $this->gender = $patientDetails->gender;
                $this->age = $patientDetails->age;
                $this->emergency_phone_no = $patientDetails->emergency_phone_no;
                $this->emrg_email = $patientDetails->emrg_email;
                $this->allow_notification_emrg_email = $patientDetails->allow_notification_emrg_email;
                $this->emergency_contact_name2 = $patientDetails->emergency_contact_name2;
                $this->emergency_phone_no2 = $patientDetails->emergency_phone_no2;
                $this->emrg_email2 = $patientDetails->emrg_email2;
                $this->allow_notification_emrg_email2 = $patientDetails->allow_notification_emrg_email2;
                $this->cedula_no = $patientDetails->cedula_no;
                $this->marital_status = $patientDetails->marital_status;
                $this->other_id_document = $patientDetails->other_id_document;
                $this->home_address = $patientDetails->home_address;
                $this->blood_group = $patientDetails->blood_group;
                $this->medical_condition = $patientDetails->medical_condition;
                $this->primary_doctor = $patientDetails->primary_doctor;
                $this->current_medication = $patientDetails->current_medication;
                $this->doctors_no = $patientDetails->doctors_no;
                $this->doc_email = $patientDetails->doc_email;
                $this->primary_doctor2 = $patientDetails->primary_doctor2;
                $this->doctors_no2 = $patientDetails->doctors_no2;
                $this->doc_email2 = $patientDetails->doc_email2;
                $this->medication_allergies = $patientDetails->medication_allergies;
                $this->pet_allergies = $patientDetails->pet_allergies;
                $this->organ_transplant = $patientDetails->organ_transplant;
                $this->food_allergies = $patientDetails->food_allergies;
                $this->insect_allergies = $patientDetails->insect_allergies;
                $this->removed_organs = $patientDetails->removed_organs;
                $this->insurance_name = $patientDetails->insurance_name;
                $this->affiliates = $patientDetails->affiliates;
                $this->insurance_plan = $patientDetails->insurance_plan;
                $this->prefered_hospital = $patientDetails->prefered_hospital;
                $this->patient_id = $patientDetails->patient_id;
            }
        }
    }
    // protected function customValidate()
    // {
    //     $this->validate($this->rules[$this->step]);
    // }

    public function render()
    {
        return view('livewire.wizard-form');
    }

    public function prev()
    {
        $this->step--;
    }

    public function next()
    {
        // $this->customValidate();
        $this->step++;

    }

    public function submit()
    {
        // $this->customValidate();
        $patient_id = auth()->id();
        $data = [
            'patient_id' => $patient_id,
            'name' => $this->name === "" ? null : $this->name,
            'date_of_birth' => $this->date_of_birth === "" ? null : $this->date_of_birth,
            'emergency_contact_name' => $this->emergency_contact_name === "" ? null : $this->emergency_contact_name,
            'gender' => $this->gender === "" ? null : $this->gender,
            'age' => $this->age === "" ? null : $this->age,
            'emergency_phone_no' => $this->emergency_phone_no === "" ? null : $this->emergency_phone_no,
            'emrg_email' => $this->emrg_email === "" ? null : $this->emrg_email,
            'allow_notification_emrg_email' => $this->allow_notification_emrg_email === "" ? null : $this->allow_notification_emrg_email,
            'emergency_contact_name2' => $this->emergency_contact_name2 === "" ? null : $this->emergency_contact_name2,
            'emergency_phone_no2' => $this->emergency_phone_no2 === "" ? null : $this->emergency_phone_no2,
            'emrg_email2' => $this->emrg_email2 === "" ? null : $this->emrg_email2,
            'allow_notification_emrg_email2' => $this->allow_notification_emrg_email2 === "" ? null : $this->allow_notification_emrg_email2,
            'cedula_no' => $this->cedula_no === "" ? null : $this->cedula_no,
            'marital_status' => $this->marital_status === "" ? null : $this->marital_status,
            'other_id_document' => $this->other_id_document === "" ? null : $this->other_id_document,
            'home_address' => $this->home_address === "" ? null : $this->home_address,
            'blood_group' => $this->blood_group === "" ? null : $this->blood_group,
            'medical_condition' => $this->medical_condition === "" ? null : $this->medical_condition,
            'primary_doctor' => $this->primary_doctor === "" ? null : $this->primary_doctor,
            'current_medication' => $this->current_medication === "" ? null : $this->current_medication,
            'doctors_no' => $this->doctors_no === "" ? null : $this->doctors_no,
            'doc_email' => $this->doc_email === "" ? null : $this->doc_email,
            'primary_doctor2' => $this->primary_doctor2 === "" ? null : $this->primary_doctor2,
            'doctors_no2' => $this->doctors_no2 === "" ? null : $this->doctors_no2,
            'doc_email2' => $this->doc_email2 === "" ? null : $this->doc_email2,
            'medication_allergies' => $this->medication_allergies === "" ? null : $this->medication_allergies,
            'pet_allergies' => $this->pet_allergies === "" ? null : $this->pet_allergies,
            'organ_transplant' => $this->organ_transplant === "" ? null : $this->organ_transplant,
            'food_allergies' => $this->food_allergies === "" ? null : $this->food_allergies,
            'insect_allergies' => $this->insect_allergies === "" ? null : $this->insect_allergies,
            'removed_organs' => $this->removed_organs === "" ? null : $this->removed_organs,
            'insurance_name' => $this->insurance_name === "" ? null : $this->insurance_name,
            'affiliates' => $this->affiliates === "" ? null : $this->affiliates,
            'insurance_plan' => $this->insurance_plan === "" ? null : $this->insurance_plan,
            'prefered_hospital' => $this->prefered_hospital === "" ? null : $this->prefered_hospital,
        ];

        if ($this->images != []) {
            $fileImages = [];
            foreach ($this->images as $image) {
                $filename = uniqid() . '-' . $image['name'];
                $path = \Storage::disk('public')->putFileAs('images', new \Illuminate\Http\File($image['path']), $filename);
                $fileImages[] = $filename;
            }
            $data['images'] = $fileImages;
        }

        if ($this->patient_id != '') {
            PatientDetails::where('patient_id', $this->patient_id)->update($data);
        } else {
            PatientDetails::create($data);
        }

        return redirect()->route('medical-history');
    }

    public function showPrevButton()
    {
        return $this->step > 1;
    }

    public function showNextButton()
    {
        return $this->step < $this->totalsteps;
    }

    public function showSubmitButton()
    {
        return $this->step === $this->totalsteps;
    }
}

