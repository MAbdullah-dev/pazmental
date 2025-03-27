<?php

namespace App\Livewire;

use Mary\Traits\Toast;
use Livewire\Component;
use App\Models\Language;
use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

class Translations extends Component
{
    use Toast;

    public $search = '';
    public $lang;
    public $translations;
    public $values = [];
    // public int $record_per_page = 1000;
    protected $listeners = ['translationsUpdated' => '$refresh'];

    public function mount($id)
    {
        $this->lang = Language::findOrFail($id);
        $this->translations = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->get();

        foreach ($this->translations as $translation) {
            $existingTranslation = Translation::where('lang', $this->lang->code)
                ->where('lang_key', $translation->lang_key)
                ->latest()
                ->first();

            if ($existingTranslation) {
                $translation = $existingTranslation;
            }

            $this->values[$translation->lang_key] = $translation->lang_value;
        }
    }

    public function render()
    {
        return view('livewire.translations')
            ->layout('layouts.adminlayout');
    }

    public function searchlang()
    {
        $this->translations = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))
            ->where(function ($query) {
                $query->where('lang_key', 'like', "%{$this->search}%")
                    ->orWhere('lang_value', 'like', "%{$this->search}%");
            })->get();

        // Reinitialize values after search
        foreach ($this->translations as $translation) {
            $existingTranslation = Translation::where('lang', $this->lang->code)
                ->where('lang_key', $translation->lang_key)
                ->latest()
                ->first();

            if ($existingTranslation) {
                $translation = $existingTranslation;
            }

            $this->values[$translation->lang_key] = $translation->lang_value;
        }
    }

    public function save()
    {
        foreach ($this->values as $key => $value) {
            // Fetch the exact translation for the selected language and key
            $translation_def = Translation::where('lang_key', $key)
                ->where('lang', $this->lang->code)
                ->first();

            if ($translation_def) {
                // Update the existing translation
                $translation_def->lang_value = $value;
            } else {
                // Create a new translation if it doesn't exist
                $translation_def = new Translation;
                $translation_def->lang = $this->lang->code;
                $translation_def->lang_key = $key;
                $translation_def->lang_value = $value;
            }

            // Save the translation
            $translation_def->save();
        }

        // Clear the cache for the specific language
        Cache::forget('translations-' . $this->lang->code);

        // Trigger the toast notification
        $this->toast(
            type: 'success',
            title: 'Translations Updated!',
            description: null,
            position: 'toast-top toast-end',
            icon: 'o-check-circle',
            css: 'alert-success',
            timeout: 5000,
            redirectTo: null
        );
    }
}
