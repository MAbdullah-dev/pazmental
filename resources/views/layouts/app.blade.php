<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Safari-specific meta tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Rest of head content remains same -->
</head>

<body class="font-sans antialiased">
    <!-- Geolocation Overlay -->
    <div id="locationOverlay" class="fixed inset-0 bg-gray-900 text-white flex flex-col justify-center items-center p-5"
        style="display: none;">
        <!-- Content remains same but with iOS instructions -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

            // 1. Check for HTTPS
            if (location.protocol !== 'https:' && !location.hostname.match(/localhost|127\.0\.0\.1/)) {
                alert('This site requires HTTPS for location access. Please reload in secure mode.');
                location.href = `https://${location.host}${location.pathname}`;
                return;
            }

            // 2. Safari-specific initialization
            if (isIOS || isSafari) {
                document.getElementById('iosInstructions').style.display = 'block';
                document.getElementById('manualLocation').style.display = 'block';

                // Add temporary hash to force Safari to recognize the page
                if (!window.location.hash) {
                    window.location.hash = 'safari-workaround';
                    window.location.reload();
                }
            }

            // 3. Enhanced permission handling
            const requestLocation = () => {
                if (isIOS) {
                    // Create temporary iframe for Safari permission triggering
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    document.body.appendChild(iframe);

                    try {
                        iframe.contentWindow.navigator.geolocation.getCurrentPosition(
                            () => {},
                            () => {}
                        );
                    } catch (e) {
                        console.log('Safari permission workaround');
                    }
                    document.body.removeChild(iframe);
                }

                navigator.geolocation.getCurrentPosition(
                    position => {
                        const url = new URL(window.location);
                        url.searchParams.set('lat', position.coords.latitude);
                        url.searchParams.set('lng', position.coords.longitude);
                        window.location.href = url.toString();
                    },
                    error => {
                        handleGeolocationError(error);
                    }, {
                        enableHighAccuracy: true,
                        timeout: isIOS ? 20000 : 10000,
                        maximumAge: 0
                    }
                );
            };

            // 4. Safari-specific error handling
            const handleGeolocationError = (error) => {
                let message = 'Location access required';
                const errorDiv = document.getElementById('locationError');

                if (isIOS) {
                    message = `
                    Please enable location access:
                    1. Tap the AA in the address bar
                    2. Select "Website Settings"
                    3. Set Location to "Allow"
                    4. Refresh the page
                `;

                    // Show iOS settings deep link
                    if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                        try {
                            window.location.href = 'app-settings:';
                            setTimeout(() => {
                                window.location.href = window.location.href;
                            }, 1000);
                        } catch (e) {
                            console.error('Failed to open settings');
                        }
                    }
                }

                errorDiv.innerHTML = message.replace(/\n/g, '<br>');
                errorDiv.style.display = 'block';
            };

            // 5. Add proper click handlers for Safari
            const addSafariClickHandler = (element, handler) => {
                element.addEventListener('click', handler);
                element.addEventListener('touchend', handler);
                element.style.cursor = 'pointer';
            };

            addSafariClickHandler(document.getElementById('allowLocation'), requestLocation);
            addSafariClickHandler(document.getElementById('retryLocation'), requestLocation);
        });
    </script>
</body>

</html>
