<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-title" content="Mirpre">
    <title>{{ config('app.name', 'Mirpre') }}</title>
    <!-- Favicon and manifest declarations -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}" />

    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('css')

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <!-- Geolocation Overlay -->
    <div id="locationOverlay"
        class="fixed inset-0 bg-gray-900 text-white flex flex-col justify-center items-center p-5 hidden">
        <div class="max-w-md text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Location Access Required</h2>
            <p class="text-lg mb-6">We need your location to provide the best experience.</p>
            <div id="locationError" class="text-red-400 mb-4 hidden"></div>

            <div class="flex flex-col gap-4">
                <button id="allowLocation"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-colors">
                    Allow Location Access
                </button>
                <button id="manualLocation"
                    class="border border-white hover:bg-white/10 text-white px-8 py-3 rounded-lg transition-colors hidden">
                    Enter Location Manually
                </button>
                <button id="retryLocation" class="text-blue-400 hover:text-blue-300 underline hidden">
                    Retry Location Detection
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="bg-white dark:bg-gray-900 hidden">
        <!-- Your existing content -->
        <x-mary-toast />
        <livewire:layout.navigation />

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}
        </main>

        <livewire:layout.footer />
    </div>

    @livewireScripts
    @stack('js')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('locationOverlay');
            const mainContent = document.getElementById('mainContent');
            const errorDiv = document.getElementById('locationError');
            const manualBtn = document.getElementById('manualLocation');
            const retryBtn = document.getElementById('retryLocation');

            // Check if location is already granted
            const checkExistingLocation = () => {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.has('lat') && urlParams.has('lng');
            };

            // Show main content if location exists
            if (checkExistingLocation()) {
                overlay.classList.add('hidden');
                mainContent.classList.remove('hidden');
                return;
            }

            // Show location overlay
            overlay.classList.remove('hidden');

            // Geolocation functions
            const requestLocation = () => {
                errorDiv.classList.add('hidden');

                if (!navigator.geolocation) {
                    showError('Geolocation is not supported by your browser');
                    manualBtn.classList.remove('hidden');
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    position => handleSuccess(position.coords),
                    error => handleError(error), {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            };

            const handleSuccess = (coords) => {
                const url = new URL(window.location.href);
                url.searchParams.set('lat', coords.latitude);
                url.searchParams.set('lng', coords.longitude);
                window.location.href = url.toString();
            };

            const handleError = (error) => {
                let message = 'Unable to retrieve your location';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        message = 'Location permission denied. Please enable it in your browser settings.';
                        manualBtn.classList.remove('hidden');
                        retryBtn.classList.remove('hidden');
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = 'Location information is unavailable.';
                        break;
                    case error.TIMEOUT:
                        message = 'The request to get location timed out.';
                        retryBtn.classList.remove('hidden');
                        break;
                }
                showError(message);
            };

            const showError = (message) => {
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
            };

            // Event Listeners
            document.getElementById('allowLocation').addEventListener('click', requestLocation);
            retryBtn.addEventListener('click', requestLocation);
            manualBtn.addEventListener('click', () => {
                // Implement manual location input logic
                alert('Manual location input feature to be implemented');
            });

            // Initial check for geolocation support
            if (!navigator.geolocation) {
                showError('Your browser does not support geolocation');
                manualBtn.classList.remove('hidden');
            }

            // Check for permissions API support
            if (navigator.permissions) {
                navigator.permissions.query({
                        name: 'geolocation'
                    })
                    .then(permissionStatus => {
                        permissionStatus.onchange = () => {
                            if (permissionStatus.state === 'granted') {
                                requestLocation();
                            }
                        };
                    });
            }
        });
    </script>
</body>

</html>
