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
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <x-application-logo />
            </a>

            <!-- Mobile menu toggle -->
            <button id="menu-toggle" data-collapse-toggle="navbar-dropdown" type="button"
                class="inline-flex items-center p-2 ml-3 text-sm text-white rounded-lg md:hidden hover:bg-white/10 focus:outline-none"
                aria-controls="navbar-dropdown" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Menu items -->
            <div class="hidden w-full md:flex md:w-auto md:items-center md:space-x-6 text-white" id="navbar-dropdown">
                <!-- Language Select -->
                <div class="w-fit">
                    @php $lang = Language::get(); @endphp
                    <select name="language" id="profile_language"
                        class="custom-select rounded-xl py-1.5 px-2 text-sm text-black">
                        @foreach ($lang as $ln)
                            <option value="{{ $ln->code }}" @selected(get_session_language()->code == $ln->code)>
                                {{ $ln->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Help link -->
                <a href="{{ route('faqs') }}" class="block py-2 text-white md:p-0">@translate('Help?')</a>

                <!-- Auth Area -->
                @auth
                    <div class="relative">
                        <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            type="button">
                            <span class="sr-only">{{ auth()->user()->name }}</span>
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ getProfilePicture() }}"
                                alt="{{ auth()->user()->display_name }}">
                        </button>
                        <!-- Dropdown -->
                        <div id="dropdownAvatar"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2">
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
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-white bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] font-medium rounded-lg text-sm py-2.5 px-4">
                        @translate('Login')
                    </a>
                @endauth

                <!-- Theme Toggle -->
                <x-mary-theme-toggle class="ml-2 h-10 w-10 flex items-center justify-center rounded-full text-white" />
            </div>
        </div>
    </nav>
</header>

<!-- JavaScript for language and menu toggle -->
@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Language change
            document.getElementById('profile_language').addEventListener('change', function() {
                const selectedLanguage = this.value;
                $.post('{{ route('language.change') }}', {
                    _token: '{{ csrf_token() }}',
                    locale: selectedLanguage
                }, function() {
                    location.reload();
                });
            });

            // Mobile menu toggle
            document.getElementById('menu-toggle').addEventListener('click', function() {
                const menu = document.getElementById('navbar-dropdown');
                menu.classList.toggle('hidden');
            });
        });
    </script>
@endpush
