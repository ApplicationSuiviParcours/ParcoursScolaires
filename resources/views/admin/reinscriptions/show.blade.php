@extends('layouts.app')

@section('title', 'Détails de la réinscription')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-900 py-12 no-print">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left">
                <nav class="flex mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.reinscriptions.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Réinscriptions
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Détails</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Détails de la réinscription
                </h1>
                <p class="text-indigo-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Consultation complète des informations de réinscription
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right no-print">
                <a href="{{ route('admin.reinscriptions.edit', $reinscription) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2 animate-none group-hover:animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.reinscriptions.index') }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
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
<div class="container mx-auto px-4 py-10 bg-gray-50" id="printable-content">
    <!-- En-tête imprimable (visible uniquement à l'impression) -->
    <div class="hidden print:block mb-8 text-center">
        <h1 class="text-2xl font-bold text-gray-800">FICHE DE RÉINSCRIPTION</h1>
        <p class="text-gray-600">Document officiel - Établissement scolaire</p>
        <p class="text-sm text-gray-500 mt-2">Généré le {{ now()->format('d/m/Y à H:i') }}</p>
    </div>

    <!-- Badge de statut flottant (masqué à l'impression) -->
    <div class="relative mb-8 no-print">
        <div class="absolute -top-12 right-0 animate-bounce-slow">
            <div class="bg-white rounded-full shadow-xl px-6 py-3 flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">Statut actuel :</span>
                {!! $reinscription->statut_badge !!}
            </div>
        </div>
    </div>

    <!-- Cartes d'information avec versions écran et impression -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Carte Élève -->
        <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            <!-- Version imprimable -->
            <div class="hidden print:block p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">INFORMATIONS DE L'ÉLÈVE</h2>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold">Nom complet :</span> {{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}</p>
                    @if($reinscription->eleve && $reinscription->eleve->matricule)
                        <p><span class="font-semibold">Matricule :</span> {{ $reinscription->eleve->matricule }}</p>
                    @endif
                    @if($reinscription->eleve && $reinscription->eleve->date_naissance)
                        <p><span class="font-semibold">Date de naissance :</span> {{ $reinscription->eleve->date_naissance->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>

            <!-- Version écran -->
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                
                <div class="relative p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 border-4 border-white rounded-full group-hover:animate-ping"></div>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-blue-600 transition-colors duration-300">Élève</h2>
                        </div>
                        <span class="px-4 py-2 bg-blue-100 text-blue-600 text-sm font-medium rounded-xl group-hover:scale-105 transition-transform duration-300">Principal</span>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl group-hover:shadow-lg transition-all duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Nom complet</p>
                                <p class="text-lg font-bold text-gray-800">{{ $reinscription->eleve->nom ?? '' }} {{ $reinscription->eleve->prenom ?? '' }}</p>
                            </div>
                        </div>

                        @if($reinscription->eleve && $reinscription->eleve->matricule)
                        <div class="flex items-center p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Matricule</p>
                                <p class="text-lg font-bold text-gray-800">{{ $reinscription->eleve->matricule }}</p>
                            </div>
                        </div>
                        @endif

                        @if($reinscription->eleve && $reinscription->eleve->date_naissance)
                        <div class="flex items-center p-4 bg-gray-50 rounded-2xl hover:bg-gray-100 transition-colors duration-300">
                            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Date de naissance</p>
                                <p class="text-lg font-bold text-gray-800">{{ $reinscription->eleve->date_naissance->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Progression de l'année -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Progression scolaire</span>
                            <span class="text-sm font-medium text-blue-600">75%</span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-progress" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Classe & Année -->
        <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            <!-- Version imprimable -->
            <div class="hidden print:block p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">CLASSE ET ANNÉE SCOLAIRE</h2>
                <div class="space-y-3 text-sm">
                    <p><span class="font-semibold">Classe :</span> {{ $reinscription->classe->nom ?? '' }}</p>
                    <p><span class="font-semibold">Année scolaire :</span> {{ $reinscription->anneeScolaire->nom ?? '' }}</p>
                    @if($reinscription->anneeScolaire && $reinscription->anneeScolaire->date_debut)
                        <p><span class="font-semibold">Période :</span> du {{ $reinscription->anneeScolaire->date_debut->format('d/m/Y') }} au {{ $reinscription->anneeScolaire->date_fin->format('d/m/Y') }}</p>
                    @endif
                </div>
            </div>

            <!-- Version écran -->
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500 to-emerald-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                
                <div class="relative p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-green-600 transition-colors duration-300">Classe & Année</h2>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="relative p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-green-200 rounded-full filter blur-2xl opacity-50"></div>
                            <div class="relative z-10">
                                <p class="text-sm text-gray-500 mb-2">Classe actuelle</p>
                                <p class="text-2xl font-bold text-gray-800 mb-2">{{ $reinscription->classe->nom ?? '' }}</p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>{{ $reinscription->classe->effectif ?? 'N/A' }} élèves</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                                <p class="text-xs text-gray-500 mb-1">Année scolaire</p>
                                <p class="font-bold text-gray-800">{{ $reinscription->anneeScolaire->nom ?? '' }}</p>
                            </div>
                            
                            @if($reinscription->anneeScolaire && $reinscription->anneeScolaire->date_debut)
                            <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                                <p class="text-xs text-gray-500 mb-1">Période</p>
                                <p class="font-bold text-gray-800 text-sm">
                                    {{ $reinscription->anneeScolaire->date_debut->format('d/m/Y') }}<br>
                                    <span class="text-xs text-gray-500">au</span><br>
                                    {{ $reinscription->anneeScolaire->date_fin->format('d/m/Y') }}
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Indicateur de performance -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Taux de réussite</span>
                            <span class="text-sm font-medium text-green-600">92%</span>
                        </div>
                        <div class="mt-2 flex space-x-1">
                            @for($i = 0; $i < 5; $i++)
                                <div class="h-2 flex-1 bg-green-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-green-500 rounded-full" style="width: {{ $i < 4 ? 100 : 60 }}%"></div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Statut & Date -->
        <div class="group relative bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden print:shadow-none print:transform-none print:border print:border-gray-300 print:rounded-lg">
            <!-- Version imprimable -->
            <div class="hidden print:block p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">STATUT ET DATES</h2>
                <div class="space-y-3 text-sm">
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

            <!-- Version écran -->
            <div class="print:hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-600 opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500 rounded-full filter blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-500"></div>
                
                <div class="relative p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors duration-300">Statut & Date</h2>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Statut avec animation -->
                        <div class="relative p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-white/50 backdrop-blur-sm"></div>
                            <div class="relative z-10 text-center">
                                <p class="text-sm text-gray-500 mb-3">Statut actuel</p>
                                <div class="transform group-hover:scale-110 transition-transform duration-500">
                                    {!! $reinscription->statut_badge !!}
                                </div>
                            </div>
                        </div>

                        <!-- Timeline des dates -->
                        <div class="space-y-3">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 group/item">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Date de réinscription</p>
                                    <p class="font-bold text-gray-800">{{ $reinscription->date_reinscription ? $reinscription->date_reinscription->format('d/m/Y') : '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 group/item">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Date de création</p>
                                    <p class="font-bold text-gray-800">{{ $reinscription->created_at ? $reinscription->created_at->format('d/m/Y H:i') : '' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 group/item">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4 group-hover/item:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Dernière mise à jour</p>
                                    <p class="font-bold text-gray-800">{{ $reinscription->updated_at ? $reinscription->updated_at->format('d/m/Y H:i') : '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Observation -->
    @if($reinscription->observation)
    <div class="mb-8 transform transition-all duration-500 hover:-translate-y-1">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden print:shadow-none print:border print:border-gray-300">
            <!-- Version imprimable -->
            <div class="hidden print:block p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2">OBSERVATION</h2>
                <p class="text-gray-700 whitespace-pre-line">{{ $reinscription->observation }}</p>
            </div>

            <!-- Version écran -->
            <div class="print:hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-5">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">Observation</h2>
                    </div>
                </div>
                <div class="p-8">
                    <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">{{ $reinscription->observation }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Section Informations système (masquée à l'impression) -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 transform transition-all duration-500 hover:-translate-y-1 no-print">
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-5">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Informations système</h2>
            </div>
        </div>
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Créé le</p>
                        <p class="text-lg font-bold text-gray-800">{{ $reinscription->created_at ? $reinscription->created_at->format('d/m/Y à H:i') : '' }}</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Dernière mise à jour</p>
                        <p class="text-lg font-bold text-gray-800">{{ $reinscription->updated_at ? $reinscription->updated_at->format('d/m/Y à H:i') : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pied de page pour l'impression (visible uniquement à l'impression) -->
    <div class="hidden print:block mt-8 pt-8 text-center text-sm text-gray-600 border-t-2 border-gray-300">
        <p class="font-semibold">Établissement scolaire - Gestion des réinscriptions</p>
        <p class="mt-1">Document officiel - Valeur légale</p>
        <p class="mt-4 text-xs text-gray-500">Généré le {{ now()->format('d/m/Y à H:i:s') }} - Réinscription N°{{ $reinscription->id }}</p>
    </div>

    <!-- Actions supplémentaires -->
    <div class="flex justify-end space-x-4 no-print">
        <button onclick="window.print()" 
                class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
            <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
            <svg class="w-5 h-5 mr-2 animate-none group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer le document
        </button>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Animations personnalisées */
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(10px, -10px); }
    }
    
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-15px, 5px); }
    }
    
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(8px, 8px) scale(1.1); }
    }
    
    @keyframes float-4 {
        0%, 100% { transform: translate(0, 0); }
        50% { transform: translate(-12px, -8px); }
    }
    
    .animate-float-1 { animation: float-1 8s ease-in-out infinite; }
    .animate-float-2 { animation: float-2 10s ease-in-out infinite; }
    .animate-float-3 { animation: float-3 12s ease-in-out infinite; }
    .animate-float-4 { animation: float-4 9s ease-in-out infinite; }
    
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
    
    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }
    
    .animate-spin-slow {
        animation: spin 3s linear infinite;
    }

    /* Styles d'impression optimisés */
    @media print {
        /* Cacher tous les éléments non nécessaires */
        .no-print {
            display: none !important;
        }
        
        /* Réinitialiser les styles pour l'impression */
        body {
            background-color: white !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 12pt;
            line-height: 1.5;
            color: #000000 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        .container {
            max-width: 100% !important;
            width: 100% !important;
            padding: 0.5in !important;
            margin: 0 auto !important;
        }
        
        /* Afficher les versions imprimables */
        .print\:block {
            display: block !important;
        }
        
        .print\:hidden {
            display: none !important;
        }
        
        /* Styles pour les cartes en impression */
        .print\:shadow-none {
            box-shadow: none !important;
        }
        
        .print\:transform-none {
            transform: none !important;
        }
        
        .print\:border {
            border: 1px solid #d1d5db !important;
        }
        
        .print\:border-gray-300 {
            border-color: #d1d5db !important;
        }
        
        .print\:rounded-lg {
            border-radius: 0.5rem !important;
        }
        
        .print\:bg-gray-100 {
            background-color: #f3f4f6 !important;
        }
        
        .print\:text-gray-800 {
            color: #1f2937 !important;
        }
        
        /* Éviter les coupures de page */
        .bg-white {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        /* Styles de texte pour l'impression */
        h1 {
            font-size: 24pt;
            margin-bottom: 12pt;
            font-weight: bold;
        }
        
        h2 {
            font-size: 16pt;
            margin-bottom: 10pt;
            font-weight: bold;
        }
        
        .border-b-2 {
            border-bottom-width: 2px;
            border-bottom-style: solid;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        /* Assurer que les couleurs s'impriment bien */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Éviter les orphelines */
        p {
            orphans: 3;
            widows: 3;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Fonction d'impression
    function printReinscription() {
        window.print();
    }

    // Détecter le début de l'impression
    window.onbeforeprint = function() {
        console.log('Préparation de l\'impression...');
        // Optionnel : Ajouter une classe pour des ajustements avant impression
        document.body.classList.add('preparing-print');
    };

    // Détecter la fin de l'impression
    window.onafterprint = function() {
        console.log('Impression terminée');
        document.body.classList.remove('preparing-print');
    };

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

    document.querySelectorAll('.group').forEach(el => {
        observer.observe(el);
    });

    // Gestionnaire d'erreur pour l'impression
    window.addEventListener('error', function(e) {
        if (e.target.tagName === 'LINK' && e.target.href.includes('print')) {
            console.warn('Erreur de chargement des styles d\'impression');
        }
    });
</script>
@endpush