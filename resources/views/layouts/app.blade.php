<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Keep existing head content -->
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

            <!-- iOS-specific instructions -->
            <div id="iosInstructions" class="mt-6 text-sm text-gray-300 hidden">
                <p>If the location prompt doesn't appear:</p>
                <ol class="list-decimal list-inside mt-2">
                    <li>Tap the "AA" in the address bar</li>
                    <li>Select "Website Settings"</li>
                    <li>Set Location to "Ask" or "Allow"</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div id="mainContent" class="bg-white dark:bg-gray-900 hidden">
        <!-- Keep existing main content -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('locationOverlay');
            const mainContent = document.getElementById('mainContent');
            const errorDiv = document.getElementById('locationError');
            const manualBtn = document.getElementById('manualLocation');
            const retryBtn = document.getElementById('retryLocation');
            const iosInstructions = document.getElementById('iosInstructions');

            // Detect iOS/Safari
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

            // Check existing location
            const checkExistingLocation = () => {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.has('lat') && urlParams.has('lng');
            };

            if (checkExistingLocation()) {
                overlay.style.display = 'none';
                mainContent.style.display = 'block';
                return;
            }

            overlay.style.display = 'flex';

            // Safari-specific initialization
            if (isIOS || isSafari) {
                iosInstructions.style.display = 'block';
                manualBtn.style.display = 'block';
            }

            const requestLocation = () => {
                errorDiv.style.display = 'none';

                if (!navigator.geolocation) {
                    showError('Geolocation is not supported by your browser');
                    manualBtn.style.display = 'block';
                    return;
                }

                // Safari requires click-based permission requests
                navigator.geolocation.getCurrentPosition(
                    position => handleSuccess(position.coords),
                    error => handleError(error), {
                        enableHighAccuracy: true,
                        timeout: 15000,
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
                        message = isIOS ?
                            'Location access denied. To enable:\n1. Tap AA in address bar\n2. Select Website Settings\n3. Enable Location' :
                            'Location permission denied. Please enable in browser settings.';
                        manualBtn.style.display = 'block';
                        retryBtn.style.display = 'block';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = 'Location information unavailable';
                        break;
                    case error.TIMEOUT:
                        message = 'Location request timed out';
                        retryBtn.style.display = 'block';
                        break;
                }
                showError(message);
            };

            const showError = (message) => {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            };

            // Event listeners with touch support for iOS
            const addTapEvents = (element, callback) => {
                element.addEventListener('click', callback);
                element.addEventListener('touchend', callback);
            };

            addTapEvents(document.getElementById('allowLocation'), requestLocation);
            addTapEvents(retryBtn, requestLocation);
            addTapEvents(manualBtn, () => {
                // Implement manual location entry
                window.location.href = '/manual-location'; // Example fallback
            });

            // Safari compatibility checks
            if (typeof navigator.permissions === 'undefined' && isSafari) {
                manualBtn.style.display = 'block';
            }
        });
    </script>
</body>

</html>
