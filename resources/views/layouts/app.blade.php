<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GEST\'PARC') }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine JS (Requis pour les menus déroulants) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image_icon/favicon-32x32.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        

        body, html {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }
        
        .font-display { font-family: 'Poppins', sans-serif; }

        /* Scrollbar personnalisé */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        /* Animation pour les badges */
        @keyframes pulse-glow {
            0%, 100% { opacity: 1; box-shadow: 0 0 15px rgba(239, 68, 68, 0.5); }
            50% { opacity: 0.8; box-shadow: 0 0 25px rgba(239, 68, 68, 0.7); }
        }
        .badge-glow { animation: pulse-glow 2s ease-in-out infinite; }

        /* Animation pour le point de statut */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        .status-indicator { animation: pulse-dot 2s ease-in-out infinite; }

        /* Effet de verre moderne */
        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Gradient de fond pour la sidebar (Bleu Marine) */
        .sidebar-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #172554 100%);
            position: relative;
            overflow: hidden;
        }

        .dark .sidebar-bg {
             background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .sidebar-bg::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Effet hover pour les cartes */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15);
        }
        .dark .card-hover:hover {
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
        }

        /* Animation pour les items de navigation */
        .nav-link {
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 70%;
            background: white;
            border-radius: 0 4px 4px 0;
            transition: width 0.3s ease;
        }

        .nav-link.active::before,
        .nav-link:hover::before {
            width: 4px;
        }

        .nav-link:hover {
            padding-left: 1.25rem;
        }

        /* Effet ripple pour les boutons */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-ripple:active::after {
            width: 300px;
            height: 300px;
        }

        /* Animation pour la cloche de notification */
        @keyframes bell-ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-15deg); }
            20%, 40% { transform: rotate(15deg); }
        }

        .notification-bell:hover { animation: bell-ring 0.5s ease-in-out; }

        /* Empêcher le débordement horizontal */
        .overflow-x-hidden {
            overflow-x: hidden !important;
        }
    </style>

    <script>
        tailwind.config = {
            darkMode: 'class', // Active le mode sombre via la classe 'dark'
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="min-h-screen antialiased transition-colors duration-300 bg-gray-50 dark:bg-gray-900 overflow-x-hidden">

    <!-- Ajout de x-data pour gérer l'état de la sidebar globalement -->
    <div class="flex min-h-screen overflow-x-hidden" x-data="{ sidebarOpen: false }" @resize.window="if (window.innerWidth >= 768) sidebarOpen = false">

        <!-- Overlay pour mobile (fond assombri) -->
        <div x-show="sidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/50 md:hidden"
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar Moderne -->
        <!-- Modifications responsive :
             1. fixed inset-y-0 left-0
             2. transform -translate-x-full (caché par défaut sur mobile)
             3. md:translate-x-0 (visible sur desktop)
             4. transition pour l'animation
        -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col h-screen text-white shadow-2xl w-64 sm:w-72 sidebar-bg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto"
               :class="{ 'translate-x-0': sidebarOpen }">

            <!-- Bouton fermeture mobile -->
            <button @click="sidebarOpen = false" class="absolute text-white top-3 right-3 md:hidden focus:outline-none">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- En-tête avec logo -->
            <div class="relative z-10 p-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="bg-white/20 backdrop-blur-sm p-1.5 rounded-xl shadow-lg border border-white/20 transition-transform duration-300 hover:scale-105">
                            <img src="{{ asset('image_icon/apple-icon.png') }}" alt="Logo" class="w-10 h-10 object-contain drop-shadow-xl">
                        </div>
                        <div class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-green-400 border-2 border-purple-700 rounded-full shadow-lg"></div>
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold tracking-tight text-white font-display truncate">GEST'PARC</h1>
                        <p class="text-[10px] font-bold text-purple-200 uppercase tracking-widest opacity-80 truncate">
                            @php
                                $user = Auth::user();
                                if ($user) {
                                    if ($user->isAdmin()) echo 'Administrateur';
                                    elseif ($user->isEleve()) echo 'Élève';
                                    elseif ($user->isEnseignant()) echo 'Enseignant';
                                    elseif ($user->isParent()) echo 'Parent';
                                    else echo 'Utilisateur';
                                } else {
                                    echo 'Public';
                                }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>

            @php
                $user = Auth::user();
                $infoRole = 'Utilisateur';
                $anneeScolaireActive = \App\Models\AnneeScolaire::where('active', true)->first();
                if ($user) {
                    $role = $user->getRoleNames()->first() ?? 'eleve';
                    if ($user->isEleve() && $user->eleve) {
                        $inscription = $user->eleve->inscriptions()->where('annee_scolaire_id', $anneeScolaireActive?->id)->first();
                        $infoRole = $inscription?->classe?->nom ?? 'Élève';
                    } elseif ($user->isEnseignant() && $user->enseignant) {
                        $infoRole = $user->enseignant->specialite ?? 'Enseignant';
                    } elseif ($user->isParent() && $user->parentEleve) {
                        $nbEnfants = $user->parentEleve->eleves()->count();
                        $infoRole = $nbEnfants > 0 ? $nbEnfants . ' enfant(s)' : 'Parent';
                    } elseif ($user->isAdmin()) {
                        $infoRole = 'Administrateur';
                    }
                }
            @endphp

            <!-- Carte profil utilisateur -->
            <div class="relative z-10 p-5 border-b border-white/10">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-xl transition-all duration-300 hover:bg-white/20 group">
                    <div class="flex items-center space-x-3">
                        <div class="relative flex-shrink-0">
                            <!-- LOGIQUE PHOTO SIDEBAR -->
                            @if(Auth::check() && Auth::user()->photo)
                                <img src="{{ Storage::url(Auth::user()->photo) }}"
                                     alt="{{ Auth::user()->name }}"
                                     class="w-12 h-12 rounded-2xl object-cover shadow-2xl border-2 border-white/30 transition-transform duration-300 group-hover:scale-110">
                            @else
                                <div class="w-12 h-12 flex items-center justify-center bg-blue-800 rounded-2xl shadow-2xl border-2 border-white/30 transition-transform duration-300 group-hover:scale-110">
                                    <span class="text-xl font-bold text-white font-display uppercase">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                                </div>
                            @endif
                            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-purple-700 rounded-full shadow-lg"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate leading-tight">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                            <p class="text-[10px] text-purple-200 font-medium opacity-80 mb-1 truncate">{{ $infoRole }}</p>
                            <div class="inline-flex items-center px-2 py-0.5 rounded-full bg-green-500/20 border border-green-500/30">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                                <span class="text-[10px] text-green-300 font-bold tracking-tight">En ligne</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="relative z-10 flex-1 p-2 sm:p-3 md:p-4 space-y-0.5 overflow-y-auto custom-scrollbar">
                <div class="mb-4 sm:mb-6">
                    <p class="px-4 mb-4 text-[10px] font-bold tracking-widest uppercase text-purple-200/60">MENU PRINCIPAL</p>

                    {{-- ================= ELEVE MENU ================= --}}

                    @if(Auth::check() && $user && $user->isEleve())
                        <a href="{{ route('eleve.dashboard') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.dashboard') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.dashboard') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3"/></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Tableau de bord</span>
                        </a>
                        <a href="{{ route('eleve.bulletin') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.bulletin') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.bulletin') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes bulletins</span>
                        </a>
                        <a href="{{ route('eleve.absences') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.absences') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.absences') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes absences</span>
                        </a>
                        <a href="{{ route('eleve.emploi-du-temps') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.emploi-du-temps') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.emploi-du-temps') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                               <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mon emploi du temps</span>
                        </a>
                        <a href="{{ route('eleve.notes') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.notes') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.notes') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes Notes</span>
                        </a>
                        <a href="{{ route('eleve.parcours') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('eleve.parcours') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('eleve.parcours') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mon Parcours</span>
                        </a>
                    @endif

                    <!-- TEACHER MENU -->

                    @if(Auth::check() && $user && $user->isEnseignant())
                        <a href="{{ route('enseignant.dashboard') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('enseignant.dashboard') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('enseignant.dashboard') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Tableau de Bord</span>
                        </a>
                        <a href="{{ route('enseignant.classes') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('enseignant.classes*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('enseignant.classes*') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes Classes</span>
                        </a>
                        <a href="{{ route('enseignant.evaluations.index') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('enseignant.evaluations*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('enseignant.evaluations*') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes Évaluations</span>
                        </a>
                        <a href="{{ route('enseignant.notes.index') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('enseignant.notes*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('enseignant.notes*') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Saisir Notes</span>
                        </a>
                        <a href="{{ route('enseignant.absences.index') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('enseignant.absences*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('enseignant.absences*') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Gestion Absences</span>
                        </a>
                    @endif

                    <!-- PARENT MENU -->

                    @if(Auth::check() && $user && $user->isParent())
                        <a href="{{ route('parent.dashboard') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('parent.dashboard') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('parent.dashboard') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                               <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Tableau de bord</span>
                        </a>
                        <a href="{{ route('parent.enfants') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('parent.enfants*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('parent.enfants*') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Mes Enfants</span>
                        </a>
                    @endif

                    <!-- ADMIN MENU -->

                    @if(Auth::check() && $user && $user->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center space-x-2 sm:space-x-3 px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl group {{ request()->routeIs('admin.dashboard') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/30' : 'bg-white/10' }} group-hover:bg-white/20 transition-all">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                            </div>
                            <span class="flex-1 text-xs sm:text-sm font-medium">Tableau de Bord</span>
                        </a>

                        <!-- Gestion des Utilisateurs -->
                        <div x-data="{ open: {{ request()->routeIs('admin.eleves.*') || request()->routeIs('admin.enseignants.*') || request()->routeIs('admin.parents.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl hover:bg-white/10 transition-colors {{ request()->routeIs('admin.eleves.*') || request()->routeIs('admin.enseignants.*') || request()->routeIs('admin.parents.*') ? 'bg-white/10' : '' }}">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg bg-white/10">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <span class="font-medium text-xs sm:text-sm">Gestion des Utilisateurs</span>
                                </div>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="pl-12 pr-4 py-2 space-y-1">
                                <a href="{{ route('admin.eleves.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.eleves.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Gestion Élèves</a>
                                <a href="{{ route('admin.enseignants.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.enseignants.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Gestion Enseignants</a>
                                <a href="{{ route('admin.parents.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.parents.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Gestion des Parents</a>
                                {{-- <a href="{{ route('admin.eleve-parents.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.eleve-parents.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Liaison Élève-Parents</a> --}}
                            </div>
                        </div>

                        <!-- Configuration Scolaire -->
                        <div x-data="{ open: {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.matieres.*') || request()->routeIs('admin.classe_matieres.*') || request()->routeIs('admin.annee_scolaires.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl hover:bg-white/10 transition-colors {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.matieres.*') || request()->routeIs('admin.classe_matieres.*') || request()->routeIs('admin.annee_scolaires.*') ? 'bg-white/10' : '' }}">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg bg-white/10">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <span class="font-medium text-xs sm:text-sm">Configuration Scolaire</span>
                                </div>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="pl-12 pr-4 py-2 space-y-1">
                                <a href="{{ route('admin.annee_scolaires.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.annee_scolaires.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Années scolaires</a>
                                <a href="{{ route('admin.classes.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.classes.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Classes</a>
                                <a href="{{ route('admin.matieres.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.matieres.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Matières</a>
                                <a href="{{ route('admin.classe_matieres.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.classe_matieres.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Classe-Matières</a>
                            </div>
                        </div>

                        <!-- Inscriptions & Parcours -->
                        <div x-data="{ open: {{ request()->routeIs('admin.inscriptions.*') || request()->routeIs('admin.reinscriptions.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl hover:bg-white/10 transition-colors {{ request()->routeIs('admin.inscriptions.*') || request()->routeIs('admin.reinscriptions.*') ? 'bg-white/10' : '' }}">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg bg-white/10">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                    </div>
                                    <span class="font-medium text-xs sm:text-sm">Inscriptions & Parcours</span>
                                </div>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="pl-12 pr-4 py-2 space-y-1">
                                <a href="{{ route('admin.inscriptions.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.inscriptions.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Nouvelles Inscriptions</a>
                                <a href="{{ route('admin.reinscriptions.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.reinscriptions.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Réinscriptions</a>
                            </div>
                        </div>

                        <!-- Suivi & Évaluations -->
                        <div x-data="{ open: {{ request()->routeIs('admin.evaluations.*') || request()->routeIs('admin.notes.*') || request()->routeIs('admin.bulletins.*') || request()->routeIs('admin.absences.*') || request()->routeIs('admin.emploi_du_temps.*') || request()->routeIs('admin.enseignant_matiere_classes.*') ? 'true' : 'false' }} }">
                            <button @click="open = !open" class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl hover:bg-white/10 transition-colors {{ request()->routeIs('admin.evaluations.*') || request()->routeIs('admin.notes.*') || request()->routeIs('admin.bulletins.*') || request()->routeIs('admin.absences.*') || request()->routeIs('admin.emploi_du_temps.*') || request()->routeIs('admin.enseignant_matiere_classes.*') ? 'bg-white/10' : '' }}">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg bg-white/10">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <span class="font-medium text-xs sm:text-sm">Suivi & Évaluations</span>
                                </div>
                                <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" x-transition class="pl-12 pr-4 py-2 space-y-1">
                                <a href="{{ route('admin.evaluations.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.evaluations.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Évaluations</a>
                                <a href="{{ route('admin.notes.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.notes.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Notes</a>
                                <a href="{{ route('admin.bulletins.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.bulletins.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Bulletins</a>
                                <a href="{{ route('admin.absences.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.absences.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Absences</a>
                                <a href="{{ route('admin.emploi_du_temps.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.emploi_du_temps.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Emploi du temps</a>
                                <a href="{{ route('admin.enseignant_matiere_classes.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.enseignant_matiere_classes.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Enseignants-Classes</a>
                            </div>
                        </div>

                        <!-- Administration Système -->
                        <div class="pt-4 mt-4 border-t border-white/20">
                            <p class="px-4 mb-4 text-[10px] font-bold tracking-widest uppercase text-purple-200/60">PARAMÈTRES AVANCÉS</p>
                            <div x-data="{ open: {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.messages.*') ? 'true' : 'false' }} }">
                                <button @click="open = !open" class="w-full flex items-center justify-between px-3 sm:px-4 py-2 sm:py-3 text-white rounded-lg sm:rounded-xl hover:bg-white/10 transition-colors {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.messages.*') ? 'bg-white/10' : '' }}">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <div class="flex items-center justify-center w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 rounded-lg bg-white/10">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        </div>
                                        <span class="font-medium text-xs sm:text-sm">Admin Système</span>
                                    </div>
                                    <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                                <div x-show="open" x-transition class="pl-12 pr-4 py-2 space-y-1">
                                    <a href="{{ route('admin.users.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.users.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Comptes Utilisateurs</a>
                                    <a href="{{ route('admin.messages.index') }}" class="block py-1.5 text-xs sm:text-sm {{ request()->routeIs('admin.messages.*') ? 'text-white font-bold' : 'text-purple-200 hover:text-white' }}">Messages & Notifs</a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Divider -->
                <div class="my-3 sm:my-4 border-t border-white/20"></div>

                <!-- Paramètres -->
                <div>
                    <p class="px-4 mb-4 text-[10px] font-bold tracking-widest uppercase text-purple-200/60">PARAMÈTRES</p>
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 space-x-2 sm:space-x-3 text-white nav-link rounded-lg sm:rounded-xl hover:bg-white/10 group">
                        <div class="flex items-center justify-center transition-all rounded-lg w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-white/10 group-hover:bg-white/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium">Mon Profil</span>
                    </a>
                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 sm:px-4 py-2 sm:py-3 space-x-2 sm:space-x-3 text-white nav-link rounded-lg sm:rounded-xl hover:bg-white/10 group">
                        <div class="flex items-center justify-center transition-all rounded-lg w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-white/10 group-hover:bg-white/20">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium">Paramètres</span>
                    </a>
                </div>
            </nav>

            <!-- Bouton de déconnexion -->
            <div class="relative z-10 p-3 sm:p-4 border-t border-white/20">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2 sm:py-3 space-x-2 sm:space-x-3 text-white transition-all btn-ripple hover:bg-red-500/30 rounded-lg sm:rounded-xl group">
                        <div class="flex items-center justify-center transition-all rounded-lg w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 bg-white/10 group-hover:bg-red-500/40">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </div>
                        <span class="text-xs sm:text-sm font-medium">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <!-- Modification responsive : ml-0 sur mobile, ml-64 sm:ml-72 sur md+ -->
        <main class="flex-1 ml-0 md:ml-64 lg:ml-72 overflow-x-hidden">

            <!-- Barre de navigation supérieure -->
            <header class="sticky top-0 z-40 transition-colors duration-300 border-b shadow-sm bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-gray-200/50 dark:border-gray-700/50">
                <div class="flex items-center justify-between px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5">

                    <!-- Titre de la page & Menu Mobile -->
                    <div class="flex items-center space-x-2 sm:space-x-4 min-w-0">

                        <!-- BOUTON HAMBURGER MOBILE -->
                        <button @click="sidebarOpen = true" class="p-1.5 sm:p-2 text-gray-600 rounded-lg md:hidden hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 focus:outline-none">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>

                        <div class="w-0.5 h-8 sm:h-10 md:h-12 rounded-full bg-blue-900"></div>
                        <div class="min-w-0">
                            <h2 class="text-sm sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white font-display truncate">
                                @yield('header')
                            </h2>
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">Année scolaire {{ $anneeScolaireActive ? $anneeScolaireActive->nom : 'Non définie' }}</p>
                        </div>
                    </div>

                    <!-- Section droite -->
                    <div class="flex items-center space-x-1 sm:space-x-2 md:space-x-3 lg:space-x-4">

                        <!-- Barre de recherche (Cachée sur très petit mobile) -->
                        <form action="{{ route('search') }}" method="GET" class="relative hidden md:block">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher..."
                                class="w-32 sm:w-48 md:w-64 lg:w-80 pl-8 sm:pl-10 pr-12 py-1.5 sm:py-2 border border-gray-200 dark:border-gray-700 rounded-lg sm:rounded-xl text-xs sm:text-sm bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-blue-900 transition-all placeholder:text-gray-400 dark:placeholder:text-gray-500">
                            <svg class="absolute w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 -translate-y-1/2 dark:text-gray-500 left-2.5 sm:left-3 top-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-blue-900 hover:bg-blue-800 text-white text-[9px] sm:text-xs font-medium rounded-md sm:rounded-lg transition-all duration-300 hover:scale-105">
                                OK
                            </button>
                        </form>

                        <!-- Theme Toggle -->
                        <button id="theme-toggle" type="button" class="p-1.5 sm:p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all focus:outline-none">
                            <svg id="theme-toggle-dark-icon" class="hidden w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-toggle-light-icon" class="hidden w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
                        </button>

                        {{-- Notifications clochette --}}
                        @php
                            $notificationCount = 0;
                            $recentNotifications = collect();
                            if(Auth::check()) {
                                $notificationCount = Auth::user()->unreadNotifications()->count();
                                $recentNotifications = Auth::user()->unreadNotifications()->latest()->limit(5)->get();
                            }
                        @endphp
                        <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-1.5 sm:p-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all group">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 transition-colors notification-bell group-hover:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    <span id="notificationBadge" class="absolute top-0 right-0 min-w-[16px] h-4 bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-900 text-white text-[8px] sm:text-[10px] flex items-center justify-center px-0.5 badge-glow {{ $notificationCount > 0 ? '' : 'hidden' }}">
                                        {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                                    </span>
                                </button>

                                <!-- Panneau de notifications -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                     class="absolute right-0 z-[999] mt-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-2xl overflow-hidden"
                                     style="transform-origin: top right; width: 320px; max-width: none;">

                                    <!-- En-tête du panneau -->
                                    <div class="flex items-center justify-between px-4 py-3 bg-blue-900 dark:from-purple-900/30 dark:to-indigo-900/30 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-purple-900/50 flex items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-yellow-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                            </div>
                                            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Notifications</h3>
                                            @if($notificationCount > 0)
                                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-red-100 text-red-600 rounded-full">{{ $notificationCount }}</span>
                                            @endif
                                        </div>
                                        @if($notificationCount > 0)
                                        <form action="{{ route('notifications.read-all') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-yellow-600 hover:text-purple-800 dark:text-purple-400 font-medium transition-colors">Tout lire</button>
                                        </form>
                                        @endif
                                    </div>

                                    <!-- Liste des notifications -->
                                    <div class="overflow-y-auto max-h-64 sm:max-h-80 divide-y divide-gray-50 dark:divide-gray-700/50">
                                        @forelse($recentNotifications as $notification)
                                            <a href="{{ $notification->link ?? route('notifications.index') }}"
                                               class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors block">
                                                <div class="flex-shrink-0 mt-0.5">
                                                    @if($notification->type === 'success')
                                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        </div>
                                                    @elseif($notification->type === 'warning')
                                                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 leading-snug truncate">{{ $notification->title }}</p>
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-snug mt-0.5 line-clamp-2">{{ $notification->message }}</p>
                                                    <p class="mt-1 text-[10px] text-gray-400 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="flex flex-col items-center justify-center py-8 px-4">
                                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                                </div>
                                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Aucune notification</p>
                                                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">Vous êtes à jour !</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- Footer -->
                                    <div class="px-4 py-2.5 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                        <a href="{{ route('notifications.index') }}" class="text-xs text-yellow-600 hover:text-purple-800 font-medium transition-colors flex items-center justify-center gap-1">
                                            Voir toutes les notifications
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </div>
                        </div>

                        <!-- Profil utilisateur avec photo -->
                        <div class="flex items-center pl-1 sm:pl-2 md:pl-3 space-x-1 sm:space-x-2 md:space-x-3 border-l border-gray-200 dark:border-gray-700">

                            <!-- Nom masqué sur mobile pour gagner de la place -->
                            <div class="hidden text-right lg:block">
                                <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate max-w-[100px]">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                                <p class="text-[9px] sm:text-xs text-gray-500 dark:text-gray-400 truncate">{{ $userRole ?? 'Élève' }}</p>
                            </div>

                            <!-- Menu déroulant du profil -->
                            <div class="relative" x-data="{ open: false }">
                                <div @click="open = !open" class="relative cursor-pointer group">

                                    <!-- LOGIQUE PHOTO HEADER -->
                                    @if(Auth::check() && Auth::user()->photo)
                                        <img src="{{ Storage::url(Auth::user()->photo) }}"
                                             alt="{{ Auth::user()->name }}"
                                             class="object-cover transition-transform duration-300 shadow-md w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 rounded-lg sm:rounded-xl group-hover:scale-105 ring-2 ring-white dark:ring-gray-900">
                                    @else
                                        <div class="flex items-center justify-center transition-transform duration-300 shadow-md w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-blue-900 rounded-lg sm:rounded-xl group-hover:scale-105">
                                            <span class="text-xs sm:text-sm md:text-base font-bold text-white font-display">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
                                        </div>
                                    @endif

                                    <!-- Indicateur de statut en ligne -->
                                    <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-400 border-2 border-white dark:border-gray-900 rounded-full status-indicator animate-pulse"></div>
                                </div>

                                <!-- Menu déroulant profil -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                                     class="absolute right-0 z-[999] bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-2xl overflow-hidden"
                                     style="transform-origin: top right; width: 240px; max-width: none; margin-top: 12px;">

                                    <!-- En-tête du menu profil avec avatar -->
                                    <div class="px-4 py-3 bg-blue-900 dark:from-purple-900/30 dark:to-indigo-900/30 border-b border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <!-- Avatar -->
                                            @if(Auth::check() && Auth::user()->photo)
                                                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-white shadow-sm flex-shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-xl bg-blue-900 flex items-center justify-center text-white font-bold text-sm shadow-sm flex-shrink-0">
                                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
                                                <p class="text-[10px] text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Liens du menu -->
                                    <div class="py-1">
                                        <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-blue-900 dark:hover:text-purple-400 transition-colors group">
                                            <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-purple-900/40 flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-yellow-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            </div>
                                            <span class="text-xs font-medium">Mon profil</span>
                                        </a>
                                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-blue-900 dark:hover:text-purple-400 transition-colors group">
                                            <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-purple-900/40 flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-yellow-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            </div>
                                            <span class="text-xs font-medium">Paramètres</span>
                                        </a>
                                    </div>
                                    
                                    <!-- Profil Security (Mot de passe) -->
                                    <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                                        <a href="{{ route('profile.password') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 hover:text-blue-900 dark:hover:text-purple-400 transition-colors group">
                                            <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-purple-900/40 flex items-center justify-center transition-colors flex-shrink-0">
                                                <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-yellow-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                            </div>
                                            <span class="text-xs font-medium">Sécurité</span>
                                        </a>
                                    </div>

                                    <!-- Déconnexion -->
                                    <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors group">
                                                <div class="w-7 h-7 rounded-lg bg-red-50 dark:bg-red-900/30 group-hover:bg-red-100 dark:group-hover:bg-red-900/50 flex items-center justify-center transition-colors flex-shrink-0">
                                                    <svg class="w-3.5 h-3.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                                </div>
                                                <span class="text-xs font-medium">Déconnexion</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Zone de contenu -->
            <div class="p-2 sm:p-3 md:p-4 lg:p-6 xl:p-8 overflow-x-hidden">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5 lg:py-6 mt-auto transition-colors border-t border-gray-200 dark:border-gray-700 bg-white/30 dark:bg-gray-800/50 backdrop-blur-sm">
                <div class="flex flex-col items-center justify-between space-y-2 text-[10px] sm:text-xs md:text-sm text-gray-600 dark:text-gray-400 md:flex-row md:space-y-0">
                    <p class="font-medium">© 2026 GEST'PARC - Tous droits réservés</p>
                    <div class="flex items-center space-x-3 sm:space-x-4 md:space-x-6">
                        <a href="#" class="font-medium transition-colors hover:text-yellow-600 dark:hover:text-purple-400">Aide</a>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <a href="#" class="font-medium transition-colors hover:text-yellow-600 dark:hover:text-purple-400">Contact</a>
                        <span class="text-gray-300 dark:text-gray-600">•</span>
                        <a href="#" class="font-medium transition-colors hover:text-yellow-600 dark:hover:text-purple-400">Confidentialité</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // 1. Dark Mode Logic
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');
            themeToggleLightIcon.classList.add('hidden');
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // toggle theme
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        });

        // 2. Animation for nav items
        document.addEventListener('DOMContentLoaded', function () {
            const navItems = document.querySelectorAll('.nav-link');
            navItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 50);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>