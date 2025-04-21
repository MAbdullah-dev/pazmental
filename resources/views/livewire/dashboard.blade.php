<div>
    <div class="text-center absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] p-6">
        <h2 class="dark:text-white py-2 text-[48px] text-[#000] font-semibold">@translate('Welcome')</h2>
        <h3 class="dark:text-white py-2 text-[24px] text-[#000] font-semibold">@translate('You Found ESCANAME')</h3>
        <p class="dark:text-white py-2 uppercase text-[16px] text-[#000] font-semibold">
            @translate('My Personal Emergency Response RecordTM')</p>
        <p class="dark:text-white py-2 text-[16px] text-[#000] font-semibold">@translate('A solution by Paz Mental')</p>
        @if (get_user_products())
            @php
                $details_added = 0;
                if (getPatient(auth()->id()) != null) {
                    $details_added = 1;
                }
            @endphp
            <div class="flex gap-2 mb-5 gradient_icons_wrapper_dashboard pl-0">
                <img src="{{ asset('assets/images/prelogo.svg') }}"
                    class="block dark:hidden h-16 w-auto fill-current text-gray-800 dark:text-gray-200 gradient_icons_dashboard"
                    alt="">
                <img src="{{ asset('assets/images/prelogodark.svg') }}"
                    class="hidden dark:block h-16 w-auto fill-current text-gray-800 dark:text-gray-200 gradient_icons_dashboard"
                    alt="">
                <a href="{{ $details_added == 1 ? route('medical-history') : route('wizard') }}"
                    class="flex w-fit mx-auto my-4 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white capitalize">
                    @if ($details_added == 1)
                        @translate('Your Medical History')
                    @else
                        @translate('Añade tus datos')
                    @endif
                </a>
            </div>

        @endif
        @if (get_user_products('pet') || $isPetAcc)
            @php
                $details_added = 0;

                if (getPatientpet(auth()->id()) != null) {
                    $details_added = 1;
                }
            @endphp
            <div class="flex gap-2 mb-5 gradient_icons_wrapper_dashboard pl-0">
                <img src="{{ asset('assets/images/petlogodark.svg') }}"
                    class="block dark:hidden h-16 w-auto fill-current text-gray-800 dark:text-gray-200 gradient_icons_dashboard"
                    alt="">
                <img src="{{ asset('assets/images/petlogo.svg') }}"
                    class="hidden dark:block h-16 w-auto fill-current text-gray-800 dark:text-gray-200 gradient_icons_dashboard"
                    alt="">
                <a href="{{ $details_added == 1 ? route('pet-history') : route('PatientPet') }}"
                    class="flex w-fit mx-auto my-4 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white capitalize">
                    @if ($details_added == 1)
                        @translate('MiRPRE Pet History')
                    @else
                        @translate('Agregar detalles de mascota MiRPRE')
                    @endif
                </a>
            </div>
        @endif
    </div>
    <canvas id="party-welcome"></canvas>
</div>
@push('js')
    <script src="{{ asset('assets/js/party-welcome.js') }}"></script>
@endpush
