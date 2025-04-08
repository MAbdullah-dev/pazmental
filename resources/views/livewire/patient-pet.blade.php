<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-12 text-center">
        @php
        $locale = session()->get('locale');
        @endphp

        <div class="flex justify-center mb-5">
            @if($locale == 'es')
            <img src="{{ asset('assets/images/petsdarkspanish.svg') }}"
                class="block dark:hidden h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200" alt="">
            <img src="{{ asset('assets/images/petsspanish.svg') }}"
                class="hidden dark:block h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200" alt="">
            @else
            <img src="{{ asset('assets/images/petsdarkeng.svg') }}"
                class="block dark:hidden h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200" alt="">
            <img src="{{ asset('assets/images/petseng.svg') }}"
                class="hidden dark:block h-12 sm:h-16 w-auto fill-current text-gray-800 dark:text-gray-200" alt="">
            @endif
        </div>
        <h2
            class="dark:text-white py-2 text-2xl md:text-3xl xl:text-4xl leading-[1.2] text-black font-semibold text-center">
            @translate("Pet's Emergency Response Record")
        </h2>
        <h5 class="dark:text-white py-2 text-[18px] sm:text-[24px] text-[#000] font-semibold text-center">
            @translate('Entering information in the sections is completely optional.')
        </h5>
        <p class="dark:text-white py-2 text-[16px] text-[#000] font-[500] text-center">
            @translate('Fill out the sections that you think emergency workers should be able to see in "view mode" that
            may save your life in a crisis.')
        </p>
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
        <div class="mt-20 step-form">
            <div
                class="mb-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                <img src="{{ asset('assets/images/petdetail.svg') }}" class="gradient_icons block" alt="">
                <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase text-left">
                    @translate('Pet Information')
                </h2>
            </div>
            <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] sm:p-[20px] p-[8px] mb-0 pb-0 sm:pb-0">
                    <div class="field-groups">
                        <div class="information-wrapper">
                            <div class="flex items-center justify-center flex-col w-100">
                                <label for="main_image"
                                    class="text-left capitalize pb-3 sm:pb-0  text-[16px] sm:text-[22px] pet_label text-semibold dark:text-white text-[#000]">@translate("Pet's
                                    Main Image")</label>
                                <livewire:dropzone wire:model="main_image"
                                    :rules="['image', 'mimes:png,jpeg', 'max:10420']" :multiple="false"
                                    :key="'dropzone-one'" />
                            </div>
                            <div class="flex items-center justify-center flex-col w-100">
                                <label for="images"
                                    class="text-left capitalize pb-3 pt-6 sm:pb-0 sm:pt-0 text-[16px] sm:text-[22px] pet_label text-semibold dark:text-white text-[#000]">@translate("Pet's
                                    Four Images")</label>
                                <livewire:dropzone wire:model="images" :rules="['image', 'mimes:png,jpeg', 'max:10420']"
                                    :multiple="true" :key="'dropzone-two'" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field-groups">

                    <div
                        class="information-wrapper grid gap-x-4 gap-y-0 grid-cols-1 sm:grid-cols-2 grid-rows-auto px-2">
                        <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                            <div class="mb-0">
                                <div class="flex flex-col my-5">
                                    <label for="owner_appeal"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                        Message')</label>
                                    <textarea rows="4" id="owner_appeal" wire:model="owner_appeal"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700"></textarea>
                                    @error('owner_appeal') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <hr class="my-5 col-start-1 col-end-2 w-full sm:col-end-3">
                        <div class="flex flex-col">
                            <div class="mb-0">
                                <div class="flex flex-col my-5">
                                    <label for="name"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Name')</label>
                                    <input type="text" id="name" wire:model="name"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="sex"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Sex')</label>
                                    <input type="text" id="sex" wire:model="sex"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('sex') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="eye_color"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Eye
                                        Color')</label>
                                    <input type="text" id="eye_color" wire:model="eye_color"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('eye_color') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5 hidden">
                                    <label for="age"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Age')</label>
                                    <input type="text" id="age" wire:model="age"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('age') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="pet_weight"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Pet
                                        Weight')</label>
                                    <input type="number" id="pet_weight" wire:model="pet_weight"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('pet_weight') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="mb-0">
                                <div class="flex flex-col my-5">
                                    <label for="breed"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Breed')</label>
                                    <input type="text" id="breed" wire:model="breed"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('breed') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="date_of_birth"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Date
                                        of Birth') (@translate('AGE: '){{ $age }} )</label>
                                    <x-mary-datetime id="date_of_birth"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700"
                                        wire:change="updateDateOfBirth" wire:model="date_of_birth"
                                        icon-right="o-calendar" />
                                    @error('date_of_birth') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="hair_color"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Hair
                                        Color')</label>
                                    <input type="text" id="hair_color" wire:model="hair_color"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('hair_color') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="social_media"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Social
                                        Media')</label>
                                    <input type="text" id="social_media" wire:model="social_media"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('social_media') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                <img src="{{ asset('assets/images/petowner.svg') }}" class="gradient_icons block" alt="">
                <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase text-left">
                    @translate('Owner Information')
                </h2>
            </div>
            <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                <div class="field-groups">
                    <div
                        class="information-wrapper grid gap-x-4 gap-y-0 grid-cols-1 sm:grid-cols-2 grid-rows-auto px-2">
                        <div class="flex flex-col">
                            <div class="mb-0">
                                <div class="flex flex-col my-5">
                                    <label for="owner_name"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                        Name')</label>
                                    <input type="text" id="owner_name" wire:model="owner_name"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('owner_name') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col my-5 phone-number-select">
                                    <label for="owner_phone_no"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                        Phone
                                        No')</label>
                                    <div class="form-item number-select">
                                        <input wire:model="owner_phone_no" class="telselect" type="tel">
                                    </div>
                                    @error('owner_phone_no') <span class="text-red-500">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="mb-0">
                                <div class="flex flex-col my-5">
                                    <label for="owner_email"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                        Email')</label>
                                    <input type="email" id="owner_email" wire:model="owner_email"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('owner_email') <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex flex-col my-5">
                                    <label for="owner_friend_phone_no"
                                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                        Friend
                                        Phone No')</label>
                                    <input type="text" id="owner_friend_phone_no" wire:model="owner_friend_phone_no"
                                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                                    @error('owner_friend_phone_no') <span class="text-red-500">{{ $message
                                        }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                            <label for="owner_address"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Owner
                                Address')</label>
                            <input type="text" id="owner_address" wire:model="owner_address"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                            @error('owner_address') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="mb-4 mt-4 title px-6 sm:px-10 py-2 rounded-2xl bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] ps-12 gradient_icons_wrapper">
                <img src="{{ asset('assets/images/pethealth.svg') }}" class="gradient_icons block" alt="">
                <h2 class="text-white text-[18px] md:text-[22px] dark:text-white text-[#000] font-semibold uppercase text-left">
                    @translate('Health Information')
                </h2>
            </div>
            <div class="card rounded-2xl dark:bg-gray-800 bg-[#F9F9F9] p-[10px] sm:p-[20px] pb-6">
                <div class="flex flex-col">
                    <div class="mb-0">
                        <div class="flex flex-col my-5">
                            <label for="vaccine"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Vaccine')</label>
                            <input type="text" id="vaccine" wire:model="vaccine"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                            @error('vaccine') <span class="text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex flex-col my-5">
                            <label for="neuter_info"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Neuter
                                Info')</label>
                            <input type="text" id="neuter_info" wire:model="neuter_info"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                            @error('neuter_info') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mb-0">
                        <div class="flex flex-col my-5">
                            <label for="chip_info"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Chip
                                Info')</label>
                            <input type="text" id="chip_info" wire:model="chip_info"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                            @error('chip_info') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col my-5">
                            <label for="clinic_name"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Clinic
                                Name')</label>
                            <input type="text" id="clinic_name" wire:model="clinic_name"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                            @error('clinic_name') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="flex flex-col col-start-1 col-end-2 w-full sm:col-end-3">
                    <label for="insurance_info"
                        class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Insurance
                        Info')</label>
                    <input type="text" id="insurance_info" wire:model="insurance_info"
                        class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700">
                    @error('insurance_info') <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <div class="mb-0">
                        <div class="flex flex-col my-5">
                            <label for="other_info"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Other
                                Info')</label>
                            <textarea rows="4" id="other_info" wire:model="other_info"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700"></textarea>
                            @error('other_info') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="mb-0">
                        <div class="flex flex-col my-5">
                            <label for="food_allergy"
                                class="text-left capitalize text-semibold dark:text-white text-[#000]">@translate('Food
                                Allergy')</label>
                            <textarea rows="4" id="food_allergy" wire:model="food_allergy"
                                class="border-0 py-2 pl-4 rounded-md px-2 py-1 bg-white dark:bg-gray-700"></textarea>
                            @error('food_allergy') <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-6">
                <x-mary-button
                    class="flex w-fit mx-auto my-6 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white "
                    wire:click="submit">@translate('Submit')</x-mary-button>
            </div>
        </div>
    </div>
</div>
</div>
