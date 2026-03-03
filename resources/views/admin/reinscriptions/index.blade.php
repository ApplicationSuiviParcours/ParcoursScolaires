@extends('layouts.app')

@section('title', 'Gestion des réinscriptions')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 py-16">
    <!-- Éléments d'arrière-plan animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 6; $i++)
            <div class="absolute w-2 h-2 bg-white rounded-full opacity-20 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 animate-fade-in-up">
                    Gestion des réinscriptions
                </h1>
                <p class="text-indigo-200 text-lg md:text-xl max-w-2xl mx-auto md:mx-0 animate-fade-in-up animation-delay-200">
                    Gérez efficacement les réinscriptions des élèves avec une interface moderne et intuitive
                </p>
            </div>
            <div class="mt-8 md:mt-0 flex justify-center md:justify-end animate-fade-in-right">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-4 border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-white font-medium">{{ now()->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-12 bg-gray-50">
    <!-- Cartes de statistiques animées -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Carte 1 -->
        <div class="group cursor-pointer" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-400 group-hover:text-white/70 transition-colors duration-300">Total</span>
                    </div>
                    <div class="flex items-baseline justify-between">
                        <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300">{{ $reinscriptions->total() }}</h3>
                        <span class="text-sm font-medium text-green-500 group-hover:text-white/70 transition-colors duration-300">+12%</span>
                    </div>
                    <div class="mt-4 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-progress" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 2 -->
        <div class="group cursor-pointer" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-6 h-6 text-green-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-2">{{ $reinscriptions->where('statut', 'confirmee')->count() }}</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/70 transition-colors duration-300">Confirmées</p>
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 to-emerald-500 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
                </div>
            </div>
        </div>

        <!-- Carte 3 -->
        <div class="group cursor-pointer" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500 to-amber-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-6 h-6 text-yellow-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-2">{{ $reinscriptions->where('statut', 'en_attente')->count() }}</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/70 transition-colors duration-300">En attente</p>
                    <div class="mt-4 flex space-x-1">
                        @for($i = 0; $i < 3; $i++)
                            <div class="h-1 w-full bg-yellow-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-500 animate-pulse" style="width: {{ rand(60, 90) }}%"></div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 4 -->
        <div class="group cursor-pointer" x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
            <div class="relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-red-500 to-rose-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:scale-110 group-hover:bg-white/20 transition-all duration-300">
                            <svg class="w-6 h-6 text-red-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 group-hover:text-white transition-colors duration-300 mb-2">{{ $reinscriptions->where('statut', 'annulee')->count() }}</h3>
                    <p class="text-sm text-gray-500 group-hover:text-white/70 transition-colors duration-300">Annulées</p>
                    <div class="absolute top-2 right-2 w-16 h-16">
                        <svg class="w-full h-full text-red-200 group-hover:text-white/20 transition-colors duration-300" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des filtres avec animation -->
    <div class="bg-white rounded-3xl shadow-xl mb-10 overflow-hidden transform transition-all duration-500 hover:shadow-2xl" x-data="{ open: true }">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-5 border-b border-gray-200 flex items-center justify-between cursor-pointer" @click="open = !open">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">Filtres avancés</h2>
                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">3 actifs</span>
            </div>
            <svg class="w-6 h-6 text-gray-500 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>
        
        <div x-show="open" x-transition:enter="transition-all duration-500 ease-out" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition-all duration-300 ease-in" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-4" class="p-8">
            <form method="GET" action="{{ route('admin.reinscriptions.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Recherche -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 group-hover:text-indigo-600 transition-colors duration-300">Recherche</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Nom, prénom, matricule..."
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 group-hover:border-indigo-300">
                        </div>
                    </div>

                    <!-- Année scolaire -->
                    <div class="group">
                        <label class="block text-sm font-medium text-gray-700 mb-2 group-hover:text-indigo-600 transition-colors duration-300">Année scolaire</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <select name="annee_scolaire_id" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2 group-hover:text-indigo-600 transition-colors duration-300">Classe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                            </div>
                            <select name="classe_id" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white">
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
                        <label class="block text-sm font-medium text-gray-700 mb-2 group-hover:text-indigo-600 transition-colors duration-300">Statut</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <select name="statut" 
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 group-hover:border-indigo-300 appearance-none bg-white">
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
                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.reinscriptions.index') }}" 
                       class="group flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 text-gray-500 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Réinitialiser
                    </a>
                    <button type="submit" 
                            class="group flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 animate-none group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Appliquer les filtres
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bouton d'ajout flottant -->
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('admin.reinscriptions.create') }}" 
           class="group relative flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-500 transform hover:scale-110 hover:rotate-90"
           x-data="{ tooltip: false }"
           @mouseenter="tooltip = true"
           @mouseleave="tooltip = false">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            
            <!-- Tooltip -->
            <div x-show="tooltip" 
                 x-transition:enter="transition-all duration-300 ease-out"
                 x-transition:enter-start="opacity-0 transform -translate-x-2"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 x-transition:leave="transition-all duration-200 ease-in"
                 x-transition:leave-start="opacity-100 transform translate-x-0"
                 x-transition:leave-end="opacity-0 transform -translate-x-2"
                 class="absolute right-full mr-4 whitespace-nowrap bg-gray-900 text-white px-4 py-2 rounded-xl text-sm font-medium">
                Nouvelle réinscription
                <div class="absolute top-1/2 right-0 transform translate-x-1/2 -translate-y-1/2 rotate-45 w-2 h-2 bg-gray-900"></div>
            </div>
        </a>
    </div>

    <!-- Tableau des réinscriptions -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden transform transition-all duration-500 hover:shadow-2xl">
        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">Liste des réinscriptions</h2>
                    <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium rounded-full">{{ $reinscriptions->total() }} inscriptions</span>
                </div>
                
                <!-- Options d'affichage -->
                <div class="flex items-center space-x-2">
                    <button class="p-2 hover:bg-white rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button class="p-2 hover:bg-white rounded-lg transition-colors duration-300">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Élève</th>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Classe</th>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Année</th>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-8 py-5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($reinscriptions as $index => $reinscription)
                        <tr class="group hover:bg-indigo-50 transition-all duration-300 transform hover:scale-[1.01] hover:shadow-lg cursor-pointer"
                            x-data="{ show: false }"
                            x-init="setTimeout(() => show = true, {{ $index * 50 }})"
                            x-show="show"
                            x-transition:enter="transition-all duration-500 ease-out"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            @click="window.location.href = '{{ route('admin.reinscriptions.show', $reinscription) }}'">
                            
                            <!-- Colonne Élève -->
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div class="relative">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            {{ strtoupper(substr($reinscription->eleve->prenom ?? '?', 0, 1)) }}{{ strtoupper(substr($reinscription->eleve->nom ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-white rounded-full group-hover:animate-ping"></div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">
                                            {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}
                                        </div>
                                        @if($reinscription->eleve && $reinscription->eleve->matricule)
                                            <div class="text-xs text-gray-500 flex items-center mt-1">
                                                <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                </svg>
                                                {{ $reinscription->eleve->matricule }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Colonne Classe -->
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900">{{ $reinscription->classe->nom ?? '' }}</span>
                                </div>
                            </td>

                            <!-- Colonne Année -->
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-xl group-hover:scale-105 transition-transform duration-300">
                                    {{ $reinscription->anneeScolaire->nom ?? '' }}
                                </span>
                            </td>

                            <!-- Colonne Date -->
                            <td class="px-8 py-5">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-2 group-hover:text-indigo-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-600">{{ $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : '' }}</span>
                                </div>
                            </td>

                            <!-- Colonne Statut -->
                            <td class="px-8 py-5">
                                @php
                                    $statutStyles = [
                                        'confirmee' => ['bg-green-100', 'text-green-700', 'ring-green-500/30', 'CheckCircleIcon'],
                                        'en_attente' => ['bg-yellow-100', 'text-yellow-700', 'ring-yellow-500/30', 'ClockIcon'],
                                        'annulee' => ['bg-red-100', 'text-red-700', 'ring-red-500/30', 'XCircleIcon'],
                                    ];
                                    $style = $statutStyles[$reinscription->statut] ?? ['bg-gray-100', 'text-gray-700', 'ring-gray-500/30', ''];
                                @endphp
                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium {{ $style[0] }} {{ $style[1] }} ring-1 {{ $style[2] }} group-hover:scale-105 transition-transform duration-300">
                                    {{ $statuts[$reinscription->statut] ?? $reinscription->statut }}
                                </span>
                            </td>

                            <!-- Colonne Actions -->
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-3" @click.stop>
                                    <!-- Voir -->
                                    <a href="{{ route('admin.reinscriptions.show', $reinscription) }}" 
                                       class="p-2 bg-indigo-100 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition-all duration-300 transform hover:scale-110 hover:rotate-3"
                                       title="Voir détails">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>

                                    <!-- Modifier -->
                                    <a href="{{ route('admin.reinscriptions.edit', $reinscription) }}" 
                                       class="p-2 bg-yellow-100 text-yellow-600 rounded-xl hover:bg-yellow-600 hover:text-white transition-all duration-300 transform hover:scale-110 hover:-rotate-3"
                                       title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Supprimer -->
                                    <button onclick="confirmDelete({{ $reinscription->id }}, '{{ $reinscription->eleve->nom }} {{ $reinscription->eleve->prenom }}')"
                                            class="p-2 bg-red-100 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300 transform hover:scale-110 hover:rotate-3"
                                            title="Supprimer">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    <form id="delete-form-{{ $reinscription->id }}" 
                                          action="{{ route('admin.reinscriptions.destroy', $reinscription) }}" 
                                          method="POST" 
                                          class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16">
                                <div class="flex flex-col items-center justify-center text-center">
                                    <div class="relative">
                                        <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                        </div>
                                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-500 rounded-full animate-ping"></div>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Aucune réinscription trouvée</h3>
                                    <p class="text-gray-500 max-w-md mb-8">
                                        @if(request()->anyFilled(['search', 'annee_scolaire_id', 'classe_id', 'statut']))
                                            Aucun résultat ne correspond à vos critères. Essayez d'autres filtres.
                                        @else
                                            Commencez par créer une nouvelle réinscription.
                                        @endif
                                    </p>
                                    <a href="{{ route('admin.reinscriptions.create') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
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

        <!-- Pagination améliorée -->
        @if($reinscriptions->hasPages())
            <div class="bg-gray-50 px-8 py-5 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Affichage de <span class="font-medium">{{ $reinscriptions->firstItem() }}</span> à 
                        <span class="font-medium">{{ $reinscriptions->lastItem() }}</span> sur 
                        <span class="font-medium">{{ $reinscriptions->total() }}</span> résultats
                    </p>
                    <div class="flex items-center space-x-2">
                        {{ $reinscriptions->withQueryString()->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de suppression amélioré -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-data="{ show: false }">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>

        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
             x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="bg-white px-6 pt-6 pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-100 sm:mx-0 sm:h-12 sm:w-12 animate-pulse">
                        <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-xl leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                            Confirmer la suppression
                        </h3>
                        <div class="mt-2">
                            <p class="text-base text-gray-500" id="modal-message">
                                Êtes-vous sûr de vouloir supprimer cette réinscription ?
                            </p>
                            <p class="text-sm text-gray-400 mt-2" id="modal-eleve-name"></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse space-x-2 space-x-reverse">
                <button type="button" 
                        onclick="executeDelete()"
                        class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm transition-all duration-300 transform hover:scale-105">
                    Supprimer
                </button>
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-all duration-300 transform hover:scale-105">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast de notification (optionnel) -->
<div id="toast" class="fixed bottom-8 left-8 z-50 hidden">
    <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 transform transition-all duration-500 translate-y-0 opacity-100">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <span id="toast-message">Action effectuée avec succès</span>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations personnalisées */
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
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    @keyframes progress {
        from { width: 0%; }
        to { width: 75%; }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }
    
    .animate-progress {
        animation: progress 1.5s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 200ms;
        opacity: 0;
    }
    
    .animation-delay-400 {
        animation-delay: 400ms;
        opacity: 0;
    }
    
    /* Smooth scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #818cf8;
    }
    
    /* Glassmorphism effect */
    .glass {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }
    
    /* Gradient animations */
    .gradient-shift {
        background-size: 200% 200%;
        animation: gradientShift 5s ease infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    
    /* Card hover effect */
    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card-hover:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
    const modal = document.getElementById('deleteModal');
    const message = document.getElementById('modal-message');
    const eleveName = document.getElementById('modal-eleve-name');
    message.textContent = `Êtes-vous sûr de vouloir supprimer cette réinscription ?`;
    eleveName.textContent = `Élève: ${name}`;
    modal.classList.remove('hidden');
    
    // Animation d'entrée
    setTimeout(() => {
        document.querySelector('#deleteModal > div > div').classList.add('scale-100', 'opacity-100');
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    deleteId = null;
    deleteName = '';
}

function executeDelete() {
    if (deleteId) {
        document.getElementById(`delete-form-${deleteId}`).submit();
    }
}

// Fermer avec Echap
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});

// Fermer en cliquant à l'extérieur
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Animation au scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in-up');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.stat-card, .filter-section, table tr').forEach(el => {
    observer.observe(el);
});

// Toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    
    toastMessage.textContent = message;
    toast.classList.remove('hidden');
    
    // Couleur selon le type
    if (type === 'success') {
        toast.querySelector('div').className = 'bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 transform transition-all duration-500';
    } else if (type === 'error') {
        toast.querySelector('div').className = 'bg-red-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center space-x-3 transform transition-all duration-500';
    }
    
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Afficher un toast si session flash existe
@if(session('success'))
    showToast("{{ session('success') }}", 'success');
@endif

@if(session('error'))
    showToast("{{ session('error') }}", 'error');
@endif
</script>
@endpush