<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\PatientDetails;
use Illuminate\Support\Facades\Auth;

class DetailsView extends Component
{
    public $data;
    public $userId;
    public $content;

    public function mount($data)
    {
        $id = decrypt($data);
        $this->userId = $id;
        $this->content = PatientDetails::where('patient_id', $this->userId)->first();
    }

    public function render()
    {
        $view = 'livewire.user.medical-history';

        return view($view, ['content' => $this->content]);
    }

}
