<section class="medical-history py-10">
    <div>
        <div class="emergency-notice">
            EMERGENCY USE ONLY - CONFIDENTIAL PATIENT INFORMATION
        </div>

        <div class="watermark">
            Emergency Access - {{ now()->format('Y-m-d H:i:s') }}
        </div>

    </div>
    {{-- location view --}}
    <div id="locationOverlay"
        class="{{ $locationObtained ? 'hidden' : '' }} fixed inset-0 bg-gray-800 bg-opacity-75 flex flex-col items-center justify-center z-50">
        <div class="bg-white p-6 rounded shadow text-center">
            <h2 class="text-lg font-semibold mb-4">Location Required</h2>
            <p class="mb-4">We need your location to continue. Please allow location access.</p>
            <button id="allowLocation" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Allow Location
            </button>
            <p id="locationError" class="text-red-500 mt-4 hidden"></p>
            <div id="iosInstructions" class="hidden text-sm text-gray-600 mt-2">
                If you are using iPhone/iPad, please allow location in Safari settings.
            </div>
        </div>
    </div>
    {{-- location view ends --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="heading my-4 sm:my-9">
            <h2
                class="dark:text-white py-2 text-2xl md:text-3xl xl:text-4xl leading-[1.2] text-black font-semibold text-center">
                @translate('Personal emergency response record')</h2>
        </div>
        <div
            class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] py-[10px] sm:py-[20px] sm:py-[48px] lg:py-[82px] px-[10px] sm:px-[20px] sm:px-[48px] mt-24 sm:mt-48 pb-6 sm:pb-6 lg:pb-6">
            <div
                class="profile-image inline-flex flex-col w-fit mx-auto items-center  translate-y-[-40%] translate-x-[-50%] absolute left-[50%] top-0">
                <a href=""
                    class="mb-4 flex flex-col items-center rounded-2xl p-[10px] sm:p-[15px] bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                    <div
                        class="image-wrapper flex p-[3px] rounded-[50%] bg-white mb-2 w-[180px] h-[180px] overflow-hidden">
                        @php
                            $user_id = is_array($content) ? $content['patient_id'] ?? null : null;
                        @endphp
                        {{-- <img src="{{ getProfilePicture($user_id) }}" alt=""
                            class="object-cover w-[100%] h-[100%] rounded-[50%] overflow-hidden"> --}}
                        <img src="{{ asset('storage/images/' . ($content->images[0] ?? 'avatar-place.png')) }}"
                            alt="" class="w-[100%] h-[100%] rounded-[50%] overflow-hidden">
                    </div>
                </a>
            </div>

            <div class="head mt-28 sm:mt-24 lg:mt-16 text-center mb-6">
                <h3 class="dark:text-white pb-2 text-[24px]  text-[#000] font-semibold">@php echo $content['name'] @endphp</h3>
                <p class="dark:text-white uppercase text-[16px]  text-[#000] font-semibold">@translate('Med Alert Important information')</p>
            </div>

            <div class="field-groups mt-6">
                {{-- Personal Information --}}
                <div
                    class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                    <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-bolder uppercase">
                        @translate('Personal Information')</h2>
                </div>
                @php
                    $attributes = $content->getAttributes();
                @endphp

                <div class="information-wrapper grid gap-4 grid-cols-1 grid-rows-auto px-2 sm:grid-cols-2">
                    @php

                        if ($content['name'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Name') .
                                ': </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['name'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['cedula_no'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Cedula no') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['cedula_no'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['date_of_birth'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Date of Birth') .
                                ': </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['date_of_birth'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['age'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Age') .
                                ': </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['age'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if (!empty($content['gender'])) {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Gender') .
                                ': </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">';
                            if ($content['gender'] === 'male') {
                                echo @translate('Male');
                            } elseif ($content['gender'] === 'female') {
                                echo @translate('Female');
                            } elseif ($content['gender'] === 'other') {
                                echo @translate('Other');
                            } else {
                                echo @translate('Not Specified');
                            }
                            echo '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['home_address'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Home Address') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['home_address'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emergency_contact_name'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Contact Name') .
                                ': </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emergency_contact_name'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emergency_phone_no'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Phone no') .
                                ' : </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emergency_phone_no'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emrg_email'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Email') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emrg_email'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emergency_contact_name2'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Contact Name2') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emergency_contact_name2'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emergency_phone_no2'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Phone no2') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emergency_phone_no2'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['emrg_email2'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Emergency Email2') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['emrg_email2'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if (!empty($content['marital_status'])) {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Marital Status') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">';
                            if ($content['marital_status'] == 1) {
                                echo @translate('Single');
                            } elseif ($content['marital_status'] == 2) {
                                echo @translate('Married');
                            } elseif ($content['marital_status'] == 3) {
                                echo @translate('Divorced');
                            } elseif ($content['marital_status'] == 4) {
                                echo @translate('Widowed');
                            } else {
                                echo @translate('Unknown');
                            }
                            echo '</span>';
                            echo '</div>';
                            echo '</div>';
                        }

                        if ($content['other_id_document'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Other ID Document') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['other_id_document'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    @endphp

                </div>
                {{-- Medical History --}}
                <div
                    class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] mt-6">
                    <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-bolder uppercase">
                        @translate('Medical History')</h2>
                </div>
                <div class="information-wrapper grid gap-4 grid-cols-1 grid-rows-auto px-2 sm:grid-cols-2">
                    @php
                        // Step 2: Medical History
                        foreach ($attributes as $key => $value) {
                            if ($key === 'blood_group' && $content['blood_group'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Blood Group') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['blood_group'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }
                            if ($key === 'medical_condition' && $content['medical_condition'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Medical Condition') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['medical_condition'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'primary_doctor' && $content['primary_doctor'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Primary Doctor') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['primary_doctor'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'current_medication' && $content['current_medication'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Current Medication') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['current_medication'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'doctors_no' && $content['doctors_no'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Doctor\'s Phone Number') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['doctors_no'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'doc_email' && $content['doc_email'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Doctor\'s Email') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['doc_email'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'primary_doctor2' && $content['primary_doctor2'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Primary Doctor 2') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['primary_doctor2'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'doctors_no2' && $content['doctors_no2'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Doctor\'s Phone Number 2') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['doctors_no2'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'doc_email2' && $content['doc_email2'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Doctor\'s Email 2') .
                                    ' :  </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['doc_email2'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'medication_allergies' && $content['medication_allergies'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Medication Allergies') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['medication_allergies'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'pet_allergies' && $content['pet_allergies'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Pet Allergies') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['pet_allergies'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'organ_transplant' && $content['organ_transplant'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Organ Transplant') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['organ_transplant'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'food_allergies' && $content['food_allergies'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Food Allergies') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['food_allergies'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'insect_allergies' && $content['insect_allergies'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Insect Allergies') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['insect_allergies'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }

                            if ($key === 'removed_organs' && $content['removed_organs'] != '') {
                                echo '<div class="flex items-start flex-col pl-2">';
                                echo '<div class="span-wrapper">';
                                echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                    @translate('Removed Organs') .
                                    ' : </span>';
                                echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                    $content['removed_organs'] .
                                    '</span>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    @endphp

                </div>
                {{-- Health Insurance Plan --}}
                <div
                    class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] mt-6">
                    <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-bolder uppercase">
                        @translate('Health Insurance Plan') </h2>
                </div>
                <div class="information-wrapper grid gap-4 grid-cols-1 grid-rows-auto px-2 sm:grid-cols-2">
                    @php
                        if ($content['insurance_name'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Insurance Name') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['insurance_name'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                        if ($content['affiliates'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('MemberShip ID') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['affiliates'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                        if ($content['insurance_plan'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Insurance Plan') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['insurance_plan'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                        if ($content['prefered_hospital'] != '') {
                            echo '<div class="flex items-start flex-col pl-2">';
                            echo '<div class="span-wrapper">';
                            echo '<span class="text-[16px] dark:text-white text-[#000] font-semibold">' .
                                @translate('Prefered Hospital') .
                                ' :  </span>';
                            echo '<span class="text-[16px] dark:text-[#ffffffb8] text-[#666] font-semibold">' .
                                $content['prefered_hospital'] .
                                '</span>';
                            echo '</div>';
                            echo '</div>';
                        }
                    @endphp
                </div>
            </div>
        </div>
        @auth
            <div class="flex justify-center gap-2">
                <a href="{{ route('wizard') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-8 sm:px-10 py-2 text-white ">@translate('Edit')</a>
                <a href="{{ route('SaveExit') }}"
                    class="flex w-fit my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-8 sm:px-10 py-2 text-white ">@translate('Save & Exit')</a>
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
                    "<h1 style='text-align:center;margin-top:20%;'>Access Restricted.  Please Scan the QR code again.</h1>";
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
