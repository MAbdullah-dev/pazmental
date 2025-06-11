<section wire:ignore.self class="medical-history py-10">
    <div>
        <div class="emergency-notice">
            SOLO PARA USO EN CASO DE EMERGENCIA:
        </div>

        <div class="watermark">
            información confidencial del paciente - {{ now()->format('F j, Y, g:i A') }}
        </div>
    </div>
    <div id="locationOverlay"
        class="{{ $locationObtained ? 'hidden' : '' }} fixed inset-0 bg-gray-800 bg-opacity-75 flex flex-col items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow text-center">
            <h2 class="text-lg font-semibold mb-4">La ubicación es obligatoria. </h2>
            <p class="mb-4"> Por favor, permita el acceso a la ubicación para acceder al historial médico.</p>
            <button id="allowLocation" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Permitir ubicación
            </button>
            <p id="locationError" class="text-red-500 mt-4 hidden"></p>
            <div id="iosInstructions" class="hidden text-sm text-gray-600 mt-2">
                If you are using iPhone/iPad, please allow location in Safari settings.
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $locale = session()->get('locale');
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
                        class="image-wrapper flex p-[3px] rounded-[50%] bg-white mb-2 w-[180px] h-[180px] overflow-hidden">
                        @php
                            $user_id = $content['patient_id'];
                        @endphp
                        <img src="{{ asset('storage/images/' . json_decode($content['main_image'])) }}" alt=""
                            class="object-cover w-[100%] h-[100%] rounded-[50%] overflow-hidden">
                    </div>
                </a>
            </div>
            <div class="grid_images">
                @foreach (collect(json_decode($content['images'], true)) as $image)
                    <img src="{{ asset('storage/images/' . $image) }}" alt=""
                        class="object-cover w-[100%] h-[100%]">
                @endforeach
            </div>

            <div class="head mt-12 sm:mt-12 text-center mb-8">
                <p class="dark:text-white uppercase text-[16px]  text-[#000] font-semibold">
                    {{ $content['owner_appeal'] }}
                </p>
            </div>
            <div class="field-groups">
                @php
                    $filteredAttributes = $content->getAttributes();

                    // dd($filteredAttributes);

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

                    // Filter the attributes and keep only the non-empty ones
                    $attributes = array_filter(
                        array_intersect_key($filteredAttributes, array_flip($petDetailsKeys)),
                        function ($value) {
                            return !empty($value);
                        },
                    );

                    $attributes1 = array_filter(
                        array_intersect_key($filteredAttributes, array_flip($ownerKeys)),
                        function ($value) {
                            return !empty($value);
                        },
                    );

                    $attributes2 = array_filter(
                        array_intersect_key($filteredAttributes, array_flip($healthKeys)),
                        function ($value) {
                            return !empty($value);
                        },
                    );
                    // dd($attributes, $attributes1, $attributes2, $filteredAttributes);
                @endphp
                @if (!empty($attributes))
                    <div
                        class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                        <img src="{{ asset('assets/images/petdetail.svg') }}" class="gradient_icons block"
                            alt="">
                        <h2
                            class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                            @translate('Pet Information')
                        </h2>
                    </div>
                    <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                        @foreach ($attributes as $key => $value)
                            @if (!empty($value))
                                <div class="flex items-start flex-col pl-2">
                                    <div class="span-wrapper">
                                        <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                            @translate(ucwords(str_replace('_', ' ', $key))) :
                                        </span>
                                        <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                            {{ $value ?? 'No Data Available' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if (!empty($attributes1))
                    <div
                        class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                        <img src="{{ asset('assets/images/petowner.svg') }}" class="gradient_icons block"
                            alt="">
                        <h2
                            class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                            @translate('Owner Information')
                        </h2>
                    </div>
                    <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                        @foreach ($attributes1 as $key => $value)
                            @if (!empty($value))
                                <div class="flex items-start flex-col pl-2">
                                    <div class="span-wrapper">
                                        <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                            @translate(ucwords(str_replace('_', ' ', $key))) :
                                        </span>
                                        <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                            {{ $value ?? 'No Data Available' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if (!empty($attributes2))
                    <div
                        class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                        <img src="{{ asset('assets/images/pethealth.svg') }}" class="gradient_icons block"
                            alt="">
                        <h2
                            class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase">
                            @translate('Health Information')
                        </h2>
                    </div>
                    <div class="information-wrapper grid gap-4 grid-cols-1 sm:grid-cols-2 px-2">
                        @foreach ($attributes2 as $key => $value)
                            @if (!empty($value))
                                <div class="flex items-start flex-col pl-2">
                                    <div class="span-wrapper">
                                        <span class="text-[16px] dark:text-white text-[#000] font-semibold">
                                            @translate(ucwords(str_replace('_', ' ', $key))) :
                                        </span>
                                        <span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">
                                            {{ $value ?? 'No Data Available' }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @auth
            <div class="flex justify-center  gap-2">
                <a href="{{ route('PatientPet') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white ">@translate('Edit')</a>
                <a href="{{ route('SaveExit') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-8 sm:px-10 py-2 text-white ">@translate('Save
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        & Exit')</a>
            </div>
        @endauth
    </div>
    <script>
        // Disable right-click
        document.addEventListener('contextmenu', event => event.preventDefault());

        // Block Ctrl+S, Ctrl+P, Ctrl+U
        document.addEventListener('keydown', function(event) {
            if (event.ctrlKey && ['s', 'p', 'u'].includes(event.key.toLowerCase())) {
                event.preventDefault();
                alert('Action Blocked: Confidential Page');
            }
        });

        // Blank page on tab switch/minimize
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'hidden') {
                document.body.innerHTML =
                    "<h1 style='text-align:center;margin-top:20%;'>Access Restricted. Please Scan the QR code again.</h1>";
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.pathname === '/medical-history' || window.location.pathname.startsWith(
                    '/DetailsView/') || window.location.pathname === '/pet-history') {
                const overlay = document.getElementById('locationOverlay');
                const mainContent = document.getElementById('mainContent');
                overlay?.classList.add('hidden');
                mainContent?.classList.remove('hidden');
                return;
            }
            if (window.locationScriptRun) return;
            window.locationScriptRun = true;
            console.log('Location script loaded');

            const overlay = document.getElementById('locationOverlay');
            const mainContent = document.getElementById('mainContent');
            const allowButton = document.getElementById('allowLocation');
            const locationError = document.getElementById('locationError');
            const iosInstructions = document.getElementById('iosInstructions');
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

            if (isIOS) {
                iosInstructions?.classList.remove('hidden');
            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('lat') && urlParams.has('lng') && urlParams.get('lat') !== '' && urlParams.get(
                    'lng') !== '') {
                overlay?.classList.add('hidden');
                mainContent?.classList.remove('hidden');

                // Send to backend from URL if needed
                sendLocationDetails({
                    lat: urlParams.get('lat'),
                    lng: urlParams.get('lng'),
                    countryCode: urlParams.get('country') ?? '',
                    city: urlParams.get('city') ?? '',
                });

                return;
            }

            overlay?.classList.remove('hidden');
            mainContent?.classList.add('hidden');

            function requestLocation(event) {
                if (event) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                allowButton.disabled = true;
                locationError?.classList.add('hidden');

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        position => {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;

                            fetch(
                                    `https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=en`
                                )
                                .then(response => response.json())
                                .then(data => {
                                    const country = data.countryName;
                                    const countryCode = data.countryCode;
                                    const region = data.principalSubdivision;
                                    const regionCode = data.principalSubdivisionCode;
                                    const city = data.city || data.locality || data.localityInfo
                                        ?.administrative[0]?.name || '';

                                    console.log('Location details:', {
                                        lat,
                                        lng,
                                        country,
                                        city
                                    });

                                    // Send to backend via AJAX
                                    sendLocationDetails({
                                        lat,
                                        lng,
                                        country,
                                        countryCode,
                                        region,
                                        regionCode,
                                        city
                                    });

                                    overlay?.classList.add('hidden');
                                    mainContent?.classList.remove('hidden');

                                    // Update URL
                                    const url = new URL(window.location.href);
                                    url.searchParams.set('lat', lat);
                                    url.searchParams.set('lng', lng);
                                    url.searchParams.set('city', city);
                                    url.searchParams.set('country', countryCode);
                                    window.history.replaceState({}, '', url.toString());
                                })
                                .catch(err => {
                                    console.error('Failed to fetch location info:', err);
                                    locationError.textContent =
                                        'Failed to retrieve location details. Please try again.';
                                    locationError?.classList.remove('hidden');
                                    allowButton.disabled = false;
                                });
                        },
                        error => {
                            locationError.textContent = {
                                1: 'Location access denied. Please allow location in your settings.',
                                2: 'Location unavailable. Please try again.',
                                3: 'Request timed out. Please try again.'
                            } [error.code] || 'An error occurred. Please try again.';
                            locationError?.classList.remove('hidden');
                            allowButton.disabled = false;
                        }, {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    locationError.textContent = 'Geolocation is not supported by this browser.';
                    locationError?.classList.remove('hidden');
                    allowButton.disabled = false;
                }
            }

            allowButton?.addEventListener('click', requestLocation);
            allowButton?.addEventListener('touchend', requestLocation);

            function sendLocationDetails(locationData) {
                fetch('/save-location', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify(locationData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Location saved to session:', data);
                        window.dispatchEvent(new CustomEvent('sendEmailNow'));
                    })
                    .catch(error => {
                        console.error('Error saving location:', error);
                    });
            }
        });

        let scrollTimeout;

        function redirectToUrl() {
            window.location.href = '/suspenedqr';
        }

        function resetScrollTimer() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(redirectToUrl, 180000);
        }

        window.addEventListener('scroll', resetScrollTimer);
        scrollTimeout = setTimeout(redirectToUrl, 180000);
    </script>
</section>
