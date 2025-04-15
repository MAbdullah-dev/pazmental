<?php

namespace App\Livewire;

use App\Models\PatientPets;
use Livewire\Component;

class PetDetails extends Component
{
        public $user_id;
    public $content;

    public function mount($data)
    {
        dd($data);
    }
    public function render()
    {
        $content = PatientPets::where('patient_id', auth()->id())->first();
        return view('livewire.pet-details', compact('content'));
    }
}
