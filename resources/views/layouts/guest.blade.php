<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GEST\'PARC') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS via CDN (Rétabli) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image_icon/favicon-32x32.png') }}">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles pour les animations de fond -->
    <style>
        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
        .blob {
            animation: float 10s infinite ease-in-out;
        }
        .blob-delayed {
            animation: float 12s infinite ease-in-out;
            animation-delay: 2s;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100">
    <div class="relative flex flex-col items-center min-h-screen overflow-hidden sm:justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">
        
        <!-- Éléments décoratifs de fond -->
        <div class="absolute top-0 left-0 z-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute bg-blue-500 rounded-full blob -top-20 -left-20 w-80 h-80 mix-blend-multiply filter blur-3xl opacity-30"></div>
            <div class="absolute bg-blue-400 rounded-full blob-delayed top-1/2 -right-20 w-96 h-96 mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bg-indigo-500 rounded-full blob -bottom-20 left-1/3 w-72 h-72 mix-blend-multiply filter blur-3xl opacity-20"></div>
        </div>

        <!-- Conteneur principal -->
        <div class="relative z-10 w-full max-w-md px-4 py-6 sm:px-0 sm:py-8">
            
            <!-- Logo et en-tête (Compacté) -->
            <div class="mb-4 text-center">
    <a href="/" class="inline-flex items-center justify-center group">
        <div class="p-3 transition-transform duration-300 rounded-full shadow-lg bg-white/10 backdrop-blur-sm group-hover:scale-105">
            <!-- Logo Image adapté -->
            <img 
                src="{{ asset('image_icon/android-icon-144x144.png') }}" 
                alt="Logo GEST'PARC" 
                class="w-full h-full rounded-full sm:w-16 sm:h-16 object-contain drop-shadow-lg" 
            />
        </div>
    </a>
    <h1 class="mt-3 text-2xl font-extrabold tracking-tight text-white sm:text-3xl drop-shadow-lg">
        GEST'PARC
    </h1>
    <p class="mt-1 text-sm font-medium text-center text-blue-100 drop-shadow">
        Votre plateforme de gestion
    </p>
</div>

            <!-- Carte principale -->
            <div class="relative w-full overflow-hidden border shadow-2xl bg-white/95 backdrop-blur-md rounded-2xl border-white/20">
                
                <!-- Barre décorative -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-800"></div>

                <!-- Contenu -->
                <div class="p-6 sm:p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 mt-6 text-xs font-medium text-center text-white/70">
                <p>&copy; {{ date('Y') }} GEST'PARC. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>

</html>