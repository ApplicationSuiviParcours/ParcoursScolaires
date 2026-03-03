@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Bulletins de ') . $eleve->prenom . ' ' . $eleve->nom }}
    </h2>
@endsection

@section('content')
@php
    // Valeurs par défaut
    $bulletins = $bulletins ?? collect([]);
    $periodes = $periodes ?? collect([]);
    $anneesScolaires = $anneesScolaires ?? collect([]);
    $stats = $stats ?? [
        'total' => 0,
        'moyenne_globale' => 0,
        'dernier' => null
    ];
    
    // Couleurs pour les mentions
    $mentionColors = [
        'Très bien' => 'from-green-500 to-emerald-600',
        'Bien' => 'from-blue-500 to-cyan-600',
        'Assez bien' => 'from-yellow-500 to-amber-600',
        'Passable' => 'from-orange-500 to-amber-600',
        'Insuffisant' => 'from-red-500 to-rose-600'
    ];
@endphp

<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header avec design moderne -->
        <div class="relative mb-8 overflow-hidden group rounded-3xl">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-700 animate-gradient-xy"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute rounded-full bg-white/30 w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute rounded-full bg-yellow-300/30 w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules animées -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 15; $i++)
                <div class="absolute w-1 h-1 rounded-full bg-white/60 animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar élève avec effet 3D -->
                        <div class="relative group perspective">
                            <div class="relative transition-all duration-500 transform group-hover:rotate-y-180 preserve-3d">
                                <div class="flex items-center justify-center w-24 h-24 transition-all duration-300 border-4 shadow-2xl bg-white/20 backdrop-blur-xl rounded-2xl border-white/50 group-hover:scale-110 group-hover:shadow-purple-500/50">
                                    <span class="text-4xl font-bold text-white drop-shadow-lg">
                                        {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="absolute w-5 h-5 bg-green-400 border-4 border-white rounded-full -bottom-1 -right-1 animate-pulse ring-2 ring-purple-500/50"></div>
                            @if($stats['total'] > 0)
                            <div class="absolute -top-2 -right-2 px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full shadow-lg animate-bounce-subtle">
                                {{ $stats['total'] }} bulletin(s)
                            </div>
                            @endif
                        </div>
                        
                        <div class="transition-all duration-700 transform animate-slide-in-left">
                            <h3 class="text-4xl font-black tracking-tight text-white drop-shadow-xl">Bulletins de {{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-3">
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $eleve->classe->nom ?? 'Classe non assignée' }}
                                </span>
                                @if(isset($lienParental))
                                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all border rounded-full bg-white/20 backdrop-blur-sm border-white/30 hover:bg-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    {{ $lienParental }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="items-center hidden mt-6 space-x-4 lg:flex lg:mt-0">
                        <div class="text-right">
                            <p class="text-sm text-purple-200">Moyenne générale</p>
                            <p class="text-3xl font-bold text-white">{{ number_format($stats['moyenne_globale'], 2) }}/20</p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 border bg-white/20 backdrop-blur-sm rounded-2xl border-white/30 animate-float">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation et actions -->
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <a href="{{ route('parent.enfants') }}" class="group inline-flex items-center px-5 py-2.5 text-gray-700 bg-white/80 backdrop-blur-sm hover:bg-white rounded-xl transition-all duration-300 shadow-md hover:shadow-xl border border-gray-200/50">
                <svg class="w-5 h-5 mr-2 text-purple-600 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span class="font-medium">Retour à mes enfants</span>
            </a>

            @if($bulletins->count() > 0)
            <div class="flex items-center px-4 py-2 space-x-2 text-sm text-gray-600 border bg-white/80 backdrop-blur-sm rounded-xl border-gray-200/50">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ $bulletins->total() }} bulletin(s) trouvé(s)</span>
            </div>
            @endif
        </div>

        <!-- Filtres avec design moderne -->
        <div class="mb-8 overflow-hidden transition-all duration-500 border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl animate-fade-in-up">
            <div class="p-6 border-b border-gray-100/50 bg-gradient-to-r from-purple-50/80 to-indigo-50/80">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-lg font-semibold text-gray-900">
                        <svg class="w-5 h-5 mr-2 text-purple-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filtrer les bulletins
                    </h3>
                    <span class="px-3 py-1 text-xs text-gray-500 rounded-full bg-white/50">Recherche avancée</span>
                </div>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('parent.enfant.bulletin', $eleve->id) }}" class="grid grid-cols-1 gap-4 md:grid-cols-4">
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Période
                        </label>
                        <select name="periode" class="w-full transition-all border-gray-200 rounded-xl focus:border-purple-500 focus:ring-purple-500 hover:border-purple-300">
                            <option value="">Toutes les périodes</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode }}" {{ request('periode') == $periode ? 'selected' : '' }}>
                                    {{ $periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="flex items-center text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Année scolaire
                        </label>
                        <select name="annee_scolaire_id" class="w-full transition-all border-gray-200 rounded-xl focus:border-purple-500 focus:ring-purple-500 hover:border-purple-300">
                            <option value="">Toutes les années</option>
                            @foreach($anneesScolaires as $annee)
                                <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end space-x-3 md:col-span-2">
                        <a href="{{ route('parent.enfant.bulletin', $eleve->id) }}" 
                           class="flex-1 px-6 py-3 font-medium text-center text-gray-600 transition-all border bg-gray-100/80 backdrop-blur-sm rounded-xl hover:bg-gray-200 hover:shadow-md border-gray-200/50 group">
                            <svg class="w-5 h-5 mx-auto transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </a>
                        <button type="submit" class="flex-1 px-6 py-3 font-semibold text-white transition-all bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl hover:from-purple-600 hover:to-indigo-700 hover:shadow-lg hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stats Cards avec design moderne -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            <!-- Total bulletins -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-purple-500/10 to-indigo-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-600">
                            <span class="w-2 h-2 mr-2 bg-purple-500 rounded-full animate-pulse"></span>
                            Total bulletins
                        </p>
                        <p class="mt-2 text-5xl font-black text-gray-900 transition-colors group-hover:text-purple-600">{{ $stats['total'] }}</p>
                        <p class="mt-1 text-xs text-gray-400">depuis la rentrée</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="absolute bottom-0 left-0 w-full h-1 transition-transform origin-left transform scale-x-0 bg-gradient-to-r from-purple-500 to-indigo-600 group-hover:scale-x-100"></div>
            </div>

            <!-- Moyenne globale -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-green-500/10 to-emerald-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-600">
                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse animation-delay-200"></span>
                            Moyenne globale
                        </p>
                        <p class="mt-2 text-5xl font-black {{ $stats['moyenne_globale'] >= 10 ? 'text-green-600' : 'text-red-600' }} group-hover:scale-110 transition-transform origin-left">
                            {{ number_format($stats['moyenne_globale'], 2) }}
                        </p>
                        <p class="mt-1 text-xs text-gray-400">sur 20</p>
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Dernier bulletin -->
            <div class="relative p-6 overflow-hidden transition-all duration-500 border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity opacity-0 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 group-hover:opacity-100"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="flex items-center text-sm font-medium text-gray-600">
                            <span class="w-2 h-2 mr-2 bg-blue-500 rounded-full animate-pulse animation-delay-400"></span>
                            Dernier bulletin
                        </p>
                        <p class="mt-2 text-2xl font-bold text-gray-900 transition-colors group-hover:text-blue-600">
                            {{ $stats['dernier']->periode ?? 'N/A' }}
                        </p>
                        @if($stats['dernier'])
                        <p class="mt-1 text-xs text-gray-400">
                            {{ $stats['dernier']->created_at ? $stats['dernier']->created_at->format('d/m/Y') : '' }}
                        </p>
                        @endif
                    </div>
                    <div class="p-4 transition-transform shadow-lg bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille des bulletins -->
        @if($bulletins->count() > 0)
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($bulletins as $index => $bulletin)
                @php
                    $moyenne = $bulletin->moyenne_generale ?? 0;
                    $mention = $moyenne >= 16 ? 'Très bien' : 
                              ($moyenne >= 14 ? 'Bien' : 
                              ($moyenne >= 12 ? 'Assez bien' : 
                              ($moyenne >= 10 ? 'Passable' : 'Insuffisant')));
                    $mentionGradient = $mentionColors[$mention] ?? 'from-gray-500 to-gray-600';
                    $mentionClass = $moyenne >= 16 ? 'bg-green-100 text-green-800 border-green-200' : 
                                   ($moyenne >= 14 ? 'bg-blue-100 text-blue-800 border-blue-200' : 
                                   ($moyenne >= 12 ? 'bg-yellow-100 text-yellow-800 border-yellow-200' : 
                                   ($moyenne >= 10 ? 'bg-orange-100 text-orange-800 border-orange-200' : 
                                   'bg-red-100 text-red-800 border-red-200')));
                    
                    $dateCreation = $bulletin->created_at ? $bulletin->created_at->format('d/m/Y') : 'Date inconnue';
                    $animationDelay = $index * 100;
                @endphp
                
                <div class="overflow-hidden transition-all duration-500 transform border shadow-xl group bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl hover:shadow-2xl hover:-translate-y-2 animate-fade-in-up" style="animation-delay: {{ $animationDelay }}ms">
                    <!-- Barre de couleur supérieure -->
                    <div class="h-2 bg-gradient-to-r {{ $mentionGradient }}"></div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 transition-colors group-hover:text-purple-600">{{ $bulletin->periode }}</h4>
                                <p class="flex items-center mt-1 text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $bulletin->anneeScolaire->nom ?? 'Année scolaire' }}
                                </p>
                                @if($bulletin->trimestre)
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs bg-purple-100 text-purple-700 rounded-full">
                                    Trimestre {{ $bulletin->trimestre }}
                                </span>
                                @endif
                            </div>
                            <div class="p-3 transition-transform bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl group-hover:scale-110">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Moyenne avec jauge circulaire -->
                        <div class="flex items-center justify-between p-4 mb-4 bg-gray-50/80 rounded-xl">
                            <span class="text-sm font-medium text-gray-600">Moyenne</span>
                            <div class="flex items-center">
                                <div class="relative w-16 h-16 mr-3">
                                    <svg class="w-16 h-16 transform -rotate-90">
                                        <circle cx="32" cy="32" r="28" fill="none" stroke="#e5e7eb" stroke-width="4"/>
                                        <circle cx="32" cy="32" r="28" fill="none" 
                                            stroke="{{ $moyenne >= 10 ? '#10b981' : '#ef4444' }}" 
                                            stroke-width="4"
                                            stroke-dasharray="175.9"
                                            stroke-dashoffset="{{ 175.9 * (1 - min($moyenne/20, 1)) }}"
                                            stroke-linecap="round"
                                            class="transition-all duration-1000"/>
                                    </svg>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <span class="text-xs font-bold">{{ number_format(($moyenne/20)*100, 0) }}%</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-3xl font-black {{ $moyenne >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($moyenne, 2) }}
                                    </span>
                                    <span class="text-sm text-gray-400">/20</span>
                                </div>
                            </div>
                        </div>

                        <!-- Mention -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-600">Mention</span>
                            <span class="px-3 py-1.5 text-xs font-bold rounded-full {{ $mentionClass }} border">
                                {{ $mention }}
                            </span>
                        </div>

                        <!-- Appréciation -->
                        @if($bulletin->appreciation)
                        <div class="relative p-4 mb-4 border border-yellow-100 bg-gradient-to-r from-yellow-50 to-amber-50 rounded-xl">
                            <svg class="absolute w-8 h-8 top-2 right-2 text-yellow-200/50" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
                            </svg>
                            <p class="relative z-10 text-sm italic text-gray-600">"{{ Str::limit($bulletin->appreciation, 80) }}"</p>
                        </div>
                        @endif

                        <!-- Footer avec date et bouton -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="flex items-center text-xs text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $dateCreation }}
                            </span>
                            <a href="{{ route('parent.enfant.bulletin.detail', ['eleve' => $eleve->id, 'bulletin' => $bulletin->id]) }}" 
                               class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-indigo-600 rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all shadow-md hover:shadow-lg group/btn">
                                <span>Détails</span>
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <!-- État vide amélioré -->
        <div class="relative p-16 overflow-hidden text-center border shadow-xl bg-white/90 backdrop-blur-xl border-white/50 rounded-2xl">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute w-64 h-64 bg-purple-300 rounded-full -top-32 -right-32 blur-3xl"></div>
                <div class="absolute w-64 h-64 bg-indigo-300 rounded-full -bottom-32 -left-32 blur-3xl"></div>
            </div>

            <div class="relative">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-purple-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative text-purple-400 w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="mt-6 text-2xl font-semibold text-gray-700">Aucun bulletin disponible</h3>
                <p class="max-w-md mx-auto mt-2 text-gray-500">
                    Les bulletins apparaîtront ici une fois publiés par l'administration.
                </p>
                <div class="inline-flex items-center px-5 py-3 mt-8 text-purple-700 bg-purple-50 rounded-xl">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">Les bulletins sont généralement publiés en fin de trimestre</span>
                </div>
            </div>
        </div>
        @endif

        <!-- Pagination stylisée -->
        @if(method_exists($bulletins, 'links') && $bulletins->hasPages())
        <div class="mt-8">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Affichage de <span class="font-semibold">{{ $bulletins->firstItem() ?? 0 }}</span> 
                    à <span class="font-semibold">{{ $bulletins->lastItem() ?? 0 }}</span> 
                    sur <span class="font-semibold">{{ $bulletins->total() }}</span> bulletins
                </p>
                {{ $bulletins->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
@keyframes gradient-xy {
    0%, 100% { background-position: 0% 50%; }
    25% { background-position: 50% 100%; }
    50% { background-position: 100% 50%; }
    75% { background-position: 50% 0%; }
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
@keyframes float-random {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(10px, -10px); }
    50% { transform: translate(-10px, 5px); }
    75% { transform: translate(5px, 10px); }
}
@keyframes slide-in-left {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes slide-in-right {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes pulse-slow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}
@keyframes bounce-subtle {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

.animate-gradient-xy {
    background-size: 300% 300%;
    animation: gradient-xy 15s ease infinite;
}
.animate-float {
    animation: float 3s ease-in-out infinite;
}
.animate-float-random {
    animation: float-random 10s ease-in-out infinite;
}
.animate-slide-in-left {
    animation: slide-in-left 0.7s ease-out forwards;
}
.animate-slide-in-right {
    animation: slide-in-right 0.7s ease-out forwards;
}
.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
}
.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}
.animate-bounce-subtle {
    animation: bounce-subtle 2s ease-in-out infinite;
}
.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}
@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.animation-delay-200 {
    animation-delay: 200ms;
}
.animation-delay-400 {
    animation-delay: 400ms;
}
.animation-delay-600 {
    animation-delay: 600ms;
}
.animation-delay-2000 {
    animation-delay: 2000ms;
}

.hover\:-translate-y-2:hover {
    transform: translateY(-0.5rem);
}
.hover\:scale-110:hover {
    transform: scale(1.10);
}
.preserve-3d {
    transform-style: preserve-3d;
}
.hover\:rotate-y-180:hover {
    transform: rotateY(180deg);
}
.perspective {
    perspective: 1000px;
}

/* Personnalisation de la pagination */
.pagination {
    display: flex;
    gap: 0.5rem;
}
.pagination .page-link {
    padding: 0.5rem 1rem;
    border-radius: 0.75rem;
    background: white;
    color: #374151;
    font-weight: 500;
    transition: all 0.3s;
    border: 1px solid #e5e7eb;
}
.pagination .page-link:hover {
    background: #8b5cf6;
    color: white;
    border-color: #8b5cf6;
    transform: scale(1.05);
}
.pagination .active .page-link {
    background: #8b5cf6;
    color: white;
    border-color: #8b5cf6;
}

@media print {
    .no-print {
        display: none;
    }
    body {
        background: white;
    }
    .bg-gradient-to-r {
        background: #f3f4f6 !important;
        color: black !important;
    }
    .text-white {
        color: black !important;
    }
}
</style>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des nombres dans les stats
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.innerText);
        if (!isNaN(target) && target > 0) {
            let count = 0;
            const updateCounter = () => {
                if (count < target) {
                    count++;
                    counter.innerText = count;
                    setTimeout(updateCounter, 10);
                }
            };
            updateCounter();
        }
    });

    // Animation au scroll
    const cards = document.querySelectorAll('.group');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => observer.observe(card));
});
</script>
@endsection