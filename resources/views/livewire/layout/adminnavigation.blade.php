<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;
use App\Models\Wordpress\Menu;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

}; ?>
<header class="bg-gradient-to-r from-[#FF6B6B] via-[#A500CD] to-[#0101C5] w-full">
    <nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div class=" mx-auto px-2 sm:px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between mx-auto p-4">
            <label for="my-drawer-2" class="drawer-button lg:hidden flex text-2xl text-black dark:text-white p-1 bg-white dark:bg-gray-800 border border-black dark:border-white rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                <i class='bx bx-menu-alt-left'></i>
              </label>
            <a href="{{ route('admin.login') }}"  class="mr-auto flex items-center space-x-3 hi rtl:space-x-reverse">
                <x-application-logo  />
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse items-center">
                @auth
                <button id="dropdownUserAvatarButton" data-dropdown-toggle="dropdownAvatar"
                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                    type="button">
                    <span class="sr-only">{{ auth()->user()->name }}</span>
                    <img class="w-8 h-8 rounded-full object-cover" src="{{getProfilePicture()}}" alt="{{ auth()->user()->display_name }}">
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

                <x-mary-theme-toggle class="ml-[10px] btn btn-circle btn-ghost" />


            </div>
            <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">

            </div>
        </div>
    </nav>
</header>
