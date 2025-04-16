<p>Hola {{ $userName }},</p>

<p>Tu código QR ha sido escaneado recientemente. Aquí están los detalles:</p>

<ul>
    <li><strong>Información del dispositivo:</strong> {{ $deviceInfo }}</li>
    @if ($currentUserInfo)
        <li><strong>Device:</strong> {{ $deviceInfo }}</li>
        <li><strong>IP Address:</strong> {{ $ipAddress }}</li>
        <li><strong>Location:</strong> {{ $city }}, {{ $region_name }}, {{ $country_name }}
            ({{ $country_code }})</li>
        <li><strong>Postal Code:</strong> {{ $zip_code }}</li>
        <li><strong>Ubicación en el mapa:</strong>
            <a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}" target="_blank">
                Ver en Google Maps
            </a>
        </li>
    @endif
    <!-- Add more details as needed -->
</ul>

<p>Gracias.</p>
