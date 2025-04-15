<?php

namespace App\Livewire;

use App\Models\PatientPets;
use Livewire\Component;

class PetDetails extends Component
{
        public $user_id;
    public $content;

    public function mount($data = null)
    {
        if ($data) {
            $this->user_id = base64_decode($data);
        } else {
            $this->user_id = auth()->id();
        }

        dd($this->user_id);

    }
    public function render()
    {
        $content = PatientPets::where('patient_id', auth()->id())->first();
        return view('livewire.pet-details', compact('content'));
    }
}
