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
        <div class="min-h-screen flex flex-col mx-2 justify-center items-center pt-6 sm:pt-0 bg-white  dark:bg-gray-900">
            <div>
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
            <div class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                    <div class="mx-auto max-w-screen-sm text-center">
                        <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-primary-600 dark:text-primary-500">404</h1>
                        <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">Something's missing.</p>
                        <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">Sorry, we can't find that page. You'll find lots to explore on the home page. </p>
                        <a href="{{ route('dashboard') }}" class="px-10 text-white bg-gradient-to-r from-[#FF6B6B]  to-[#A500CD]  font-medium rounded-lg text-sm py-2.5  me-2 mb-0 ">Back to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
