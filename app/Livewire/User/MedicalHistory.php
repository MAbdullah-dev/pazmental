<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\PatientDetails;
use Illuminate\Support\Facades\Auth;

class MedicalHistory extends Component
{
    public $content;
    public $userId;

    public function mount()
    {
        $this->userId = auth()->id();
        // Check if the patient exists
        $this->content = PatientDetails::where('patient_id', $this->userId)->first();

        // Redirect to the login page if no patient is found
        if ($this->content == null) {
            redirect()->route('login');
        }
    }

    public function render()
    {
        return view('livewire.user.medical-history', ['content' => $this->content]);
    }

    public function SaveExit()
    {
        $userId = auth()->id();
        $userId = encrypt($userId);
        Auth::logout();
        return redirect()->route('DetailsView', ['data' => $userId]);
    }
}
