<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- Zorg ervoor dat je CSS (bijv. Tailwind) en JS correct worden geladen.
             Dit is de standaard manier met Vite in nieuwe Laravel projecten. --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex flex-col">
            {{-- Hier zou je een navigatiebalk of header kunnen toevoegen als je die hebt --}}
            {{-- <livewire:layout.navigation /> --}} {{-- Voorbeeld als je Breeze/Jetstream gebruikt --}}

            <main class="flex-grow">
                {{ $slot }} {{-- Dit is waar je Livewire page component wordt ingevoegd --}}
            </main>

            {{-- Hier zou je een footer kunnen toevoegen --}}
            {{-- <footer class="bg-white dark:bg-gray-800 shadow mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Alle rechten voorbehouden.
                </div>
            </footer> --}}
        </div>

        @livewireScripts
        {{-- Eventuele andere globale scripts kun je hieronder plaatsen --}}
    </body>
</html>