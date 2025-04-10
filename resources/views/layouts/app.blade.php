<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
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
    <!-- Location Required Overlay -->
    <div id="locationOverlay"
        class="location-overlay fixed inset-0 bg-gray-900 text-white flex flex-col justify-center items-center p-5">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 color-black">Please Enable Location</h2>
        <p class="text-lg md:text-xl mb-6 max-w-lg color-black">We need your location to proceed. Click below to allow
            access.</p>
        <button id="allowLocation"
            class="w-fit mx-auto my-4 rounded-xl bg-gradient-to-r from-[#FF6B6B] to-[#A500CD] px-10 py-2 text-white capitalize hover:from-[#FF8787] hover:to-[#B91CDE] transition-colors">
            Allow Location
        </button>
    </div>
    <!-- Main Content (hidden until location is provided) -->
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const overlay = document.getElementById('locationOverlay');
            const mainContent = document.getElementById('mainContent');
            const allowButton = document.getElementById('allowLocation');
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isAndroid = /Android/.test(navigator.userAgent);

            // Check if latitude and longitude are already in the URL
            if (urlParams.has('lat') && urlParams.has('lng') && urlParams.get('lat') !== '' && urlParams.get(
                    'lng') !== '') {
                overlay.classList.add('hidden');
                mainContent.style.display = 'block';
            } else {
                overlay.classList.remove('hidden');
                mainContent.style.display = 'none';

                // Add event listeners for button clicks
                allowButton.addEventListener('click', requestLocation);
                allowButton.addEventListener('touchend', requestLocation);

                function requestLocation(event) {
                    event.preventDefault();

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            function(position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;
                                console.log("Coordinates captured:", lat, lng);
                                const currentUrl = new URL(window.location.href);
                                currentUrl.searchParams.set('lat', lat);
                                currentUrl.searchParams.set('lng', lng);
                                console.log("Redirecting to:", currentUrl.toString());
                                window.location.href = currentUrl.toString();
                            },
                            function(error) {
                                console.error('Geolocation error:', error);
                                handleGeolocationError(error);
                            }, {
                                enableHighAccuracy: true, // Request high accuracy for better precision
                                timeout: 15000, // Increased timeout for slower devices
                                maximumAge: 0 // Ensure fresh data
                            }
                        );
                    } else {
                        alert('Geolocation is not supported by this browser.');
                    }
                }

                function handleGeolocationError(error) {
                    let message = 'Please allow location access to proceed.';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            message = isIOS ?
                                'Location permission denied. To enable, tap the "AA" icon in the address bar, select "Website Settings", and set Location to "Ask" or "Allow".' :
                                'Location permission denied. Please enable it in your browser settings.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = isIOS ?
                                'Location unavailable. Please ensure Location Services are enabled in Settings > Privacy > Location Services.' :
                                'Location unavailable. Please check your device settings.';
                            break;
                        case error.TIMEOUT:
                            message = 'Location request timed out. Please try again.';
                            break;
                        default:
                            message = 'An unknown error occurred. Please try again.';
                            break;
                    }
                    alert(message);
                }

                // Automatically request location for Android devices for better user experience
                if (isAndroid) {
                    requestLocation(new Event('initial'));
                }

                // Special handling for Safari browser on iOS
                if (isIOS) {
                    alert(
                        'For best results, ensure that location access is enabled for Safari in your device settings.'
                    );
                    // Provide additional guidance if necessary
                }
            }
        });
    </script>
    <script>
        window.onerror = function(msg, url, lineNo, columnNo, error) {
            alert(
                `Error: ${msg}\nURL: ${url}\nLine: ${lineNo}\nColumn: ${columnNo}\nError object: ${JSON.stringify(error)}`
            );
            return false; // Prevent default error handling
        };

        console.log = function(message) {
            alert(`Console Log: ${message}`);
        };
    </script>
</body>

</html>
