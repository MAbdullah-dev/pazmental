<p>Hola {{ $userName }},</p>

<p>Tu código QR ha sido escaneado recientemente. Aquí están los detalles:</p>

<ul>
    <li><strong>Información del dispositivo:</strong> {{ $deviceInfo }}</li>
    <li><strong>IP:</strong> {{ $ipAddress }}</li>

    @if ($locationData['lat'] && $locationData['lng'])
        <li><strong>Ciudad:</strong> {{ $locationData['city'] ?? 'N/A' }}</li>
        <li><strong>País (código):</strong> {{ $locationData['country'] ?? 'N/A' }}</li>
        <li><strong>Latitud:</strong> {{ $locationData['lat'] }}</li>
        <li><strong>Longitud:</strong> {{ $locationData['lng'] }}</li>
        <li><strong>Ubicación en el mapa:</strong>
            <a href="https://www.google.com/maps?q={{ $locationData['lat'] }},{{ $locationData['lng'] }}" target="_blank">
                Ver en Google Maps
            </a>
        </li>
    @else
        <li><strong>Ubicación:</strong> No disponible</li>
    @endif
</ul>

<p>Gracias.</p>
