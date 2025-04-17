<header class="bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5]">
    <nav class="border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="h-8 w-auto" />
                    </a>
                </div>

                <!-- Mobile menu button-->
                <div class="flex md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Desktop menu -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    <!-- Language selector -->
                    <div class="custom-select-wrapper w-fit">
                        @php $lang = Language::get(); @endphp
                        <select name="language" id="profile_language"
                            class="custom-select rounded-xl py-1.5 px-2 sm:px-3 text-sm">
                            @foreach ($lang as $ln)
                                <option value="{{ $ln->code }}" @selected(get_session_language()->code == $ln->code)>
                                    {{ $ln->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Help Link -->
                    <a href="{{ route('faqs') }}" class="text-white text-sm">@translate('Help?')</a>

                    @auth
                        <!-- User dropdown -->
                        <div class="relative">
                            <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                type="button">
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ getProfilePicture() }}"
                                    alt="{{ auth()->user()->display_name }}">
                            </button>

                            <div id="dropdownAvatar"
                                class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-gray-700 rounded-lg shadow-lg z-50">
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

                    <!-- Theme toggle -->
                    <x-mary-theme-toggle
                        class="ml-2 h-10 w-10 flex items-center justify-center rounded-full text-white" />
                </div>
            </div>
        </div>

        <!-- Mobile menu content -->
        <div class="md:hidden hidden px-4 pt-4 pb-3 space-y-2" id="mobile-menu">
            @auth
                <div class="flex items-center space-x-3">
                    <img class="w-8 h-8 rounded-full object-cover" src="{{ getProfilePicture() }}"
                        alt="{{ auth()->user()->display_name }}">
                    <div>
                        <div class="text-white text-sm">{{ auth()->user()->display_name }}</div>
                        <div class="text-xs text-gray-300">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <a wire:click="logout" class="block text-white text-sm py-2 hover:bg-gray-700 rounded">@translate('Log Out')</a>
            @else
                <a href="{{ route('login') }}"
                    class="block text-white text-sm py-2 hover:bg-gray-700 rounded">@translate('Login')</a>
            @endauth

            <div>
                <label class="block text-white text-sm mt-3 mb-1">@translate('Language')</label>
                <select name="language" id="mobile_profile_language"
                    class="custom-select w-full rounded-xl py-1.5 px-2 text-sm">
                    @foreach ($lang as $ln)
                        <option value="{{ $ln->code }}" @selected(get_session_language()->code == $ln->code)>
                            {{ $ln->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('faqs') }}"
                class="block text-white text-sm py-2 hover:bg-gray-700 rounded">@translate('Help?')</a>
        </div>
    </nav>
</header>
@push('js')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.getElementById('profile_language');
            const mobileSelect = document.getElementById('mobile_profile_language');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            // Language switcher
            const handleLangChange = (element) => {
                const selectedLanguage = element.value;
                $.post('{{ route('language.change') }}', {
                    _token: '{{ csrf_token() }}',
                    locale: selectedLanguage
                }, function() {
                    location.reload();
                });
            };

            if (selectElement) {
                selectElement.addEventListener('change', function() {
                    handleLangChange(this);
                });
            }

            if (mobileSelect) {
                mobileSelect.addEventListener('change', function() {
                    handleLangChange(this);
                });
            }

            // Mobile menu toggle
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
@endpush
