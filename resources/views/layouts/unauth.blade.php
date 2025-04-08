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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <x-mary-toast />
        {{ $slot }}
</body>

</html>
