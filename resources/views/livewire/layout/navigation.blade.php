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
            class="navitems-wrapper max-w-7xl mx-auto px-2 sm:px-4 sm:px-6 lg:px-8 flex flex-row items-center justify-between mx-auto p-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <x-application-logo />
            </a>
            <div class="flex md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse items-center">
                <div class="custom-select-wrapper w-fit mr-3">
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
                <a href="{{ route('faqs') }}" class="pr-3 md:pr-6">@translate('Help?')</a>
                @auth
                    <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                        class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        type="button">
                        <span class="sr-only">{{ auth()->user()->name }}</span>
                        <img class="w-8 h-8 rounded-full object-cover" src="{{ getProfilePicture() }}"
                            alt="{{ auth()->user()->display_name }}">
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownAvatar"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ auth()->user()->display_name }}</div>
                            <div class="font-medium truncate">{{ auth()->user()->email }}</div>
                        </div>
                        {{-- <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownUserAvatarButton">
                        <li>
                            <a href="{{ route('profile') }}" wire:navigate
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{
                                __('Profile') }}</a>
                        </li>
                    </ul> --}}
                        <div class="py-2">
                            <a wire:click="logout"
                                class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                @translate('Log Out')
                            </a>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="px-10 text-white bg-gradient-to-r from-[#FF6B6B]  to-[#A500CD]  font-medium rounded-lg text-sm py-2.5  me-2 mb-0 ">
                        @translate('Login')
                    </a>
                @endauth
                <x-mary-theme-toggle
                    class="ml-2 h-10 w-10 flex items-center justify-center rounded-full
           text-gray-800 text-black dark:text-white" />
            </div>
            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            </div>
        </div>
    </nav>
</header>
@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
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
        });
    </script>
@endpush
