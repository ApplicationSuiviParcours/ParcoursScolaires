{{-- resources/views/layouts/navigation.blade.php --}}
<nav x-data="{ open: false }" class="bg-gradient-to-r from-white to-gray-50 border-b border-gray-200 shadow-sm sticky top-0 z-50 backdrop-blur-sm bg-white/95 overflow-x-hidden">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 xl:px-8">
        <div class="flex justify-between h-14 sm:h-16">
            <div class="flex">
                <!-- Logo avec animation - Responsive -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="group relative">
                        <div class="absolute inset-0 bg-blue-600 rounded-lg opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <x-application-logo class="block h-7 w-auto sm:h-8 md:h-9 fill-current text-gray-800 group-hover:text-blue-600 transition-colors duration-300" />
                    </a>
                </div>

                <!-- Navigation Links avec indicateur actif amélioré - Responsive -->
                <div class="hidden sm:flex sm:-my-px sm:ms-6 md:ms-8 lg:ms-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="relative px-2 md:px-3 lg:px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">{{ __('Tableau de bord') }}</span>
                        </div>
                    </x-nav-link>

                    <!-- Ajout d'autres liens de navigation -->
                    @if(Auth::user()->role === 'admin')
                    <x-nav-link :href="route('admin.eleves.index')" :active="request()->routeIs('admin.eleves*')" class="relative px-2 md:px-3 lg:px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">{{ __('Élèves') }}</span>
                        </div>
                    </x-nav-link>

                    <x-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes*')" class="relative px-2 md:px-3 lg:px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">{{ __('Classes') }}</span>
                        </div>
                    </x-nav-link>
                    @endif

                    @if(Auth::user()->role === 'eleve')
                    <x-nav-link :href="route('eleve.notes')" :active="request()->routeIs('eleve.notes*')" class="relative px-2 md:px-3 lg:px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">{{ __('Notes') }}</span>
                        </div>
                    </x-nav-link>

                    <x-nav-link :href="route('eleve.absences')" :active="request()->routeIs('eleve.absences*')" class="relative px-2 md:px-3 lg:px-4 py-2 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-1 sm:space-x-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs sm:text-sm md:text-base">{{ __('Absences') }}</span>
                        </div>
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown avec design amélioré - Responsive -->
            <div class="hidden sm:flex sm:items-center sm:ms-4 md:ms-6">
                <div class="relative ml-2 sm:ml-3">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 sm:space-x-3 px-2 sm:px-3 md:px-4 py-1.5 sm:py-2 rounded-xl bg-gradient-to-r from-gray-50 to-white border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all duration-200 group">
                                <!-- Avatar utilisateur - Responsive -->
                                <div class="relative">
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-semibold text-xs sm:text-sm shadow-sm">
                                        {{ substr(Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1) ?? '' }}
                                    </div>
                                    <span class="absolute bottom-0 right-0 w-2 h-2 sm:w-2.5 sm:h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                </div>
                                
                                <div class="text-left hidden lg:block">
                                    <div class="text-xs sm:text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors truncate max-w-[100px]">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <div class="text-[10px] sm:text-xs text-gray-500">
                                        {{ Auth::user()->role === 'admin' ? 'Administrateur' : (Auth::user()->role === 'eleve' ? 'Élève' : 'Utilisateur') }}
                                    </div>
                                </div>

                                <svg class="h-3 w-3 sm:h-4 sm:w-4 text-gray-400 group-hover:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- En-tête du dropdown - Responsive -->
                            <div class="px-3 sm:px-4 py-2 sm:py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <p class="text-[10px] sm:text-xs text-gray-500">Connecté en tant que</p>
                                <p class="text-xs sm:text-sm font-semibold text-gray-700 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            <!-- Lien vers le profil -->
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 hover:bg-blue-50 transition-colors">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-xs sm:text-sm">{{ __('Mon profil') }}</span>
                            </x-dropdown-link>

                            <!-- Séparateur -->
                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Déconnexion -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span class="text-xs sm:text-sm">{{ __('Déconnexion') }}</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger avec design amélioré - Responsive -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-1.5 sm:p-2 rounded-xl text-gray-500 hover:text-blue-600 hover:bg-blue-50 focus:outline-none focus:bg-blue-50 focus:text-blue-600 transition-all duration-200">
                    <svg class="h-5 w-5 sm:h-6 sm:w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu avec design amélioré - Responsive -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t border-gray-100 shadow-lg">
        <!-- Informations utilisateur mobile - Responsive -->
        <div class="px-3 sm:px-4 py-2 sm:py-3 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center text-white font-semibold text-sm sm:text-base">
                    {{ substr(Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->name, strpos(Auth::user()->name, ' ') + 1, 1) ?? '' }}
                </div>
                <div class="ml-2 sm:ml-3 min-w-0">
                    <div class="font-medium text-sm sm:text-base text-gray-800 truncate">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-xs sm:text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
        </div>

        <div class="pt-2 pb-3 space-y-0.5 sm:space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs sm:text-sm">{{ __('Tableau de bord') }}</span>
            </x-responsive-nav-link>

            @if(Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.eleves.index')" :active="request()->routeIs('admin.eleves*')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <span class="text-xs sm:text-sm">{{ __('Élèves') }}</span>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes*')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="text-xs sm:text-sm">{{ __('Classes') }}</span>
            </x-responsive-nav-link>
            @endif

            @if(Auth::user()->role === 'eleve')
            <x-responsive-nav-link :href="route('eleve.notes')" :active="request()->routeIs('eleve.notes*')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="text-xs sm:text-sm">{{ __('Notes') }}</span>
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('eleve.absences')" :active="request()->routeIs('eleve.absences*')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs sm:text-sm">{{ __('Absences') }}</span>
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Lien vers le profil mobile - Responsive -->
        <div class="pt-3 sm:pt-4 pb-1 border-t border-gray-200">
            <div class="mt-2 sm:mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm">{{ __('Mon profil') }}</span>
                </x-responsive-nav-link>

                <!-- Déconnexion mobile -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center space-x-2 px-3 sm:px-4 py-2 sm:py-2.5 text-red-600">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="text-xs sm:text-sm">{{ __('Déconnexion') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

@push('styles')
<style>
    /* Styles pour éviter le débordement horizontal */
    * {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    nav {
        overflow-x: hidden;
        width: 100%;
    }
    
    /* Animation pour le dropdown */
    [x-cloak] { display: none !important; }
    
    /* Animation de transition pour le menu mobile */
    .sm\:hidden {
        transition: all 0.3s ease-in-out;
    }
    
    /* Effet de survol pour les liens */
    .nav-link-hover {
        position: relative;
    }
    
    .nav-link-hover::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        transition: width 0.3s ease;
    }
    
    .nav-link-hover:hover::after {
        width: 80%;
    }
    
    /* Animation de pulse pour l'indicateur de connexion */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .animate-pulse {
        animation: pulse 2s infinite;
    }
    
    /* Empêcher le débordement horizontal */
    .overflow-x-hidden {
        overflow-x: hidden !important;
    }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .max-w-7xl {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        /* Réduire la hauteur de la barre de navigation */
        .h-16 {
            height: 3.5rem;
        }
        
        /* Ajuster les tailles de police */
        .text-xs {
            font-size: 0.7rem;
        }
    }
</style>
@endpush