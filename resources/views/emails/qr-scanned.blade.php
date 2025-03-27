<p>Hola {{ $userName }},</p>

<p>Tu código QR ha sido escaneado recientemente. Aquí están los detalles:</p>

<ul>
    <li><strong>Información del dispositivo:</strong> {{ $deviceInfo }}</li>
  @if($currentUserInfo)
    <li><strong>IP:</strong> {{ $currentUserInfo->ip }}</li>
    <li><strong>Nombre del país:</strong> {{ $currentUserInfo->countryName }}</li>
    <li><strong>Código del país:</strong> {{ $currentUserInfo->countryCode }}</li>
    <li><strong>Código de la región:</strong> {{ $currentUserInfo->regionCode }}</li>
    <li><strong>Nombre de la región:</strong> {{ $currentUserInfo->regionName }}</li>
    <li><strong>Nombre de la ciudad:</strong> {{ $currentUserInfo->cityName }}</li>
    <li><strong>Código postal:</strong> {{ $currentUserInfo->zipCode }}</li>
    <li><strong>Latitud:</strong> {{ $currentUserInfo->latitude }}</li>
    <li><strong>Longitud:</strong> {{ $currentUserInfo->longitude }}</li>
    <li><strong>Ubicación en el mapa:</strong> 
      <a href="https://www.google.com/maps?q={{ $currentUserInfo->latitude }},{{ $currentUserInfo->longitude }}" target="_blank">
          Ver en Google Maps
      </a>
    </li>
    @endif
    <!-- Add more details as needed -->
</ul>

<p>Gracias.</p>

