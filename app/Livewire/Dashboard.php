<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $isPetAcc = false;

    public function mount()
    {
        if (session('petSubAcc')) {
            $this->isPetAcc = true;
        }
        // dd($this->isPetAcc);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
