<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PatientPets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PatientPet extends Component
{
    public $patient_id;
    public $main_image;
    public $images = [];
    public $owner_appeal;
    public $name;
    public $breed;
    public $sex;
    public $date_of_birth;
    public $age;
    public $pet_weight;
    public $hair_color;
    public $eye_color;
    public $social_media;
    public $owner_name;
    public $owner_phone_no;
    public $owner_email;
    public $owner_address;
    public $owner_friend_phone_no;
    public $clinic_name;
    public $chip_info;
    public $insurance_info;
    public $food_allergy;
    public $vaccine;
    public $neuter_info;
    public $other_info;
    public $content;
    public $user_id;


    public function mount()
    {
        if ($data) {
            $this->user_id = base64_decode($data);
        } else {
            $this->user_id = auth()->id();
        }

        dd($this->user_id);


        $this->patient_id = Auth::id();
        $this->content = PatientPets::where('patient_id', Auth::id())->first();
        if ($this->content) {
            $this->owner_appeal = $this->content['owner_appeal'];
            $this->name = $this->content['name'];
            $this->breed = $this->content['breed'];
            $this->sex = $this->content['sex'];
            $this->date_of_birth = $this->content['date_of_birth'];
            $this->age = $this->content['age'];
            $this->hair_color = $this->content['hair_color'];
            $this->pet_weight = $this->content['pet_weight'];
            $this->eye_color = $this->content['eye_color'];
            $this->social_media = $this->content['social_media'];
            $this->owner_name = $this->content['owner_name'];
            $this->owner_phone_no = $this->content['owner_phone_no'];
            $this->owner_email = $this->content['owner_email'];
            $this->owner_address = $this->content['owner_address'];
            $this->owner_friend_phone_no = $this->content['owner_friend_phone_no'];
            $this->clinic_name = $this->content['clinic_name'];
            $this->chip_info = $this->content['chip_info'];
            $this->insurance_info = $this->content['insurance_info'];
            $this->food_allergy = $this->content['food_allergy'];
            $this->vaccine = $this->content['vaccine'];
            $this->neuter_info = $this->content['neuter_info'];
            $this->other_info = $this->content['other_info'];
        }
    }
    protected $listeners = ['updateDateOfBirth'];

    public function updateDateOfBirth()
    {
        $this->age = $this->calculateAge($this->date_of_birth);
    }

    public function calculateAge($value)
    {
        $dob = Carbon::parse($value);
        $currentDate = Carbon::now();
        $years = $dob->diffInYears($currentDate);
        $dob->addYears($years);
        $months = $dob->diffInMonths($currentDate);
        $dob->addMonths($months);
        $days = $dob->diffInDays($currentDate);
        $years = abs($years);
        $months = abs($months % 12);
        $days = abs($days);
        $years = floor($years);
        $months = floor($months);
        $days = floor($days);
        if ($years > 0) {
            return "$years years, $months months, $days days";
        } elseif ($years <= 0 && $months > 0) {
            return "$months months, $days days";
        } elseif ($years <= 0 && $months <= 0) {
            return "$days days";
        }
    }
    public function submit()
    {
        // $this->validate();

        $data = [
            'patient_id' => $this->patient_id,
            'owner_appeal' => $this->owner_appeal,
            'name' => $this->name,
            'breed' => $this->breed,
            'sex' => $this->sex,
            'date_of_birth' => $this->date_of_birth,
            'age' => $this->age,
            'pet_weight' => $this->pet_weight,
            'hair_color' => $this->hair_color,
            'eye_color' => $this->eye_color,
            'social_media' => $this->social_media,
            'owner_name' => $this->owner_name,
            'owner_phone_no' => $this->owner_phone_no,
            'owner_email' => $this->owner_email,
            'owner_address' => $this->owner_address,
            'owner_friend_phone_no' => $this->owner_friend_phone_no,
            'clinic_name' => $this->clinic_name,
            'chip_info' => $this->chip_info,
            'insurance_info' => $this->insurance_info,
            'food_allergy' => $this->food_allergy,
            'vaccine' => $this->vaccine,
            'neuter_info' => $this->neuter_info,
            'other_info' => $this->other_info,
        ];
        // Handle images upload
        if (!empty($this->images)) {
            $fileImages = [];
            foreach ($this->images as $image) {
                // Generate a random name with the file extension
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension; // Random unique name
                $path = \Storage::disk('public')->putFileAs('images', new \Illuminate\Http\File($image['path']), $filename);
                $fileImages[] = $filename;  // Store filenames in an array
            }
            $data['images'] = json_encode($fileImages);  // Store as JSON array in database
        }

        if ($this->main_image != []) {
            $fileImages = '';
            foreach ($this->main_image as $image) {
                // Generate a random name with the file extension
                $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension; // Random unique name
                $path = \Storage::disk('public')->putFileAs('images', new \Illuminate\Http\File($image['path']), $filename);
                $fileImages = $filename;
            }
            $data['main_image'] = json_encode($fileImages);
        }
        if ($this->content) {
            if ($this->content['id'] != '') {
                PatientPets::where('patient_id', $this->patient_id)->update($data);
            } else {
                PatientPets::create($data);
            }
        } else {
            PatientPets::create($data);
        }
        return redirect()->route('pet-history');
    }

    public function render()
    {
        return view('livewire.patient-pet');
    }
}
