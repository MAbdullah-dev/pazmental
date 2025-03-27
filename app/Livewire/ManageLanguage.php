<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Language;
use Illuminate\Http\Request;



class ManageLanguage extends Component
{
    public $lang;
    public $id;
    public $code;
    public $update = 0;

    public function mount($id = null)
    {
        if ($id != null) {
            $this->id = $id;
            $language = Language::findOrFail($this->id);
            $this->lang = $language->name;
            $this->code = $language->code;
            $this->update = 1;
        }
    }
    public function submit()
    {

        if ($this->update == 1) {
            $this->validate([
                'lang' => 'required|string',
                'code' => 'required|string|unique:languages,code,' . $this->id
            ]);

            Language::where('id', $this->id)->update([
                'name' => $this->lang,
                'code' => $this->code
            ]);
        } else {
            $this->validate([
                'lang' => 'required|string',
                'code' => 'required|string|unique:languages,code'
            ]);
            Language::create([
                'name' => $this->lang,
                'code' => $this->code
            ]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.manage-language')
            ->layout('layouts.adminlayout');
    }

    public function changeLanguage(Request $request)
    {
        session()->put('locale', $request->locale);
    }
}
