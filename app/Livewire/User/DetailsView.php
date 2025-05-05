<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\PatientDetails;
use App\Models\PatientPets;
use Illuminate\Support\Facades\Auth;

class DetailsView extends Component
{
    public $data;
    public $userId;
    public $content;
    public $locationObtained;

    public function mount($data)
    {
        $id = decrypt($data);
        $this->userId = $id;
        $this->content = PatientDetails::where('patient_id', $this->userId)->first() ?? PatientPets::where('patient_id', $this->userId)->first();

    }

    public function render()
    {
        $this->locationObtained = true;

        $view = 'livewire.user.medical-history';

        return view($view, ['content' => $this->content]);
    }

}
