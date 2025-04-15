<section class="medical-history py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $locale = session()->get('locale');
            dd($data);
        @endphp
        <div class="flex justify-center">
            @if ($locale == 'es')
                <img src="{{ asset('assets/images/petsdarkspanish.svg') }}"
                    class="block dark:hidden h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200"
                    alt="">
                <img src="{{ asset('assets/images/petsspanish.svg') }}"
                    class="hidden dark:block h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200"
                    alt="">
            @else
                <img src="{{ asset('assets/images/petsdarkeng.svg') }}"
                    class="block dark:hidden h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200"
                    alt="">
                <img src="{{ asset('assets/images/petseng.svg') }}"
                    class="hidden dark:block h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200"
                    alt="">
            @endif
        </div>
        <div class="heading my-4 sm:my-9">
            <h2
                class="dark:text-white py-2 text-2xl md:text-3xl xl:text-4xl leading-[1.2] text-black font-semibold text-center">
                @translate('Pet\'s Emergency Response Record')
            </h2>
            <h5 class="dark:text-white py-2 text-[24px] text-[#000] font-semibold text-center">
                @translate('Return me to My Owner, please!')
            </h5>
            <p class="dark:text-white py-2 text-[16px] text-[#000] font-[500] text-center">
                @translate('"This beloved pet loves its Owner."')
            </p>
        </div>
        <div class="flex justify-center mb-5 mt-8 gap-3 sm:gap-8">
            <div class="section_icons_wrapper">
                <img src="{{ asset('assets/images/petdetail.svg') }}" class="h-12 sm:h-16 w-auto hidden dark:block"
                    alt="">
                <img src="{{ asset('assets/images/petdetaildark.svg') }}" class="h-12 sm:h-16 w-auto block dark:hidden"
                    alt="">
                <h5
                    class="dark:text-white py-2 text-[16px] sm:text-[18px] lg:text-[22px] text-[#000] font-semibold text-center">
                    @translate('Pet Details')
                </h5>
            </div>
            <div class="section_icons_wrapper">
                <img src="{{ asset('assets/images/petowner.svg') }}" class="h-12 sm:h-16 w-auto hidden dark:block"
                    alt="">
                <img src="{{ asset('assets/images/petownerdark.svg') }}" class="h-12 sm:h-16 w-auto block dark:hidden"
                    alt="">
                <h5
                    class="dark:text-white py-2 text-[16px] sm:text-[18px] lg:text-[22px] text-[#000] font-semibold text-center">
                    @translate('Owner Details')
                </h5>
            </div>
            <div class="section_icons_wrapper">
                <img src="{{ asset('assets/images/pethealth.svg') }}" class="h-12 sm:h-16 w-auto hidden dark:block"
                    alt="">
                <img src="{{ asset('assets/images/pethealthdark.svg') }}" class="h-12 sm:h-16 w-auto block dark:hidden"
                    alt="">
                <h5
                    class="dark:text-white py-2 text-[16px] sm:text-[18px] lg:text-[22px] text-[#000] font-semibold text-center">
                    @translate('Health Details')
                </h5>
            </div>
        </div>
        <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[48px] lg:p-[82px] mt-32">
            <div
                class="profile-image inline-flex flex-col w-fit mx-auto items-center  translate-y-[-40%] translate-x-[-50%] absolute left-[50%] top-0">
                <a href=""
                    class="mb-4 flex flex-col items-center rounded-2xl p-[10px] sm:p-[15px] bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                    <div
                        class="image-wrapper flex p-[3px] rounded-[50%] bg-white mb-2 w-[150px] h-[150px] overflow-hidden">
                        @if (optional($content)->main_image)
                            <img src="{{ asset('storage/images/' . json_decode(optional($content)->main_image)) }}"
                                alt="" class="object-cover w-[100%] h-[100%] rounded-[50%] overflow-hidden">
                        @else
                            <p class="text-center text-red-500">N/A</p>
                        @endif
                    </div>
                </a>
            </div>
            <div class="grid_images">
                @php
                    $images = optional($content)->images ? json_decode(optional($content)->images, true) : [];
                @endphp
                @if ($images)
                    @foreach ($images as $image)
                        <img src="{{ asset('storage/images/' . $image) }}" alt=""
                            class="object-cover w-[100%] h-[100%]">
                    @endforeach
                @else
                    <p class="text-center text-red-500">N/A</p>
                @endif
            </div>

            <div class="head mt-12 sm:mt-12 text-center mb-8">
                <p class="dark:text-white uppercase text-[16px]  text-[#000] font-semibold">
                    {{ optional($content)->owner_appeal === null || optional($content)->owner_appeal === '' ? 'N/A' : optional($content)->owner_appeal }}
                </p>
            </div>
            <div class="field-groups">
                @php
                    $petDetailsKeys = [
                        'name',
                        'breed',
                        'sex',
                        'date_of_birth',
                        'age',
                        'pet_weight',
                        'hair_color',
                        'eye_color',
                        'social_media',
                    ];
                    $ownerKeys = [
                        'owner_name',
                        'owner_phone_no',
                        'owner_email',
                        'owner_address',
                        'owner_friend_phone_no',
                    ];
                    $healthKeys = [
                        'clinic_name',
                        'chip_info',
                        'insurance_info',
                        'food_allergy',
                        'vaccine',
                        'neuter_info',
                        'other_info',
                    ];
                @endphp
                <div
                    class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                    <img src="{{ asset('assets/images/petdetail.svg') }}" class="gradient_icons block" alt="">
                    <h2
                        class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                        @translate('Pet Information')
                    </h2>
                </div>
                <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                    @foreach ($petDetailsKeys as $key)
                        <div class="flex items-start flex-col pl-2">
                            <div class="span-wrapper">
                                <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                    @translate(ucwords(str_replace('_', ' ', $key))) :
                                </span>
                                <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                    {{ optional($content)->$key === null || optional($content)->$key === '' ? 'N/A' : optional($content)->$key }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                    <img src="{{ asset('assets/images/petowner.svg') }}" class="gradient_icons block" alt="">
                    <h2
                        class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                        @translate('Owner Information')
                    </h2>
                </div>
                <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                    @foreach ($ownerKeys as $key)
                        <div class="flex items-start flex-col pl-2">
                            <div class="span-wrapper">
                                <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                    @translate(ucwords(str_replace('_', ' ', $key))) :
                                </span>
                                <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                    {{ optional($content)->$key === null || optional($content)->$key === '' ? 'N/A' : optional($content)->$key }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                    <img src="{{ asset('assets/images/pethealth.svg') }}" class="gradient_icons block" alt="">
                    <h2
                        class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                        @translate('Health Information')
                    </h2>
                </div>
                <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                    @foreach ($healthKeys as $key)
                        <div class="flex items-start flex-col pl-2">
                            <div class="span-wrapper">
                                <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                    @translate(ucwords(str_replace('_', ' ', $key))) :
                                </span>
                                <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                    {{ optional($content)->$key === null || optional($content)->$key === '' ? 'N/A' : optional($content)->$key }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @auth
            <div class="flex justify-center  gap-2">
                <a href="{{ route('PatientPet') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white ">@translate('Edit')</a>
                <a href="{{ route('SaveExit') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-8 sm:px-10 py-2 text-white ">@translate('Save & Exit')</a>
            </div>
        @endauth
    </div>
    <script>
        let scrollTimeout;

        // Function to redirect the user after 30 seconds of inactivity
        function redirectToUrl() {
            window.location.href = '/suspenedqr'; // Replace with your desired URL
        }

        // Reset scroll timer whenever user scrolls
        function resetScrollTimer() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(redirectToUrl, 180000); // 30 seconds
        }

        // Event listener for scroll activity
        window.addEventListener('scroll', resetScrollTimer);

        // Set the initial timer for inactivity
        scrollTimeout = setTimeout(redirectToUrl, 180000); // 30 seconds
    </script>
</section>
