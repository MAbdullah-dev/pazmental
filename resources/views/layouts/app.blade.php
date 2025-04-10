<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-title" content="Mirpre">
    <title>{{ config('app.name', 'Mirpre') }}</title>

    <!-- Favicon & Manifest -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}" />
    <link rel="manifest" href="{{ asset('assets/images/site.webmanifest') }}" />

    <!-- Fonts & Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

    @stack('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <!-- Location Overlay -->
    <div id="locationOverlay"
        class="fixed inset-0 z-[1000] bg-gray-900 text-white flex flex-col justify-center items-center p-5"
        style="pointer-events: auto;">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Please Enable Location</h2>
        <p class="text-lg md:text-xl mb-2 max-w-lg text-center">We need your location to proceed.</p>
        <p class="text-sm text-red-400 hidden mb-3" id="geoErrorMessage"></p>
        <button id="allowLocation"
            class="z-[1001] relative w-fit mx-auto my-4 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white capitalize hover:from-[#FF8787] hover:to-[#B91CDE] transition-colors">
            Allow Location
        </button>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="bg-white dark:bg-gray-900" style="display: none;">
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

    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('locationOverlay');
            const mainContent = document.getElementById('mainContent');
            const allowButton = document.getElementById('allowLocation');
            const errorMsg = document.getElementById('geoErrorMessage');

            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            const urlParams = new URLSearchParams(window.location.search);

            let locationRequested = false;

            // Show main content if lat/lng exist
            if (urlParams.has('lat') && urlParams.has('lng')) {
                overlay.style.display = 'none';
                mainContent.style.display = 'block';
                return;
            }

            // Show overlay
            overlay.style.display = 'flex';
            mainContent.style.display = 'none';

            // Handle location button
            allowButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (locationRequested) return;
                locationRequested = true;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    });
                } else {
                    showError("Geolocation is not supported by this browser.");
                }
            }, {
                passive: false
            });

            function successCallback(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('lat', lat);
                currentUrl.searchParams.set('lng', lng);
                window.location.href = currentUrl.toString();
            }

            function errorCallback(error) {
                locationRequested = false;
                let message = "Unable to retrieve location.";
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        message = isIOS ?
                            'Location denied. Tap "AA" in Safari > Website Settings > Allow Location.' :
                            'Location permission denied. Please enable it in your browser settings.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = 'Location position unavailable.';
                        break;
                    case error.TIMEOUT:
                        message = 'Location request timed out.';
                        break;
                }
                showError(message);
            }

            function showError(msg) {
                if (errorMsg) {
                    errorMsg.textContent = msg;
                    errorMsg.classList.remove('hidden');
                } else {
                    alert(msg);
                }
            }

            // Auto-attempt location for Android
            if (isAndroid) {
                allowButton.click();
            }

            // iOS Safari note
            if (isIOS) {
                setTimeout(() => {
                    alert(
                        'If using Safari, tap the "AA" icon in the address bar, choose "Website Settings", then allow Location.');
                }, 500);
            }
        });
    </script>
</body>

</html>
