<?php

namespace App\Livewire;

use Livewire\Component;
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

class Adminlogin extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticateadmin();

        Session::regenerate();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.adminlogin')->layout('layouts.unauth');
    }
}
