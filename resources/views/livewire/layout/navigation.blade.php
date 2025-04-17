<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Wordpress\Menu;
use App\Models\Language;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<header class="bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
    <nav class="border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div
            class="navitems-wrapper max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 flex flex-row items-center justify-between p-4">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <x-application-logo class="h-8 w-auto" />
            </a>

            <!-- Hamburger Button for Mobile -->
            <button id="mobile-menu-button" type="button" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7">
                    </path>
                </svg>
            </button>

            <!-- Navigation Items -->
            <div id="mobile-menu"
                class="hidden md:flex md:items-center md:space-x-4 w-full md:w-auto absolute md:static top-16 left-0 bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] md:bg-transparent flex-col md:flex-row p-4 md:p-0 z-20">
                <!-- Language Selector -->
                <div class="custom-select-wrapper w-full md:w-fit mb-4 md:mb-0 md:mr-3">
                    @php
                        $lang = Language::get();
                    @endphp
                    <select name="language" id="profile_language"
                        class="custom-select rounded-xl py-[5px] px-[8px] sm:px-[10px] w-full text-[14px]">
                        @foreach ($lang as $ln)
                            <option value="{{ $ln->code }}" @selected(get_session_language()->code == $ln->code)>{{ $ln->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Help Link -->
                <a href="{{ route('faqs') }}"
                    class="text-white hover:underline mb-4 md:mb-0 md:pr-6">@translate('Help?')</a>

                <!-- Auth Section -->
                @auth
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        type="button">
                        <span class="sr-only">{{ auth()->user()->name }}</span>
                        <img class="w-8 h-8 rounded-full object-cover" src="{{ getProfilePicture() }}"
                            alt="{{ auth()->user()->display_name }}">
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="dropdownAvatar"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ auth()->user()->display_name }}</div>
                            <div class="font-medium truncate">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="py-2">
                            <a wire:click="logout"
                                class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                @translate('Log Out')
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-10 text-white bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] font-medium rounded-lg text-sm py-2.5 mb-4 md:mb-0">
                        @translate('Login')
                    </a>
                @endauth

                <!-- Theme Toggle -->
                <x-mary-theme-toggle
                    class="h-10 w-10 flex items-center justify-center rounded-full dark:text-white text-white" />
            </div>
        </div>
    </nav>
</header>

@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Language Selector
            const selectElement = document.getElementById('profile_language');
            selectElement.addEventListener('change', function() {
                const selectedLanguage = this.value;
                $.post('{{ route('language.change') }}', {
                    _token: '{{ csrf_token() }}',
                    locale: selectedLanguage
                }, function(data) {
                    location.reload();
                });
            });

            // Mobile Menu Toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        });
    </script>
@endpush
