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
        /* Styles pour éviter le débordement horizontal */
        * {
            max-width: 100%;
            box-sizing: border-box;
        }
        
        body, html {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        
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
        
        /* Ajustements responsive pour les éléments flottants */
        @media (max-width: 640px) {
            .blob, .blob-delayed {
                opacity: 0.15;
            }
        }
        
        /* Empêcher le débordement horizontal */
        .overflow-x-hidden {
            overflow-x: hidden !important;
        }

        /* Masquer l'icône "œil" native générée par Edge/IE et Safari/Mobile */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
        }
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
            position: absolute;
            right: 0;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-100 overflow-x-hidden">
    <div class="relative flex flex-col items-center min-h-screen overflow-x-hidden sm:justify-center bg-gradient-to-br from-blue-900 via-blue-700 to-blue-500">
        
        <!-- Éléments décoratifs de fond - Responsive -->
        <div class="absolute inset-0 z-0 w-full h-full overflow-hidden pointer-events-none">
            <!-- Premier blob - taille adaptée -->
            <div class="absolute bg-blue-500 rounded-full blob -top-20 -left-20 w-48 h-48 sm:w-64 sm:h-64 md:w-80 md:h-80 mix-blend-multiply filter blur-3xl opacity-20 sm:opacity-30"></div>
            <!-- Deuxième blob - taille adaptée -->
            <div class="absolute bg-blue-400 rounded-full blob-delayed top-1/2 -right-20 w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 mix-blend-multiply filter blur-3xl opacity-15 sm:opacity-20"></div>
            <!-- Troisième blob - taille adaptée -->
            <div class="absolute bg-indigo-500 rounded-full blob -bottom-20 left-1/3 w-56 h-56 sm:w-64 sm:h-64 md:w-72 md:h-72 mix-blend-multiply filter blur-3xl opacity-15 sm:opacity-20"></div>
        </div>

        <!-- Conteneur principal - Responsive -->
        <div class="relative z-10 w-full max-w-[95%] sm:max-w-md px-2 sm:px-0 py-4 sm:py-6 md:py-8">
            
            <!-- Logo et en-tête (Compacté et responsive) -->
            <div class="mb-3 sm:mb-4 md:mb-6 text-center">
                <a href="/" class="inline-flex items-center justify-center group">
                    <div class="p-2 sm:p-2.5 md:p-3 transition-transform duration-300 rounded-full shadow-lg bg-white/10 backdrop-blur-sm group-hover:scale-105">
                        <!-- Logo Image adapté -->
                        <img 
                            src="{{ asset('image_icon/android-icon-144x144.png') }}" 
                            alt="Logo GEST'PARC" 
                            class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 rounded-full object-contain drop-shadow-lg" 
                        />
                    </div>
                </a>
                <h1 class="mt-2 sm:mt-2.5 md:mt-3 text-xl sm:text-2xl md:text-3xl font-extrabold tracking-tight text-white drop-shadow-lg">
                    GEST'PARC
                </h1>
                <p class="mt-0.5 sm:mt-1 text-[11px] sm:text-sm font-medium text-center text-blue-100 drop-shadow px-2">
                    Votre plateforme de gestion
                </p>
            </div>

            <!-- Carte principale - Responsive -->
            <div class="relative w-full overflow-hidden border shadow-2xl bg-white/95 backdrop-blur-md rounded-xl sm:rounded-2xl border-white/20">
                
                <!-- Barre décorative -->
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-blue-600 to-blue-800 sm:h-1.5"></div>

                <!-- Contenu avec paddings adaptatifs -->
                <div class="p-4 sm:p-5 md:p-6 lg:p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer - Responsive -->
            <div class="relative z-10 mt-4 sm:mt-5 md:mt-6 text-[10px] sm:text-xs font-medium text-center text-white/70">
                <p>&copy; {{ date('Y') }} GEST'PARC. Tous droits réservés.</p>
            </div>
        </div>
    </div>
</body>

</html>