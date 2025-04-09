<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-title" content="Mirpre">
    <title>{{ config('app.name', 'Mirpre') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="font-sans antialiased">
    <x-mary-toast />
    <div class="bg-white dark:bg-gray-900">
        <!-- Page Heading -->
        <livewire:layout.adminnavigation />
        <!-- Page Content -->
        <main>
            <div class="drawer lg:drawer-open hi">
                <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content flex flex-col lg:items-center">
                    <!-- Page content here -->
                    {{ $slot }}
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-2" aria-label="close sidebar"
                        class="ml-auto mr-2 drawer-button lg:hidden flex text-xl text-black dark:text-white p-1 bg-white dark:bg-gray-800 border border-black dark:border-white rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <i class='bx bx-x'></i> <!-- bx-x represents a cross icon -->
                    </label>
                    <ul
                        class="menu border-r p-4 w-80 min-h-full bg-white dark:bg-gray-900 text-base-content border-gray-200 dark:border-gray-300">
                        <!-- Sidebar content here -->
                        {{-- <li><a href="{{route('admin.dashboard')}}">@translate('Management')</a></li> --}}
                        <li><a href="{{ route('admin.language') }}">@translate('Add Language')</a></li>

                    </ul>

                </div>
            </div>
        </main>
    </div>
    <livewire:layout.footer />
    <mary-toast />
    @livewireScripts
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2()
        });
    </script>
</body>

</html>
