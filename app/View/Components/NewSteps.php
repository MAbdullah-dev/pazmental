<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewSteps extends Component
{

    public function __construct(
        public bool $vertical = false,
        public ?string $stepsColor = 'step-primary'

    ) {
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <div
                        x-data="{
                                steps: [],
                                current: @entangle($attributes->wire('model')),
                                init() {
                                    // Fix weird issue when navigating back
                                    document.addEventListener('livewire:navigating', () => {
                                        document.querySelectorAll('.step').forEach(el =>  el.remove());
                                    });
                                }
                        }"
                    >
                        <!-- STEP LABELS -->
                        <ul class="steps">
                            <template x-for="(step, index) in steps" :key="index">
                                //:data-content="step.dataContent || (index + 1)"
                                <li  class="step " :class="(index + 1 <= current) && '{{ $stepsColor }} ' + step.classes">

                            <span class="step-icon" x-if="step.dataContent"><img :src="step.dataContent"/></span>


            <span x-html="step.text" class="step-text"></span>
                                </li>
                            </template>
                        </ul>

                        <!-- STEP PANELS-->
                        <div {{ $attributes->whereDoesntStartWith('wire') }}>
                            {{ $slot }}
                        </div>

                        <!-- Force Tailwind compile steps color -->
                        <span class="hidden step-primary step-error step-neutral step-info step-accent"></span>
                    </div>
            HTML;
    }
}
