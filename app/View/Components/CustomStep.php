<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomStep extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $step,
        public string $text,
        public ?string $label = null,
        public ?string $stepClasses = null,
        public ?string $dataContent = null,

    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {


        return <<<'HTML'
                    <div
                        class="hidden"
                        x-init="steps.push({ step: '{{ $step }}', text: '{{ $text }}', classes: '{{ $stepClasses }}' @if($dataContent), dataContent: '{{ $dataContent }}' @endif })"
                    >

                </div>

                    <div x-show="current == '{{ $step }}'" {{ $attributes->class("px-1") }} >
                        {{ $slot }}
                    </div>
            HTML;
    }
}
