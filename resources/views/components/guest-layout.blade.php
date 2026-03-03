<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GEST\'PARC') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-900 via-blue-600 to-blue-400">
        <!-- Logo et en-tête avec animation subtile -->
        <div class="text-center mb-8 transform hover:scale-105 transition-transform duration-300">
            <a href="/" class="inline-flex items-center justify-center">
                <div class="bg-white/10 p-4 rounded-full backdrop-blur-sm">
                    <x-application-logo class="w-20 h-20 fill-current text-blue-400 drop-shadow-lg" />
                </div>
            </a>
            <h1 class="mt-6 text-4xl font-extrabold text-white tracking-tight drop-shadow-lg">
                GEST'PARC
            </h1>
            <p class="mt-3 text-blue-100 text-center font-medium text-lg drop-shadow">
                Bienvenue sur votre plateforme GEST'PARC.
            </p>
        </div>

        <!-- Carte principale avec effet de verre et ombres améliorées -->
        <div
            class="w-full sm:max-w-md mt-4 px-8 py-8 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 hover:shadow-3xl transition-shadow duration-300 relative">
            <!-- Barre décorative en haut de la carte -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-800">
            </div>

            <!-- Contenu de la carte -->
            <div class="relative z-10">
                {{ $slot }}
            </div>
        </div>

        <!-- Footer avec copyright -->
        <div class="mt-8 text-center text-white/80 text-sm font-medium">
            <p>&copy; {{ date('Y') }} GEST'PARC. Tous droits réservés.</p>
        </div>
    </div>
</body>

</html>
