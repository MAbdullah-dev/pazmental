<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Wordpress\Post;


class Faqs extends Component
{
    public $faqs;
    public function mount() {
        $this->faqs = Post::type('faq')->get();
    }
    public function render()
    {

        return view('livewire.user.faqs');
    }
}
