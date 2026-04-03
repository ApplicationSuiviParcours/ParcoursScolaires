@extends('layouts.app')

@section('title', 'Gestion des réinscriptions')

@section('header')
    <div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 py-6 sm:py-10 md:py-16 overflow-x-hidden">
        <!-- Arrière-plan animé -->
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute -top-24 -right-24 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-48 sm:w-64 md:w-96 h-48 sm:h-64 md:h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000">
            </div>
        </div>

        <!-- Particules flottantes -->
        <div class="absolute inset-0 overflow-hidden">
            @for($i = 1; $i <= 6; $i++)
                <div class="absolute w-1.5 h-1.5 sm:w-2 sm:h-2 bg-white rounded-full opacity-20 animate-float-{{ $i }}"
                    style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor
        </div>

        <div class="container mx-auto px-3 sm:px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4 md:gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-xl sm:text-sm md:text-sm lg:text-5xl font-bold text-white mb-2 sm:p-3 md:p-3 sm:mb-3 md:mb-4 animate-fade-in-up">
                        Gestion des réinscriptions
                    </h1>
                    <p
                         class="text-indigo-200 text-xs sm:text-sm md:text-base lg:text-lg xl:text-xl max-w-2xl mx-auto md:mx-0 animate-fade-in-up animation-delay-200">
                        Gérez efficacement les réinscriptions des élèves 
                    </p>
                </div>
                {{-- <div class="flex justify-center md:justify-end animate-fade-in-right">
                    <div class="bg-white/10 backdrop-blur-lg rounded-xl sm:rounded-2xl p-2 sm:p-3 md:p-4 border border-white/20">
                        <div class="flex items-center flex-columns space-x-2 sm:space-x-3">
                            <div class="w-2 h-2 sm:w-2.5 sm:h-2.5 md:w-3 md:h-3 bg-green-400 rounded-full animate-pulse flex-shrink-0"></div>
                            <span class="text-white font-medium text-xs sm:text-sm md:text-base">{{ now()->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Vague décorative -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 lg:px-6 py-6 sm:py-8 md:py-12 bg-gray-50 overflow-x-hidden">

        {{-- ── STATISTIQUES ─────────────────────────────────────────────
        xs → 1 col
        sm → 2 col
        lg → 4 col
        ──────────────────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5 lg:gap-6 mb-6 sm:mb-8 md:mb-10">

            <!-- Carte 1 : Total -->
            <div class="group cursor-pointer">
                <div
                    class="relative bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 md:mb-4">
                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-12 lg:h-12 bg-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-blue-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] sm:text-xs font-medium text-gray-400 group-hover:text-white/70 transition-colors duration-300">Total</span>
                        </div>
                        <div class="flex items-baseline justify-between">
                            <h3
                                class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300">
                                {{ $reinscriptions->total() }}</h3>
                            <span
                                class="text-[10px] sm:text-xs font-medium text-green-500 group-hover:text-white/70 transition-colors duration-300">+12%</span>
                        </div>
                        <div class="mt-2 sm:mt-3 md:mt-4 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-progress"
                                style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 2 : Confirmées -->
            <div class="group cursor-pointer">
                <div
                    class="relative bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 md:mb-4">
                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-12 lg:h-12 bg-green-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-green-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-1 sm:mb-2">
                            {{ $reinscriptions->where('statut', 'confirmee')->count() }}</h3>
                        <p class="text-[10px] sm:text-xs text-gray-500 group-hover:text-white/70 transition-colors duration-300">Confirmées
                        </p>
                        <div
                            class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 3 : En attente -->
            <div class="group cursor-pointer">
                <div
                    class="relative bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 md:mb-4">
                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-12 lg:h-12 bg-yellow-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-yellow-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-1 sm:mb-2">
                            {{ $reinscriptions->where('statut', 'en_attente')->count() }}</h3>
                        <p class="text-[10px] sm:text-xs text-gray-500 group-hover:text-white/70 transition-colors duration-300">En attente
                        </p>
                        <div class="mt-2 sm:mt-3 md:mt-4 flex space-x-1">
                            @for($i = 0; $i < 3; $i++)
                                <div class="h-1 w-full bg-yellow-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-500 animate-pulse" style="width: {{ rand(60, 90) }}%"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte 4 : Annulées -->
            <div class="group cursor-pointer">
                <div
                    class="relative bg-white rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-red-500 to-rose-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-3 sm:p-4 md:p-5 lg:p-6">
                        <div class="flex items-center justify-between mb-2 sm:mb-3 md:mb-4">
                            <div
                                class="w-9 h-9 sm:w-10 sm:h-10 md:w-11 md:h-11 lg:w-12 lg:h-12 bg-red-100 rounded-lg sm:rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-red-600 group-hover:text-white transition-colors duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-1 sm:mb-2">
                            {{ $reinscriptions->where('statut', 'annulee')->count() }}</h3>
                        <p class="text-[10px] sm:text-xs text-gray-500 group-hover:text-white/70 transition-colors duration-300">Annulées
                        </p>
                        <div class="absolute top-1 right-1 sm:top-2 sm:right-2 w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14">
                            <svg class="w-full h-full text-red-200 group-hover:text-white/20 transition-colors duration-300"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── FILTRES ──────────────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl mb-6 sm:mb-8 md:mb-10 overflow-hidden transition-all duration-500 hover:shadow-2xl"
            x-data="{ open: true }">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5 border-b border-gray-200 flex items-center justify-between cursor-pointer"
                @click="open = !open">
                <div class="flex items-center space-x-1.5 sm:space-x-2 md:space-x-3 min-w-0">
                    <div
                        class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-indigo-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h2 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">Filtres avancés</h2>
                    <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-indigo-100 text-indigo-700 text-[9px] sm:text-xs font-medium rounded-full flex-shrink-0">3
                        actifs</span>
                </div>
                <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-gray-500 transform transition-transform duration-300 flex-shrink-0 ml-2"
                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>

            <div x-show="open" x-transition:enter="transition-all duration-500 ease-out"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition-all duration-300 ease-in"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4" class="p-3 sm:p-4 md:p-5 lg:p-6 xl:p-8">
                <form method="GET" action="{{ route('admin.reinscriptions.index') }}">
                    {{-- 1 col xs → 2 col sm → 4 col lg --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5 lg:gap-6">

                        <!-- Recherche -->
                        <div class="group">
                            <label
                                class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2 group-hover:text-indigo-600 transition-colors duration-300">Recherche</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 md:h-5 md:w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Nom, prénom, matricule..." class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200
                                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                                              transition-all duration-300 group-hover:border-indigo-300 text-xs sm:text-sm">
                            </div>
                        </div>

                        <!-- Année scolaire -->
                        <div class="group">
                            <label
                                class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2 group-hover:text-indigo-600 transition-colors duration-300">Année
                                scolaire</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 md:h-5 md:w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <select name="annee_scolaire_id"
                                    class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200
                                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                                               transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white text-xs sm:text-sm">
                                    <option value="">Toutes les années</option>
                                    @foreach($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Classe -->
                        <div class="group">
                            <label
                                class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2 group-hover:text-indigo-600 transition-colors duration-300">Classe</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 md:h-5 md:w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                </div>
                                <select name="classe_id"
                                    class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200
                                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                                               transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white text-xs sm:text-sm">
                                    <option value="">Toutes les classes</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="group">
                            <label
                                class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2 group-hover:text-indigo-600 transition-colors duration-300">Statut</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 md:h-5 md:w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select name="statut"
                                    class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-10 pr-3 sm:pr-4 py-1.5 sm:py-2 md:py-2.5 lg:py-3 rounded-lg sm:rounded-xl border-2 border-gray-200
                                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200
                                               transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white text-xs sm:text-sm">
                                    <option value="">Tous les statuts</option>
                                    @foreach($statuts as $value => $label)
                                        <option value="{{ $value }}" {{ request('statut') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div
                        class="flex flex-col sm:flex-row justify-end gap-2 sm:gap-3 md:gap-4 mt-4 sm:mt-5 md:mt-6 lg:mt-8 pt-3 sm:pt-4 md:pt-5 border-t border-gray-200">
                        <a href="{{ route('admin.reinscriptions.index') }}"
                            class="group inline-flex items-center justify-center px-3 sm:px-4 md:px-5 lg:px-6 py-1.5 sm:py-2 md:py-2.5 lg:py-3
                                  bg-white border-2 border-gray-300 rounded-lg sm:rounded-xl text-gray-700
                                  hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 transform hover:scale-105 text-xs sm:text-sm font-medium">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1.5 text-gray-500 group-hover:rotate-180 transition-transform duration-500 flex-shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Réinitialiser
                        </a>
                        <button type="submit"
                            class="group inline-flex items-center justify-center px-4 sm:px-5 md:px-6 lg:px-8 py-1.5 sm:py-2 md:py-2.5 lg:py-3
                                       bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                                       text-white font-medium rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-xs sm:text-sm">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1.5 group-hover:animate-bounce flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Appliquer les filtres
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ── BOUTON FLOTTANT ─────────────────────────────────────────── --}}
        <div class="fixed bottom-4 sm:bottom-6 md:bottom-8 right-3 sm:right-4 md:right-6 lg:right-8 z-50">
            <a href="{{ route('admin.reinscriptions.create') }}"
                class="group relative flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16
                      bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700
                      text-white rounded-full shadow-2xl transition-all duration-500 transform hover:scale-110 hover:rotate-90" x-data="{ tooltip: false }"
                @mouseenter="tooltip = true" @mouseleave="tooltip = false">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <!-- Tooltip (caché sur mobile, visible sur desktop) -->
                <div x-show="tooltip" x-transition:enter="transition-all duration-300 ease-out"
                    x-transition:enter-start="opacity-0 transform -translate-x-2"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition-all duration-200 ease-in"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform -translate-x-2"
                    class="hidden sm:block absolute right-full mr-2 sm:mr-3 md:mr-4 whitespace-nowrap bg-gray-900 text-white px-2 sm:px-3 md:px-4 py-1 sm:py-1.5 md:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs md:text-sm font-medium">
                    Nouvelle réinscription
                    <div
                        class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 rotate-45 w-1.5 h-1.5 sm:w-2 sm:h-2 bg-gray-900">
                    </div>
                </div>
            </a>
        </div>

        {{-- ── TABLEAU / CARTES ──────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl overflow-hidden transition-all duration-500 hover:shadow-2xl">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5 border-b border-gray-200">
                <div class="flex items-center justify-between flex-wrap gap-2 sm:gap-3">
                    <div class="flex items-center space-x-1.5 sm:space-x-2 md:space-x-3 min-w-0">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-indigo-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                        <h2 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800 truncate">Liste des réinscriptions</h2>
                        <span
                            class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-indigo-100 text-indigo-700 text-[9px] sm:text-xs font-medium rounded-full flex-shrink-0">
                            {{ $reinscriptions->total() }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-1 sm:space-x-2">
                        <button class="p-1.5 sm:p-2 hover:bg-white rounded-lg transition-colors duration-300">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </button>
                        <button class="p-1.5 sm:p-2 hover:bg-white rounded-lg transition-colors duration-300">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABLEAU — visible sur md+ --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Élève</th>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Classe</th>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Année</th>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th
                                class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 text-left text-[10px] lg:text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                         </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($reinscriptions as $index => $reinscription)
                            @php
                                $statutStyles = [
                                    'confirmee' => ['bg-green-100', 'text-green-700', 'ring-green-500/30'],
                                    'en_attente' => ['bg-yellow-100', 'text-yellow-700', 'ring-yellow-500/30'],
                                    'annulee' => ['bg-red-100', 'text-red-700', 'ring-red-500/30'],
                                ];
                                $style = $statutStyles[$reinscription->statut] ?? ['bg-gray-100', 'text-gray-700', 'ring-gray-500/30'];
                            @endphp
                            <tr class="group hover:bg-indigo-50 transition-all duration-300 cursor-pointer"
                                x-data="{ show: false }" x-init="setTimeout(() => show = true, {{ $index * 50 }})" x-show="show"
                                x-transition:enter="transition-all duration-500 ease-out"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                @click="window.location.href = '{{ route('admin.reinscriptions.show', $reinscription) }}'">

                                <!-- Élève -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5">
                                    <div class="flex items-center">
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-8 h-8 lg:w-9 lg:h-9 xl:w-10 xl:h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg sm:rounded-xl flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                {{ strtoupper(substr($reinscription->eleve->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($reinscription->eleve->nom ?? '?', 0, 1)) }}
                                            </div>
                                            <div
                                                class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 lg:w-3 lg:h-3 bg-green-400 border-2 border-white rounded-full group-hover:animate-ping">
                                            </div>
                                        </div>
                                        <div class="ml-2 lg:ml-3 xl:ml-4">
                                            <div
                                                class="text-xs sm:text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">
                                                {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}
                                            </div>
                                            @if($reinscription->eleve && $reinscription->eleve->matricule)
                                                <div class="text-[9px] lg:text-xs text-gray-500 flex items-center mt-0.5">
                                                    <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 mr-1 text-gray-400 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                    </svg>
                                                    {{ $reinscription->eleve->matricule }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                 </td>

                                <!-- Classe -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5">
                                    <div class="flex items-center">
                                        <div
                                            class="w-5 h-5 lg:w-6 lg:h-6 xl:w-7 xl:h-7 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                            <svg class="w-2.5 h-2.5 lg:w-3 lg:h-3 xl:w-3.5 xl:h-3.5 text-indigo-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                        </div>
                                        <span
                                            class="ml-1.5 lg:ml-2 xl:ml-3 text-xs sm:text-sm font-medium text-gray-900">{{ $reinscription->classe->nom ?? '' }}</span>
                                    </div>
                                 </td>

                                <!-- Année -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5">
                                    <span
                                        class="inline-flex items-center px-2 lg:px-3 xl:px-4 py-1 lg:py-1.5 xl:py-2 bg-purple-100 text-purple-700 text-[9px] lg:text-xs xl:text-sm font-medium rounded-lg lg:rounded-xl group-hover:scale-105 transition-transform duration-300">
                                        {{ $reinscription->anneeScolaire->nom ?? '' }}
                                    </span>
                                 </td>

                                <!-- Date -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 lg:w-3.5 lg:h-3.5 xl:w-4 xl:h-4 text-gray-400 mr-1 lg:mr-1.5 xl:mr-2 group-hover:text-indigo-500 transition-colors duration-300 flex-shrink-0"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span
                                            class="text-[9px] lg:text-xs xl:text-sm text-gray-600">{{ $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : '' }}</span>
                                    </div>
                                 </td>

                                <!-- Statut -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5">
                                    <span
                                        class="inline-flex items-center px-2 lg:px-3 xl:px-4 py-1 lg:py-1.5 xl:py-2 rounded-lg lg:rounded-xl text-[9px] lg:text-xs xl:text-sm font-medium {{ $style[0] }} {{ $style[1] }} ring-1 {{ $style[2] }} group-hover:scale-105 transition-transform duration-300">
                                        {{ $statuts[$reinscription->statut] ?? $reinscription->statut }}
                                    </span>
                                 </td>

                                <!-- Actions -->
                                <td class="px-3 lg:px-5 xl:px-8 py-3 lg:py-4 xl:py-5">
                                    <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap" @click.stop>
                                        <a href="{{ route('admin.reinscriptions.show', $reinscription) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.reinscriptions.edit', $reinscription) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <button onclick="confirmDelete({{ $reinscription->id }}, '{{ addslashes($reinscription->eleve->nom) }} {{ addslashes($reinscription->eleve->prenom) }}')" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <form id="delete-form-{{ $reinscription->id }}" action="{{ route('admin.reinscriptions.destroy', $reinscription) }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                    </div>
                                 </td>
                             </tr>
                        @empty
                             <tr>
                                <td colspan="6" class="px-4 sm:px-6 py-12 sm:py-16">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="relative">
                                            <div
                                                class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 bg-gray-100 rounded-full flex items-center justify-center mb-4 sm:mb-6 animate-bounce">
                                                <svg class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <div
                                                class="absolute -top-1 -right-1 w-6 h-6 sm:w-7 sm:h-7 bg-indigo-500 rounded-full animate-ping">
                                            </div>
                                        </div>
                                        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2">Aucune réinscription trouvée
                                        </h3>
                                        <p class="text-gray-500 max-w-md mb-4 sm:mb-6 md:mb-8 text-xs sm:text-sm md:text-base">
                                            @if(request()->anyFilled(['search', 'annee_scolaire_id', 'classe_id', 'statut']))
                                                Aucun résultat ne correspond à vos critères.
                                            @else
                                                Commencez par créer une nouvelle réinscription.
                                            @endif
                                        </p>
                                        <a href="{{ route('admin.reinscriptions.create') }}"
                                            class="inline-flex items-center px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 md:py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-xs sm:text-sm md:text-base">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Créer une réinscription
                                        </a>
                                    </div>
                                 </td>
                             </tr>
                        @endforelse
                    </tbody>
                 </table>
            </div>

            {{-- CARTES — visible sur mobile/tablette (< md) --}}
            <div class="md:hidden divide-y divide-gray-100">
                @forelse($reinscriptions as $reinscription)
                    @php
                        $statutStyles = [
                            'confirmee' => ['bg-green-100', 'text-green-700', 'ring-green-500/30'],
                            'en_attente' => ['bg-yellow-100', 'text-yellow-700', 'ring-yellow-500/30'],
                            'annulee' => ['bg-red-100', 'text-red-700', 'ring-red-500/30'],
                        ];
                        $style = $statutStyles[$reinscription->statut] ?? ['bg-gray-100', 'text-gray-700', 'ring-gray-500/30'];
                    @endphp
                    <div class="p-3 sm:p-4 hover:bg-indigo-50/50 transition-colors duration-200 cursor-pointer"
                        onclick="window.location.href='{{ route('admin.reinscriptions.show', $reinscription) }}'">

                        {{-- Ligne 1 : Avatar + Nom + Statut --}}
                        <div class="flex items-start justify-between gap-2 sm:gap-3 mb-2 sm:mb-3">
                            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                                <div class="relative flex-shrink-0">
                                    <div
                                        class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl sm:rounded-2xl flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg">
                                        {{ strtoupper(substr($reinscription->eleve->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($reinscription->eleve->nom ?? '?', 0, 1)) }}
                                    </div>
                                    <div
                                        class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-400 border-2 border-white rounded-full">
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">
                                        {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}
                                    </p>
                                    @if($reinscription->eleve && $reinscription->eleve->matricule)
                                        <p class="text-[9px] sm:text-[10px] text-gray-500 mt-0.5">{{ $reinscription->eleve->matricule }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-lg text-[9px] sm:text-xs font-medium flex-shrink-0
                                    {{ $style[0] }} {{ $style[1] }} ring-1 {{ $style[2] }}">
                                {{ $statuts[$reinscription->statut] ?? $reinscription->statut }}
                            </span>
                        </div>

                        {{-- Ligne 2 : Méta — grille 2 colonnes --}}
                        <div class="grid grid-cols-2 gap-x-3 sm:gap-x-4 gap-y-1.5 sm:gap-y-2 text-[10px] sm:text-xs bg-gray-50 rounded-lg sm:rounded-xl p-2 sm:p-3 mb-2 sm:mb-3">
                            <div>
                                <p class="text-gray-400 uppercase tracking-wide text-[8px] sm:text-[9px] mb-0.5">Classe</p>
                                <p class="text-gray-700 font-medium">{{ $reinscription->classe->nom ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 uppercase tracking-wide text-[8px] sm:text-[9px] mb-0.5">Année scolaire</p>
                                <p class="text-gray-700 font-medium">{{ $reinscription->anneeScolaire->nom ?? '-' }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-gray-400 uppercase tracking-wide text-[8px] sm:text-[9px] mb-0.5">Date de réinscription</p>
                                <p class="text-gray-700 font-medium">
                                    {{ $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        {{-- Ligne 3 : Actions --}}
                        <div class="flex items-center gap-1.5 sm:gap-2 pt-1.5 sm:pt-2 border-t border-gray-100" onclick="event.stopPropagation()">
                            <a href="{{ route('admin.reinscriptions.show', $reinscription) }}" class="flex-1 inline-flex items-center justify-center gap-1 py-1.5 sm:py-2 px-2 sm:px-3
                                          bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white
                                          rounded-lg sm:rounded-xl transition-all duration-300 text-[9px] sm:text-xs font-medium">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Voir
                            </a>
                            <a href="{{ route('admin.reinscriptions.edit', $reinscription) }}" class="flex-1 inline-flex items-center justify-center gap-1 py-1.5 sm:py-2 px-2 sm:px-3
                                          bg-yellow-50 text-yellow-600 hover:bg-yellow-600 hover:text-white
                                          rounded-lg sm:rounded-xl transition-all duration-300 text-[9px] sm:text-xs font-medium">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier
                            </a>
                            <button
                                onclick="confirmDelete({{ $reinscription->id }}, '{{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}')"
                                class="flex-1 inline-flex items-center justify-center gap-1 py-1.5 sm:py-2 px-2 sm:px-3
                                               bg-red-50 text-red-600 hover:bg-red-600 hover:text-white
                                               rounded-lg sm:rounded-xl transition-all duration-300 text-[9px] sm:text-xs font-medium">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Supprimer
                            </button>
                            <form id="delete-form-{{ $reinscription->id }}"
                                action="{{ route('admin.reinscriptions.destroy', $reinscription) }}" method="POST"
                                class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="px-3 sm:px-4 py-12 sm:py-16 text-center">
                        <div class="flex flex-col items-center gap-3 sm:gap-4">
                            <div class="relative">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-gray-100 rounded-full flex items-center justify-center animate-bounce">
                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                </div>
                                <div class="absolute -top-1 -right-1 w-6 h-6 sm:w-7 sm:h-7 bg-indigo-500 rounded-full animate-ping"></div>
                            </div>
                            <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-800">Aucune réinscription trouvée</h3>
                            <p class="text-gray-500 text-xs sm:text-sm max-w-xs">
                                @if(request()->anyFilled(['search', 'annee_scolaire_id', 'classe_id', 'statut']))
                                    Aucun résultat ne correspond à vos critères.
                                @else
                                    Commencez par créer une nouvelle réinscription.
                                @endif
                            </p>
                            <a href="{{ route('admin.reinscriptions.create') }}"
                                class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg sm:rounded-xl text-xs sm:text-sm transition-all duration-300 hover:shadow-xl">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Créer une réinscription
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        @if($reinscriptions->hasPages())
            <div class="bg-gray-50 px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5 border-t border-gray-200 mt-4 sm:mt-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
                    <p class="text-[10px] sm:text-xs text-gray-600">
                        Affichage de <span class="font-medium">{{ $reinscriptions->firstItem() }}</span> à
                        <span class="font-medium">{{ $reinscriptions->lastItem() }}</span> sur
                        <span class="font-medium">{{ $reinscriptions->total() }}</span> résultats
                    </p>
                    <div class="overflow-x-auto w-full sm:w-auto">
                        {{ $reinscriptions->withQueryString()->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ── MODAL SUPPRESSION ─────────────────────────────────────────── --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" id="modal-overlay"></div>
        <div class="flex min-h-full items-end sm:items-center justify-center p-3 sm:p-6">
            <div class="relative bg-white rounded-xl sm:rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
                <div class="bg-white px-4 sm:px-5 md:px-6 pt-5 sm:pt-6 pb-4">
                    <div class="flex items-start gap-3 sm:gap-4">
                        <div
                            class="flex-shrink-0 flex items-center justify-center h-10 w-10 sm:h-11 sm:w-11 md:h-12 md:w-12 rounded-full bg-red-100 animate-pulse">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-1">Confirmer la suppression</h3>
                            <p class="text-xs sm:text-sm text-gray-500" id="modal-message">Êtes-vous sûr de vouloir supprimer cette
                                réinscription ?</p>
                            <p class="text-[10px] sm:text-xs text-gray-400 mt-1" id="modal-eleve-name"></p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 sm:px-5 md:px-6 py-3 sm:py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-2 sm:gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="w-full sm:w-auto inline-flex justify-center items-center px-3 sm:px-4 py-1.5 sm:py-2
                                   border border-gray-300 rounded-lg sm:rounded-xl bg-white text-xs sm:text-sm font-medium text-gray-700
                                   hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                        Annuler
                    </button>
                    <button type="button" onclick="executeDelete()" class="w-full sm:w-auto inline-flex justify-center items-center px-3 sm:px-4 py-1.5 sm:py-2
                                   bg-red-600 hover:bg-red-700 text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-medium
                                   transition-all duration-300 transform hover:scale-105 shadow-md">
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── TOAST ──────────────────────────────────────────────────────── --}}
    <div id="toast" class="fixed bottom-4 sm:bottom-5 md:bottom-6 left-3 sm:left-4 md:left-6 z-50 hidden max-w-[calc(100%-1.5rem)] sm:max-w-sm">
        <div class="bg-green-500 text-white px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 rounded-lg sm:rounded-xl shadow-2xl flex items-center space-x-2 sm:space-x-3">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="toast-message" class="text-xs sm:text-sm md:text-base">Action effectuée avec succès</span>
        </div>
    </div>
@endsection

@push('styles')
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
        
        .overflow-x-hidden {
            overflow-x: hidden !important;
        }
        
        @keyframes float-1 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(10px, -10px) rotate(5deg); }
            66% { transform: translate(-5px, 5px) rotate(-5deg); }
        }

        @keyframes float-2 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(-15px, -5px) rotate(-8deg); }
            75% { transform: translate(5px, 10px) rotate(3deg); }
        }

        @keyframes float-3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-8px, -8px) scale(1.1); }
        }

        @keyframes float-4 {
            0%, 100% { transform: translate(0, 0); }
            40% { transform: translate(12px, -12px); }
            80% { transform: translate(-8px, 4px); }
        }

        @keyframes float-5 {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            30% { transform: translate(-10px, -15px) rotate(-12deg); }
            70% { transform: translate(5px, 8px) rotate(8deg); }
        }

        @keyframes float-6 {
            0%, 100% { transform: translate(0, 0); }
            20% { transform: translate(15px, -5px); }
            60% { transform: translate(-10px, 10px); }
        }

        .animate-float-1 { animation: float-1 12s ease-in-out infinite; }
        .animate-float-2 { animation: float-2 15s ease-in-out infinite; }
        .animate-float-3 { animation: float-3 10s ease-in-out infinite; }
        .animate-float-4 { animation: float-4 14s ease-in-out infinite; }
        .animate-float-5 { animation: float-5 13s ease-in-out infinite; }
        .animate-float-6 { animation: float-6 11s ease-in-out infinite; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes progress {
            from { width: 0%; }
            to { width: 75%; }
        }

        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in-right { animation: fadeInRight 0.8s ease-out forwards; }
        .animate-progress { animation: progress 1.5s ease-out forwards; }
        .animation-delay-200 { animation-delay: 200ms; opacity: 0; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #818cf8; }

        /* Ajustement pour les très petits écrans */
        @media (max-width: 480px) {
            .container {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
            }
            
            .py-8 {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }
            
            .text-sm {
                font-size: 0.65rem;
            }
            
            .text-xs {
                font-size: 0.55rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let deleteId = null;
        let deleteName = '';

        function confirmDelete(id, name) {
            deleteId = id;
            deleteName = name;
            document.getElementById('modal-message').textContent = 'Êtes-vous sûr de vouloir supprimer cette réinscription ?';
            document.getElementById('modal-eleve-name').textContent = 'Élève : ' + name;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteId = null;
            deleteName = '';
        }

        function executeDelete() {
            if (deleteId) {
                document.getElementById('delete-form-' + deleteId).submit();
            }
        }

        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
        document.getElementById('modal-overlay').addEventListener('click', closeDeleteModal);

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const msgEl = document.getElementById('toast-message');
            const inner = toast.querySelector('div');
            msgEl.textContent = message;
            inner.className = (type === 'success' ? 'bg-green-500' : 'bg-red-500') +
                ' text-white px-3 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 rounded-lg sm:rounded-xl shadow-2xl flex items-center space-x-2 sm:space-x-3';
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), 3000);
        }

    @if(session('success')) showToast("{{ session('success') }}", 'success'); @endif
        @if(session('error'))   showToast("{{ session('error') }}", 'error'); @endif
    </script>
@endpush