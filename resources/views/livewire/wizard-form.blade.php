<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-12 text-center">
        <h2 class="dark:text-white py-2 text-3xl xl:text-4xl leading-[1.2] text-black font-semibold text-center">
            @translate('Personal emergency response record')
        </h2>
        <h5 class="dark:text-white py-2 text-[24px] text-[#000] font-semibold">
            @translate('Entering information in the sections is completely optional.')
        </h5>
        <p class="dark:text-white py-2 text-[16px] text-[#000] font-[500]">
            @translate('Fill out the sections that you think emergency workers should be able to see in "view mode" that may save your life in a crisis.')
        </p>
        <div class="mt-20 step-form">
            <x-new-steps wire:model="step" class=" mt-20 p-0 sm:p-5">
                <x-custom-step step="1" data-content="{{ asset('assets/images/icons/step1.png') }}"
                    text="{{ translate('Personal Information') }}">
                    <div
                        class="mb-4 title px-4 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                        <h2
                            class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-bolder text-left uppercase">
                            @translate('Personal Information')
                        </h2>
                    </div>
                    <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[20px] mb-4">
                        <div class="field-groups">
                            <div class="information-wrapper">
                                <div class="flex items-center justify-center w-100">
                                    <livewire:dropzone wire:model="images" :rules="['image', 'mimes:png,jpeg', 'max:10420']" :multiple="false" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                        <div class="field-groups">
                            <div
                                class="information-wrapper grid gap-x-4 gap-y-0 grid-cols-1 sm:grid-cols-2 grid-rows-auto px-2">
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="name"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Name')</label>
                                            <input type="text" id="name" wire:model="name"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('name')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5 myDate">
                                            <label for="myDate"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Date of Birth')</label>
                                            <x-mary-datetime id="date_of_birth"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700"
                                                wire:change="updateDateOfBirth" wire:model="date_of_birth"
                                                icon-right="o-calendar" />
                                            @error('date_of_birth')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-5">
                                            <label for="gender"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Gender')</label>
                                            <select id="gender" wire:model="gender"
                                                class="border-0 py-2 pl-4 rounded-md px-2 bg-white dark:bg-gray-700">
                                                <option value="" selected>@translate('Select Gender')</option>
                                                <option value="male">@translate('Male')</option>
                                                <option value="female">@translate('Female')</option>
                                                <option value="other">@translate('Other')</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="age"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Age')</label>
                                            <input type="text" id="age" wire:model="age" disabled
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('age')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="cedula_no"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Cedula No')</label>
                                            <input type="text" id="cedula_no" wire:model="cedula_no"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('cedula_no')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="Marital-status"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Marital Status')</label>
                                            <select id="marital-status" wire:model="marital_status"
                                                class="border-0 py-2 pl-4 rounded-md px-2 bg-white dark:bg-gray-700">
                                                <option value="" selected>@translate('Select Status')</option>
                                                <option value="1">@translate('Single')</option>
                                                <option value="2">@translate('Married')</option>
                                                <option value="3">@translate('Divorced')</option>
                                                <option value="4">@translate('Widowed')</option>
                                            </select>
                                            @error('Marital-status')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-4 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="address"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Home Address')</label>
                                            <textarea rows="4" id="address" wire:model="home_address"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('home_address')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <div class="flex flex-col my-5">
                                            <label for="emergency_cont_name"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Contact Name')</label>
                                            <input type="text" id="emergency_cont_name"
                                                wire:model="emergency_contact_name"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('emergency_cont_name')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <div class="flex flex-col my-5 phone-number-select">
                                            <label for="emergency_phone_no"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Phone no')</label>
                                            <div class="form-item number-select">
                                                <input wire:model="emergency_phone_no" class="telselect"
                                                    type="tel">
                                            </div>
                                            @error('emergency_phone_no')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-0 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="emrg_email"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Email')</label>
                                            <input type="emrg_email" id="emrg_email" wire:model="emrg_email"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]">
                                            @error('emrg_email')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Checkbox for allow_notification_emrg_email -->
                                        <div class="flex flex-row items-center my-2">
                                            <input type="checkbox" id="allow_notification_emrg_email"
                                                wire:model="allow_notification_emrg_email" class="mr-2">
                                            <label for="allow_notification_emrg_email"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Allow Notification for Emergency Email')</label>
                                            @error('allow_notification_emrg_email')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="emergency_cont_name2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Contact Name 2')</label>
                                            <input type="text" id="emergency_cont_name2"
                                                wire:model="emergency_cont_name2"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('emergency_cont_name2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-5 phone-number-select">
                                            <label for="patient-emergency-ph-no2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Phone no 2')</label>
                                            <div class="form-item number-select">
                                                <input wire:model="emergency_phone_no2" class="telselect"
                                                    type="tel">
                                            </div>
                                            @error('patient-emergency-ph-no2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-0 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="emrg_email2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Emergency Email 2')</label>
                                            <input type="email" id="emrg_email2" wire:model="emrg_email2"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]">
                                            @error('emrg_email2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Checkbox for allow_notification_emrg_email2 -->
                                        <div class="flex flex-row items-center my-2">
                                            <input type="checkbox" id="allow_notification_emrg_email2"
                                                wire:model="allow_notification_emrg_email2" class="mr-2">
                                            <label for="allow_notification_emrg_email2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Allow Notification for Emergency Email')</label>
                                            @error('allow_notification_emrg_email2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-4 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="other_id_document"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Other ID Document')</label>
                                            <input type="text" id="other_id_document"
                                                wire:model="other_id_document"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]">
                                            @error('other_id_document')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-custom-step>
                <x-custom-step step="2" data-content="{{ asset('assets/images/icons/step4.png') }}"
                    text="{{ translate('Medical history') }}">
                    <div
                        class="mb-4 title px-4 sm:px-10  py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                        <h2 class="text-white text-[22px] dark:text-white text-[#000] font-bolder text-left uppercase">
                            @translate('Medical history')
                        </h2>
                    </div>
                    <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                        <div class="field-groups">
                            <div
                                class="information-wrapper grid gap-x-4 gap-y-0 grid-cols-1 sm:grid-cols-2 grid-rows-auto px-2">
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-5">
                                            <label for="blood_group"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Blood Group')</label>
                                            <select id="blood_group" wire:model="blood_group"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                                <option value="">@translate('Select Blood Group')</option>
                                                <option value="A-">A-</option>
                                                <option value="B-">B-</option>
                                                <option value="AB-">AB-</option>
                                                <option value="O-">O-</option>
                                                <option value="A+">A+</option>
                                                <option value="B+">B+</option>
                                                <option value="AB+">AB+</option>
                                                <option value="O+">O+</option>
                                            </select>
                                            @error('blood_group')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="medical_condition"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Medical Condition')</label>
                                            <input type="text" id="medical_condition" wire:model="medical_condition"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('medical_condition')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="primary_doctor"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Primary Care Doctor')</label>
                                            <input type="text" id="primary_doctor" wire:model="primary_doctor"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('primary_doctor')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="current_medication"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Current Medication')</label>
                                            <input type="text" id="current_medication"
                                                wire:model="current_medication"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('current_medication')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5 phone-number-select">
                                            <label for="doctors_no"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate("Doctor's Phone")</label>
                                            <div class="form-item number-select">
                                                <input wire:model="doctors_no" class="telselect" type="tel">
                                            </div>
                                            @error('doctors_no')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-0 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="doc_email"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate("Doctor's Email")</label>
                                            <input type="email" id="doc_email" wire:model="doc_email"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]">
                                            @error('doc_email')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-5">
                                            <label for="primary_doctor2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Primary Care Doctor 2')</label>
                                            <input type="text" id="primary_doctor2" wire:model="primary_doctor2"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('primary_doctor2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5 phone-number-select">
                                            <label for="doctors_no2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate("Doctor's Phone 2")</label>
                                            <div class="form-item number-select">
                                                <input wire:model="doctors_no2" class="telselect" type="tel">
                                            </div>
                                            @error('doctors_no2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                                    <div class="mb-0 w-[100%]">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-0">
                                            <label for="doc_email2"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate("Doctor's Email 2")</label>
                                            <input type="email" id="doc_email2" wire:model="doc_email2"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]">
                                            @error('doc_email2')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="medication_allergies"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Medication Allergies')</label>
                                            <textarea rows="4" id="medication_allergies" wire:model="medication_allergies"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('medication_allergies')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="pet_allergies"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Pet Allergies')</label>
                                            <textarea rows="4" id="pet_allergies" wire:model="pet_allergies"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('pet_allergies')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="organ_transplant"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Organ Transplant')</label>
                                            <textarea rows="4" id="organ_transplant" wire:model="organ_transplant"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('organ_transplant')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="food_allergies"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Food Allergies')</label>
                                            <textarea rows="4" id="food_allergies" wire:model="food_allergies"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('food_allergies')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="insect_allergies"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Insect Allergies')</label>
                                            <textarea rows="4" id="insect_allergies" wire:model="insect_allergies"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('insect_allergies')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="removed_organs"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Removed Organs')</label>
                                            <textarea rows="4" id="removed_organs" wire:model="removed_organs"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700 w-[100%]"></textarea>
                                            @error('removed_organs')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-custom-step>
                <x-custom-step step="3" data-content="{{ asset('assets/images/icons/step3.png') }}"
                    text="{{ translate('health insurance plan') }}">
                    <div
                        class="mb-4 title px-4 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
                        <h2 class="text-white text-[22px] dark:text-white text-[#000] font-bolder text-left uppercase">
                            @translate('health insurance plan')
                        </h2>
                    </div>
                    <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                        <div class="field-groups">
                            <div
                                class="information-wrapper grid gap-x-4 gap-y-0 grid-cols-1 sm:grid-cols-2 grid-rows-auto px-2">
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 2 -->
                                        <div class="flex flex-col my-5">
                                            <label for="insurance_name"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">
                                                @translate('Insurance Name')
                                            </label>
                                            <input type="text" id="insurance_name" wire:model="insurance_name"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('insurance_name')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="flex flex-col my-5">
                                            <label for="affiliates"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">
                                                @translate('MemberShip ID')
                                            </label>
                                            <input type="text" id="affiliates" wire:model="affiliates"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('affiliates')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <div class="mb-0">
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="insurance_plan"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">
                                                @translate('Insurance Plan')
                                            </label>
                                            <input type="text" id="insurance_plan" wire:model="insurance_plan"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('insurance_plan')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!-- Input fields for step 1 -->
                                        <div class="flex flex-col my-5">
                                            <label for="prefered_hospital"
                                                class="text-left capitalize text-semibold dark:text-white text-[#000]">
                                                @translate('Prefered Hospital')
                                            </label>
                                            <input type="text" id="prefered_hospital"
                                                wire:model="prefered_hospital"
                                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                            @error('prefered_hospital')
                                                <span class="text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-custom-step>

            </x-new-steps>

            <div class="flex gap-6">
                @if ($this->showPrevButton())
                    <x-mary-button
                        class="flex w-fit mx-auto my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white "
                        wire:click="prev">@translate('Previous')</x-mary-button>
                @endif

                @if ($this->showNextButton())
                    <x-mary-button
                        class="flex w-fit mx-auto my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white "
                        wire:click="next">@translate('Next')</x-mary-button>
                @endif

                <!-- Submit Button -->
                @if ($this->showSubmitButton())
                    <x-mary-button
                        class="flex w-fit mx-auto my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white "
                        wire:click="submit">@translate('Submit')</x-mary-button>
                @endif
            </div>
        </div>

    </div>
</div>


@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.12/build/css/intlTelInput.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.12/build/js/intlTelInput.min.js"></script>
    <script>
        const inputs = document.querySelectorAll(".telselect");
        inputs.forEach(input => {
            window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: callback => {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => callback(data.country_code))
                        .catch(() => callback("us"));
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.12/build/js/utils.js",
            });
        });
    </script>
@endpush
