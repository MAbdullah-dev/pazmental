<section class="faqs py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="heading my-9">
            <h2
                class="dark:text-white py-2 text-2xl md:text-3xl xl:text-4xl leading-[1.2] text-black font-semibold text-center">
                @translate('Frequently Asked Questions')</h2>
        </div>
        @if(count($faqs) > 0)
        <div class="accordion" id="accordionExample">
            @foreach ($faqs as  $key => $faq)
            @php
                $step=$key+1;
            @endphp
            <!-- Accordion 1 -->
            <div class="accordion-item bg-white dark:bg-gray-900 rounded-lg mb-4">
                <h2 class="accordion-header mb-0" id="heading{{ $key }}">
                    <button
                        class="rounded-2xl accordion-button flex flex-col dark:text-white text-[#000] font-semibold text-left bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] collapsed relative w-full py-4 px-5 text-base text-white text-[20px] sm:text-[22px] leading-tight transition focus:outline-none"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                        aria-controls="collapse{{ $key }}">
                        <div class="head flex items-center justify-between w-[100%]">@lang('Step -'.$step.'')<i
                                class='bx bx-chevron-down text-4xl '></i></div>
                        <div class="flex flex-col">
                            <span class="text-[16px] sm:text-[18px] text-white font-semibold">{{ $faq->post_title }}</span>
                            <span class="text-[14px] sm:text[16px] text-[#ffffffb8] font-semibold">{{ $faq->meta->question_description??'' }}</span>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] py-4 px-5">
                        <div class="flex flex-col">
                            {!! $faq->post_content !!}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
