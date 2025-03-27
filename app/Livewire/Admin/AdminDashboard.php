<?php

namespace App\Livewire\Admin;

use App\Models\Language;
use Livewire\Component;
use Mary\Traits\Toast;

class AdminDashboard extends Component
{
    use Toast;

    public $defaultlang;

    public function mount() {
        $this->defaultlang=env('DEFAULT_LANGUAGE');
    }
    public function delete($id)
    {
        $lang= Language::where('id', $id)->firstOrFail();
        $lang->translations()->delete();
        $lang->delete();

        $this->toast(
            type: 'success',
            title: 'Language Deleted!',
            description: null,                  // optional (text)
            position: 'toast-top toast-end',    // optional (daisyUI classes)
            icon: 'o-information-circle',       // Optional (any icon)
            css: 'alert-success',                  // Optional (daisyUI classes)
            timeout: 5000,                      // optional (ms)
            redirectTo: null                    // optional (uri)
        );
    }


    public function overWriteEnvFile($key, $value)
    {
        $path = base_path('.env');

        $envContent = file_get_contents($path);

        $newLine = "$key=$value";

        if (strpos($envContent, "$key=") !== false) {
            $envContent = preg_replace("/^$key=.*$/m", $newLine, $envContent);
        } else {
            $envContent .= "\n$newLine";
        }

        file_put_contents($path, $envContent);
    }


    public function env_key_update()
    {
        $this->validate(['defaultlang' => 'required|string']);

        $this->overWriteEnvFile('DEFAULT_LANGUAGE', $this->defaultlang);
        $this->toast(
            type: 'success',
            title: 'Default Language Updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-success',
            timeout: 5000,
            redirectTo: null
        );
    }
    public function render()
    {
        $langaues = Language::get();
        return view('livewire.admindashboard', ['lang' => $langaues])
            ->layout('layouts.adminlayout');
    }
}
