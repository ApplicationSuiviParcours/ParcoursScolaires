@extends('layouts.app')

@section('title', 'Détails de la réinscription')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 py-6 sm:py-8 md:py-10 lg:py-12 no-print overflow-x-hidden">
    <!-- Éléments décoratifs -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-48 sm:w-64 md:w-80 lg:w-96 h-48 sm:h-64 md:h-80 lg:h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-48 sm:w-64 md:w-80 lg:w-96 h-48 sm:h-64 md:h-80 lg:h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-3 sm:px-4 md:px-5 lg:px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 sm:gap-4 md:gap-5">
            <div class="text-center md:text-left">
                <!-- Fil d'Ariane -->
                <nav class="flex justify-center md:justify-start mb-2 sm:mb-3 md:mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 lg:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.reinscriptions.index') }}"
                               class="inline-flex items-center text-[10px] sm:text-xs md:text-sm font-medium text-indigo-200 hover:text-white transition-colors duration-300">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 mr-1 md:mr-1.5 lg:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Réinscriptions
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 text-indigo-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-[10px] sm:text-xs md:text-sm font-medium text-white">Détails</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2 animate-fade-in-up">
                    Détails de la réinscription
                </h1>
                <p class="text-indigo-200 text-xs sm:text-sm md:text-base lg:text-lg animate-fade-in-up animation-delay-200">
                    Consultation complète des informations de réinscription
                </p>
            </div>
            <!-- Boutons : côte à côte sur mobile aussi, wrappent si besoin -->
            <div class="flex flex-wrap justify-center md:justify-end gap-1.5 sm:gap-2 md:gap-3 animate-fade-in-right no-print">
                <a href="{{ route('admin.reinscriptions.edit', $reinscription) }}"
                   class="group relative inline-flex items-center px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5
                          bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700
                          text-white font-medium rounded-lg sm:rounded-xl transition-all duration-300
                          transform hover:scale-105 hover:shadow-xl overflow-hidden text-[10px] sm:text-xs md:text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1 sm:mr-1.5 md:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.reinscriptions.index') }}"
                   class="group relative inline-flex items-center px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5
                          bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium
                          rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105
                          border border-white/20 text-[10px] sm:text-xs md:text-sm">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1 sm:mr-1.5 md:mr-2 flex-shrink-0 transform group-hover:-translate-x-1 transition-transform duration-300"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"/>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-5 sm:py-6 md:py-8 lg:py-10 bg-gray-50 overflow-x-hidden" id="printable-content">

    {{-- En-tête imprimable --}}
    <div class="hidden print:block mb-6 md:mb-8 text-center">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-800">FICHE DE RÉINSCRIPTION</h1>
        <p class="text-gray-600 text-xs sm:text-sm">Document officiel - Établissement scolaire</p>
        <p class="text-gray-500 text-[10px] sm:text-xs mt-1 sm:mt-2">Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    {{-- Badge de statut flottant (masqué à l'impression) --}}
    <div class="relative mb-6 sm:mb-8 md:mb-10 lg:mb-12 no-print">
        <div class="absolute -top-6 sm:-top-8 md:-top-10 lg:-top-12 right-0">
            <div class="bg-white rounded-full shadow-xl px-3 sm:px-4 md:px-5 lg:px-6 py-1.5 sm:py-2 md:py-2.5 lg:py-3 flex items-center space-x-1.5 sm:space-x-2 md:space-x-3">
                <span class="text-[9px] sm:text-[10px] md:text-xs font-medium text-gray-600 whitespace-nowrap">Statut actuel :</span>
                {!! $reinscription->statut_badge !!}
            </div>
        </div>
    </div>

    {{-- ── CARTES D'INFORMATION ─────────────────────────────────────────
         xs/sm  → 1 colonne (empilées)
         md/lg  → 3 colonnes
    ──────────────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6 lg:gap-8 mb-5 sm:mb-6 md:mb-8">

        {{-- ── CARTE ÉLÈVE ── --}}
        <div class="group relative bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            {{-- Version imprimable --}}
            <div class="hidden print:block p-4 sm:p-5 md:p-6">
                <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4 border-b-2 border-gray-300 pb-2">INFORMATIONS DE L'ÉLÈVE</h2>
                <div class="space-y-2 md:space-y-3 text-xs sm:text-sm">
                    <p><span class="font-semibold">Nom complet :</span> {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}</p>
                    @if($reinscription->eleve && $reinscription->eleve->matricule)
                        <p><span class="font-semibold">Matricule :</span> {{ $reinscription->eleve->matricule }}</p>
                    @endif
                    @if($reinscription->eleve && $reinscription->eleve->date_naissance)
                        <p><span class="font-semibold">Date de naissance :</span> {{ $reinscription->eleve->date_naissance->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>

            {{-- Version écran --}}
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-20 sm:w-24 md:w-28 lg:w-32 h-20 sm:h-24 md:h-28 lg:h-32 bg-blue-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>

                <div class="relative p-4 sm:p-5 md:p-6 lg:p-8">
                    <div class="flex items-center justify-between mb-3 sm:mb-4 md:mb-5 lg:mb-6">
                        <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                            <div class="relative flex-shrink-0">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 lg:w-5 lg:h-5 bg-green-400 border-2 sm:border-4 border-white rounded-full group-hover:animate-ping"></div>
                            </div>
                            <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">Élève</h2>
                        </div>
                        <span class="px-2 py-1 sm:px-3 sm:py-1.5 md:px-4 md:py-2 bg-blue-100 text-blue-600 text-[9px] sm:text-[10px] md:text-xs font-medium rounded-lg sm:rounded-xl group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                            Principal
                        </span>
                    </div>

                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg sm:rounded-xl md:rounded-2xl group-hover:shadow-lg transition-all duration-300">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-white rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] sm:text-[10px] text-gray-500 mb-0.5">Nom complet</p>
                                <p class="text-xs sm:text-sm md:text-base lg:text-lg font-bold text-gray-800 truncate">
                                    {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}
                                </p>
                            </div>
                        </div>

                        @if($reinscription->eleve && $reinscription->eleve->matricule)
                        <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-colors duration-300">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-white rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] sm:text-[10px] text-gray-500 mb-0.5">Matricule</p>
                                <p class="text-xs sm:text-sm md:text-base font-bold text-gray-800">{{ $reinscription->eleve->matricule }}</p>
                            </div>
                        </div>
                        @endif

                        @if($reinscription->eleve && $reinscription->eleve->date_naissance)
                        <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-colors duration-300">
                            <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-white rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                                <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-[9px] sm:text-[10px] text-gray-500 mb-0.5">Date de naissance</p>
                                <p class="text-xs sm:text-sm md:text-base font-bold text-gray-800">{{ $reinscription->eleve->date_naissance->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Progression -->
                    <div class="mt-4 sm:mt-5 md:mt-6 pt-3 sm:pt-4 md:pt-5 lg:pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-1 sm:mb-2">
                            <span class="text-[9px] sm:text-[10px] md:text-xs text-gray-600">Progression scolaire</span>
                            <span class="text-[9px] sm:text-[10px] md:text-xs font-medium text-blue-600">75%</span>
                        </div>
                        <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-progress" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARTE CLASSE & ANNÉE ── --}}
        <div class="group relative bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            {{-- Version imprimable --}}
            <div class="hidden print:block p-4 sm:p-5 md:p-6">
                <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4 border-b-2 border-gray-300 pb-2">CLASSE ET ANNÉE SCOLAIRE</h2>
                <div class="space-y-2 md:space-y-3 text-xs sm:text-sm">
                    <p><span class="font-semibold">Classe :</span> {{ $reinscription->classe->nom ?? '' }}</p>
                    <p><span class="font-semibold">Année scolaire :</span> {{ $reinscription->anneeScolaire->nom ?? '' }}</p>
                    @if($reinscription->anneeScolaire && $reinscription->anneeScolaire->date_debut)
                        <p><span class="font-semibold">Période :</span> du {{ $reinscription->anneeScolaire->date_debut->format('d/m/Y') }} au {{ $reinscription->anneeScolaire->date_fin->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>

            {{-- Version écran --}}
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-20 sm:w-24 md:w-28 lg:w-32 h-20 sm:h-24 md:h-28 lg:h-32 bg-green-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>

                <div class="relative p-4 sm:p-5 md:p-6 lg:p-8">
                    <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4 mb-3 sm:mb-4 md:mb-5 lg:mb-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">Classe & Année</h2>
                    </div>

                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div class="relative p-3 sm:p-4 md:p-5 lg:p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg sm:rounded-xl md:rounded-2xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-12 sm:w-14 md:w-16 lg:w-20 h-12 sm:h-14 md:h-16 lg:h-20 bg-green-200 rounded-full filter blur-2xl opacity-50"></div>
                            <div class="relative z-10">
                                <p class="text-[9px] sm:text-[10px] md:text-xs text-gray-500 mb-1">Classe actuelle</p>
                                <p class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-gray-800 mb-1">{{ $reinscription->classe->nom ?? '' }}</p>
                                <div class="flex items-center text-[9px] sm:text-[10px] md:text-xs text-gray-600">
                                    <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 md:w-3.5 md:h-3.5 mr-1 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>{{ $reinscription->classe->effectif ?? 'N/A' }} élèves</span>
                                </div>
                            </div>
                        </div>

                        {{-- Grille 2 colonnes --}}
                        <div class="grid grid-cols-2 gap-2 sm:gap-3 md:gap-4">
                            <div class="p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-colors duration-300">
                                <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-500 mb-0.5">Année scolaire</p>
                                <p class="font-bold text-gray-800 text-[10px] sm:text-xs md:text-sm">{{ $reinscription->anneeScolaire->nom ?? '' }}</p>
                            </div>
                            @if($reinscription->anneeScolaire && $reinscription->anneeScolaire->date_debut)
                            <div class="p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-colors duration-300">
                                <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-500 mb-0.5">Période</p>
                                <p class="font-bold text-gray-800 text-[9px] sm:text-[10px] md:text-xs leading-tight">
                                    {{ $reinscription->anneeScolaire->date_debut->format('d/m/Y') }}<br>
                                    <span class="text-[7px] sm:text-[8px] text-gray-500 font-normal">au</span><br>
                                    {{ $reinscription->anneeScolaire->date_fin->format('d/m/Y') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Taux de réussite -->
                    <div class="mt-4 sm:mt-5 md:mt-6 pt-3 sm:pt-4 md:pt-5 lg:pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-1 sm:mb-2">
                            <span class="text-[9px] sm:text-[10px] md:text-xs text-gray-600">Taux de réussite</span>
                            <span class="text-[9px] sm:text-[10px] md:text-xs font-medium text-green-600">92%</span>
                        </div>
                        <div class="mt-1 sm:mt-2 flex space-x-0.5 sm:space-x-1">
                            @for($i = 0; $i < 5; $i++)
                                <div class="h-1.5 flex-1 bg-green-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $i < 4 ? 100 : 60 }}%"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── CARTE STATUT & DATE ── --}}
        <div class="group relative bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            {{-- Version imprimable --}}
            <div class="hidden print:block p-4 sm:p-5 md:p-6">
                <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4 border-b-2 border-gray-300 pb-2">STATUT ET DATES</h2>
                <div class="space-y-2 md:space-y-3 text-xs sm:text-sm">
                    <p>
                        <span class="font-semibold">Statut :</span>
                        @switch($reinscription->statut)
                            @case('confirmee') Confirmé @break
                            @case('en_attente') En attente @break
                            @case('annulee') Annulé @break
                            @default {{ $reinscription->statut }}
                        @endswitch
                    </p>
                    <p><span class="font-semibold">Date de réinscription :</span> {{ $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : '' }}</p>
                    <p><span class="font-semibold">Date de création :</span> {{ $reinscription->created_at ? $reinscription->created_at->format('d/m/Y H:i') : '' }}</p>
                    <p><span class="font-semibold">Dernière mise à jour :</span> {{ $reinscription->updated_at ? $reinscription->updated_at->format('d/m/Y H:i') : '' }}</p>
                </div>
            </div>

            {{-- Version écran --}}
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-20 sm:w-24 md:w-28 lg:w-32 h-20 sm:h-24 md:h-28 lg:h-32 bg-purple-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>

                <div class="relative p-4 sm:p-5 md:p-6 lg:p-8">
                    <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4 mb-3 sm:mb-4 md:mb-5 lg:mb-6">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">Statut & Date</h2>
                    </div>

                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <!-- Statut -->
                        <div class="relative p-3 sm:p-4 md:p-5 lg:p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg sm:rounded-xl md:rounded-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-white/50 backdrop-blur-sm"></div>
                            <div class="relative z-10 text-center">
                                <p class="text-[9px] sm:text-[10px] md:text-xs text-gray-500 mb-1 sm:mb-2">Statut actuel</p>
                                <div class="transform group-hover:scale-110 transition-transform duration-500">
                                    {!! $reinscription->statut_badge !!}
                                </div>
                            </div>
                        </div>

                        <!-- Timeline dates -->
                        <div class="space-y-1.5 sm:space-y-2 md:space-y-3">
                            @foreach([
                                ['bg-purple-100','text-purple-600','M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z','Date de réinscription', $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : ''],
                                ['bg-blue-100','text-blue-600','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z','Date de création', $reinscription->created_at ? $reinscription->created_at->format('d/m/Y H:i') : ''],
                                ['bg-green-100','text-green-600','M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15','Dernière mise à jour', $reinscription->updated_at ? $reinscription->updated_at->format('d/m/Y H:i') : ''],
                            ] as [$bg, $tc, $path, $label, $value])
                            <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-all duration-300">
                                <div class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-10 lg:h-10 {{ $bg }} rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 md:w-4 md:h-4 lg:w-5 lg:h-5 {{ $tc }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-500">{{ $label }}</p>
                                    <p class="font-bold text-gray-800 text-[9px] sm:text-[10px] md:text-xs lg:text-sm">{{ $value }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── OBSERVATION ── --}}
    @if($reinscription->observation)
    <div class="mb-5 sm:mb-6 md:mb-8 transition-all duration-500 hover:-translate-y-1">
        <div class="bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl overflow-hidden print:shadow-none print:border print:border-gray-300">
            {{-- Version imprimable --}}
            <div class="hidden print:block p-4 sm:p-5 md:p-6">
                <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-3 md:mb-4 border-b-2 border-gray-300 pb-2">OBSERVATION</h2>
                <p class="text-gray-700 text-xs sm:text-sm whitespace-pre-line">{{ $reinscription->observation }}</p>
            </div>
            {{-- Version écran --}}
            <div class="print:hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-4 sm:px-5 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5">
                    <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-white/20 backdrop-blur-lg rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <h2 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-white">Observation</h2>
                    </div>
                </div>
                <div class="p-4 sm:p-5 md:p-6 lg:p-8">
                    <p class="text-gray-700 text-xs sm:text-sm md:text-base lg:text-lg leading-relaxed whitespace-pre-line">{{ $reinscription->observation }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ── INFORMATIONS SYSTÈME (masquées à l'impression) ── --}}
    <div class="bg-white rounded-xl sm:rounded-2xl md:rounded-3xl shadow-xl overflow-hidden mb-5 sm:mb-6 md:mb-8 transition-all duration-500 hover:-translate-y-1 no-print">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-4 sm:px-5 md:px-6 lg:px-8 py-3 sm:py-4 md:py-5">
            <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
                <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-white/10 backdrop-blur-lg rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="text-sm sm:text-base md:text-lg lg:text-xl font-bold text-white">Informations système</h2>
            </div>
        </div>
        <div class="p-4 sm:p-5 md:p-6 lg:p-8">
            {{-- 1 col mobile → 2 col md+ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
                <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-blue-100 rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-500">Créé le</p>
                        <p class="text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-bold text-gray-800">{{ $reinscription->created_at ? $reinscription->created_at->format('d/m/Y à H:i') : '' }}</p>
                    </div>
                </div>
                <div class="flex items-center p-2 sm:p-3 md:p-4 bg-gray-50 rounded-lg sm:rounded-xl hover:bg-gray-100 transition-all duration-300">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 md:w-10 md:h-10 lg:w-12 lg:h-12 bg-green-100 rounded-lg sm:rounded-xl flex items-center justify-center mr-2 sm:mr-3 md:mr-4 flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 md:w-5 md:h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-[8px] sm:text-[9px] md:text-[10px] text-gray-500">Dernière mise à jour</p>
                        <p class="text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-bold text-gray-800">{{ $reinscription->updated_at ? $reinscription->updated_at->format('d/m/Y à H:i') : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pied de page impression --}}
    <div class="hidden print:block mt-6 md:mt-8 pt-6 md:pt-8 text-center text-xs md:text-sm text-gray-600 border-t-2 border-gray-300">
        <p class="font-semibold">Établissement scolaire - Gestion des réinscriptions</p>
        <p class="mt-1">Document officiel - Valeur légale</p>
        <p class="mt-3 md:mt-4 text-[9px] md:text-xs text-gray-500">Généré le {{ now()->format('d/m/Y à H:i:s') }} - Réinscription N°{{ $reinscription->id }}</p>
    </div>

    {{-- ── BOUTON IMPRIMER (masqué à l'impression) ── --}}
    <div class="flex justify-end no-print mt-4 sm:mt-5 md:mt-6">
        <button onclick="window.print()"
                class="group relative inline-flex items-center px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 md:py-3
                       bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800
                       text-white font-medium rounded-lg sm:rounded-xl transition-all duration-300
                       transform hover:scale-105 hover:shadow-xl overflow-hidden text-[10px] sm:text-xs md:text-sm">
            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 mr-1.5 sm:mr-2 flex-shrink-0 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Imprimer
        </button>
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
    
    @keyframes float-1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(10px,-10px)} }
    @keyframes float-2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,5px)} }
    @keyframes float-3 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(8px,8px) scale(1.1)} }
    @keyframes float-4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-12px,-8px)} }
    .animate-float-1{animation:float-1 8s ease-in-out infinite}
    .animate-float-2{animation:float-2 10s ease-in-out infinite}
    .animate-float-3{animation:float-3 12s ease-in-out infinite}
    .animate-float-4{animation:float-4 9s ease-in-out infinite}

    @keyframes fadeInUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeInRight{ from{opacity:0;transform:translateX(-20px)} to{opacity:1;transform:translateX(0)} }
    @keyframes progress   { from{width:0%} to{width:75%} }
    .animate-fade-in-up   { animation: fadeInUp    0.8s ease-out forwards; }
    .animate-fade-in-right{ animation: fadeInRight 0.8s ease-out forwards; }
    .animate-progress     { animation: progress    1.5s ease-out forwards; }
    .animation-delay-200  { animation-delay: 200ms; opacity: 0; }

    @media print {
        .no-print { display: none !important; }
        body {
            background-color: white !important;
            padding: 0 !important; margin: 0 !important;
            font-size: 12pt; line-height: 1.5; color: #000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .container { max-width: 100% !important; width: 100% !important; padding: 0.5in !important; margin: 0 auto !important; }
        .print\:block  { display: block !important; }
        .print\:hidden { display: none  !important; }
        .print\:shadow-none   { box-shadow: none !important; }
        .print\:transform-none{ transform: none !important; }
        .print\:border        { border: 1px solid #d1d5db !important; }
        .print\:border-gray-300{ border-color: #d1d5db !important; }
        .print\:rounded-lg    { border-radius: 0.5rem !important; }
        .bg-white { page-break-inside: avoid; break-inside: avoid; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        p { orphans: 3; widows: 3; }
    }
    
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
    window.onbeforeprint = () => document.body.classList.add('preparing-print');
    window.onafterprint  = () => document.body.classList.remove('preparing-print');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) { e.target.classList.add('animate-fade-in-up'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('.group').forEach(el => observer.observe(el));
</script>
@endpush