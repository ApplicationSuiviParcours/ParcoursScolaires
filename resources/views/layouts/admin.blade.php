<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Suivi de Parcours Scolaires') }} - Espace Administrateur</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Poppins', sans-serif; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.3); }

        @keyframes pulse-glow {
            0%, 100% { opacity: 1; box-shadow: 0 0 15px rgba(239, 68, 68, 0.5); }
            50% { opacity: 0.8; box-shadow: 0 0 25px rgba(239, 68, 68, 0.7); }
        }
        .badge-glow { animation: pulse-glow 2s ease-in-out infinite; }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        .status-indicator { animation: pulse-dot 2s ease-in-out infinite; }

        .glass-morphism { background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }

        .sidebar-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden; }
        .sidebar-bg::before { content: ''; position: absolute; width: 200%; height: 200%; top: -50%; left: -50%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: rotate 20s linear infinite; }
        @keyframes rotate { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.15); }

        .nav-link { transition: all 0.3s ease; position: relative; }
        .nav-link::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 0; height: 70%; background: white; border-radius: 0 4px 4px 0; transition: width 0.3s ease; }
        .nav-link.active::before, .nav-link:hover::before { width: 4px; }
        .nav-link:hover { padding-left: 1.25rem; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e' }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen antialiased">
    <div class="flex min-h-screen">
        
        <!-- Sidebar Admin -->
        <aside class="w-72 sidebar-bg fixed h-screen z-50 shadow-2xl flex flex-col">
            
            <!-- En-tête avec logo -->
            <div class="p-6 border-b border-white/20 relative z-10">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div class="bg-white/20 backdrop-blur-sm p-3 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 border-2 border-purple-700 rounded-full status-indicator"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-display font-bold text-white tracking-tight">EduTrack</h1>
                        <p class="text-xs text-purple-200 font-medium">Espace Administrateur</p>
                    </div>
                </div>
            </div>

            <!-- Profil utilisateur -->
            <div class="p-5 border-b border-white/20 relative z-10">
                <div class="glass-morphism rounded-2xl p-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-pink-400 via-purple-400 to-indigo-500 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-xl font-display font-bold text-white">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-white text-sm truncate">{{ Auth::user()->name ?? 'Administrateur' }}</p>
                            <p class="text-xs text-purple-200 mt-0.5">Administrateur</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Admin -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar relative z-10">
                <div class="mb-6">
                    <p class="text-xs font-bold text-purple-200/70 uppercase tracking-wider px-3 mb-3">Menu Principal</p>
                    
                    <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center space-x-3 px-4 py-3 text-white rounded-xl group {{ request()->routeIs('admin.dashboard') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/30' : 'bg-white/10' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <span class="font-medium text-sm flex-1">Tableau de bord</span>
                    </a>

                    <!-- Gestion Études -->
                    <div class="mt-4">
                        <p class="text-xs font-bold text-purple-200/70 uppercase tracking-wider px-3 mb-2">Gestion Études</p>
                        
                        <a href="{{ route('admin.eleves.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.eleves.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.eleves.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Élèves</span>
                            <span class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Eleve::count() }}</span>
                        </a>

                        <a href="{{ route('admin.enseignants.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.enseignants.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.enseignants.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Enseignants</span>
                            <span class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Enseignant::count() }}</span>
                        </a>

                        <a href="{{ route('admin.parents.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.parents.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.parents.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Parents</span>
                        </a>
                    </div>

                    <!-- Gestion Scolaire -->
                    <div class="mt-4">
                        <p class="text-xs font-bold text-purple-200/70 uppercase tracking-wider px-3 mb-2">Gestion Scolaire</p>
                        
                        <a href="{{ route('admin.classes.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.classes.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.classes.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></div>
                            <span class="font-medium text-sm flex-1">Classes</span>
                            <span class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Classe::count() }}</span>
                        </a>

                        <a href="{{ route('admin.matieres.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.matieres.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.matieres.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                            <span class="font-medium text-sm flex-1">Matières</span>
                            <span class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Matiere::count() }}</span>
                        </a>

                        <a href="{{ route('admin.classe_matieres.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.classe_matieres.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.classe_matieres.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg></div>
                            <span class="font-medium text-sm flex-1">Classe-Matières</span>
                        </a>

                        <a href="{{ route('admin.annee_scolaires.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.annee_scolaires.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.annee_scolaires.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Années scolaires</span>
                        </a>
                    </div>

                    <!-- Inscriptions -->
                    <div class="mt-4">
                        <p class="text-xs font-bold text-purple-200/70 uppercase tracking-wider px-3 mb-2">Inscriptions</p>
                        
                        <a href="{{ route('admin.inscriptions.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.inscriptions.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.inscriptions.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Inscriptions</span>
                            <span class="bg-white/20 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ \App\Models\Inscription::count() }}</span>
                        </a>

                        <a href="{{ route('admin.reinscriptions.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.reinscriptions.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.reinscriptions.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></div>
                            <span class="font-medium text-sm flex-1">Réinscriptions</span>
                        </a>
                    </div>

                    <!-- Suivi & Évaluations -->
                    <div class="mt-4">
                        <p class="text-xs font-bold text-purple-200/70 uppercase tracking-wider px-3 mb-2">Suivi & Évaluations</p>
                        
                        <a href="{{ route('admin.notes.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.notes.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.notes.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Notes</span>
                        </a>

                        <a href="{{ route('admin.absences.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.absences.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.absences.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Absences</span>
                        </a>

                        <a href="{{ route('admin.bulletins.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.bulletins.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.bulletins.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Bulletins</span>
                        </a>

                        <a href="{{ route('admin.emploi_du_temps.index') }}" class="nav-link flex items-center space-x-3 px-4 py-2.5 text-white rounded-xl group {{ request()->routeIs('admin.emploi_du_temps.*') ? 'active bg-white/20' : 'hover:bg-white/10' }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ request()->routeIs('admin.emploi_du_temps.*') ? 'bg-white/30' : 'bg-white/10' }}"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                            <span class="font-medium text-sm flex-1">Emploi du temps</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Déconnexion -->
            <div class="p-4 border-t border-white/20 relative z-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 px-4 py-3 text-white hover:bg-red-500/30 rounded-xl transition-all w-full group">
                        <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-white/10 group-hover:bg-red-500/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </div>
                        <span class="font-medium text-sm">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu Principal -->
        <main class="flex-1 ml-72">
            <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
                <div class="px-8 py-5 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-1 bg-gradient-to-b from-purple-600 via-indigo-600 to-blue-600 rounded-full"></div>
                        <div>
                            <h2 class="text-2xl font-display font-bold text-gray-900">@yield('header')</h2>
                            <p class="text-sm text-gray-500 mt-0.5">Année scolaire {{ \App\Models\AnneeScolaire::where('statut', true)->first()?->libelle ?? 'Non définie' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative hidden md:block">
                            <input type="text" placeholder="Rechercher..." class="w-80 pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-purple-500/20 focus:border-purple-500 bg-white/90">
                            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div class="flex items-center space-x-3 border-l border-gray-200 pl-4">
                            <div class="text-right hidden lg:block">
                                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name ?? 'Administrateur' }}</p>
                                <p class="text-xs text-gray-500">Administrateur</p>
                            </div>
                            <div class="w-11 h-11 bg-gradient-to-br from-purple-500 via-indigo-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md">
                                <span class="text-white font-display font-bold text-base">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8">@yield('content')</div>

            <footer class="mt-auto py-6 px-8 border-t border-gray-200 bg-white/30">
                <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600">
                    <p class="font-medium">© 2025 EduTrack - Tous droits réservés</p>
                </div>
            </footer>
        </main>
    </div>
</body>
</html>
