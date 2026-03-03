@extends('layouts.app')

@section('title', 'Détails de l\'année scolaire')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                            <a href="{{ route('admin.annee_scolaires.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Années scolaires
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ $anneeScolaire->nom }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    {{ $anneeScolaire->nom }}
                </h1>
                <p class="text-blue-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    du {{ $anneeScolaire->date_debut->format('d/m/Y') }} au {{ $anneeScolaire->date_fin->format('d/m/Y') }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.annee_scolaires.edit', $anneeScolaire) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.annee_scolaires.index') }}" 
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
<div class="container mx-auto px-4 py-10 bg-gray-50">
    <!-- Badge de statut -->
    <div class="relative mb-8">
        <div class="absolute -top-12 right-0">
            <div class="bg-white rounded-full shadow-xl px-6 py-3 flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">Statut :</span>
                @if($anneeScolaire->active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Année en cours
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                        Inactive
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <!-- Cartes d'information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Carte Informations générales -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Informations générales</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                            {{ substr($anneeScolaire->nom, 0, 2) }}
                        </div>
                        <div class="ml-4">
                            <h2 class="text-xl font-bold text-gray-800">{{ $anneeScolaire->nom }}</h2>
                            <p class="text-sm text-gray-600">ID: #{{ $anneeScolaire->id }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Période</p>
                                <p class="font-medium text-gray-800">
                                    du {{ $anneeScolaire->date_debut->format('d/m/Y') }}<br>
                                    au {{ $anneeScolaire->date_fin->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs text-gray-500">Durée</p>
                                <p class="font-medium text-gray-800">
                                    @php
                                        $debut = \Carbon\Carbon::parse($anneeScolaire->date_debut);
                                        $fin = \Carbon\Carbon::parse($anneeScolaire->date_fin);
                                        $diffJours = $debut->diffInDays($fin);
                                        $diffMois = $debut->diffInMonths($fin);
                                    @endphp
                                    {{ $diffJours }} jours ({{ $diffMois }} mois)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Statistiques -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Statistiques</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Inscriptions</p>
                                    <p class="text-xl font-bold text-gray-800">{{ $stats['total_inscriptions'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ $stats['total_inscriptions'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Évaluations</p>
                                    <p class="text-xl font-bold text-gray-800">{{ $stats['total_evaluations'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">{{ $stats['total_evaluations'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Emplois du temps</p>
                                    <p class="text-xl font-bold text-gray-800">{{ $stats['total_emplois'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-purple-600 bg-purple-50 px-2 py-1 rounded-lg">{{ $stats['total_emplois'] }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Classes</p>
                                    <p class="text-xl font-bold text-gray-800">{{ $stats['total_classes'] }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-green-600 bg-green-50 px-2 py-1 rounded-lg">{{ $stats['total_classes'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte État d'avancement -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">État d'avancement</h3>
                </div>
                <div class="p-6">
                    @php
                        $aujourdhui = now();
                        $debut = \Carbon\Carbon::parse($anneeScolaire->date_debut);
                        $fin = \Carbon\Carbon::parse($anneeScolaire->date_fin);
                        $totalJours = $debut->diffInDays($fin);
                        $joursPasses = $debut->diffInDays($aujourdhui);
                        $pourcentage = $totalJours > 0 ? round(($joursPasses / $totalJours) * 100, 1) : 0;
                        $pourcentage = min(100, max(0, $pourcentage));
                    @endphp

                    <div class="text-center mb-6">
                        <span class="text-5xl font-bold {{ $pourcentage > 100 ? 'text-red-600' : 'text-blue-600' }}">
                            {{ $pourcentage }}%
                        </span>
                        <p class="text-sm text-gray-500 mt-1">de l'année scolaire écoulée</p>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-4 rounded-full transition-all duration-500" 
                             style="width: {{ $pourcentage }}%"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 text-sm mt-4">
                        <div class="bg-blue-50 rounded-xl p-3 text-center">
                            <p class="text-xs text-blue-600">Jours passés</p>
                            <p class="text-xl font-bold text-blue-700">{{ $joursPasses }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-3 text-center">
                            <p class="text-xs text-purple-600">Jours restants</p>
                            <p class="text-xl font-bold text-purple-700">{{ max(0, $totalJours - $joursPasses) }}</p>
                        </div>
                    </div>

                    @if($anneeScolaire->containsDate(now()))
                        <div class="mt-4 bg-green-100 text-green-700 rounded-xl p-3 text-center text-sm">
                            ✅ Nous sommes actuellement dans cette année scolaire
                        </div>
                    @else
                        <div class="mt-4 bg-gray-100 text-gray-700 rounded-xl p-3 text-center text-sm">
                            ⏰ Nous ne sommes pas dans cette année scolaire
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sections avec onglets -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
            <div class="border-b border-gray-200" x-data="{ tab: 'inscriptions' }">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button @click="tab = 'inscriptions'" 
                            :class="{ 'border-blue-500 text-blue-600': tab === 'inscriptions', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'inscriptions' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Inscriptions ({{ $anneeScolaire->inscriptions->count() }})
                    </button>
                    <button @click="tab = 'evaluations'" 
                            :class="{ 'border-blue-500 text-blue-600': tab === 'evaluations', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'evaluations' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Évaluations ({{ $anneeScolaire->evaluations->count() }})
                    </button>
                    <button @click="tab = 'emplois'" 
                            :class="{ 'border-blue-500 text-blue-600': tab === 'emplois', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'emplois' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Emplois du temps ({{ $anneeScolaire->emploiDuTemps->count() }})
                    </button>
                </nav>

                <div class="p-6">
                    <!-- Inscriptions -->
                    <div x-show="tab === 'inscriptions'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                        @if($anneeScolaire->inscriptions->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Élève</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Classe</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date inscription</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($anneeScolaire->inscriptions as $inscription)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                                            <span class="text-blue-700 font-bold text-xs">{{ substr($inscription->eleve->prenom ?? '?', 0, 1) }}{{ substr($inscription->eleve->nom ?? '?', 0, 1) }}</span>
                                                        </div>
                                                        <span class="text-sm">{{ $inscription->eleve->nom ?? '' }} {{ $inscription->eleve->prenom ?? '' }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-sm">{{ $inscription->classe->nom ?? 'N/A' }}</td>
                                                <td class="px-4 py-3 text-sm">{{ $inscription->date_inscription->format('d/m/Y') }}</td>
                                                <td class="px-4 py-3">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $inscription->statut ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                        {{ $inscription->statut ? 'Actif' : 'Inactif' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucune inscription pour cette année scolaire</p>
                        @endif
                    </div>

                    <!-- Évaluations -->
                    <div x-show="tab === 'evaluations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                        @if($anneeScolaire->evaluations->count() > 0)
                            <div class="space-y-3">
                                @foreach($anneeScolaire->evaluations as $evaluation)
                                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">{{ $evaluation->nom }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $evaluation->classe->nom ?? 'N/A' }} • 
                                                    {{ $evaluation->matiere->nom ?? 'N/A' }} •
                                                    {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                                {{ $evaluation->type }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucune évaluation pour cette année scolaire</p>
                        @endif
                    </div>

                    <!-- Emplois du temps -->
                    <div x-show="tab === 'emplois'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                        @if($anneeScolaire->emploiDuTemps->count() > 0)
                            <div class="space-y-3">
                                @foreach($anneeScolaire->emploiDuTemps as $emploi)
                                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-medium text-gray-800">{{ $emploi->matiere->nom ?? 'N/A' }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $emploi->classe->nom ?? 'N/A' }} • 
                                                    {{ $emploi->jour }} • 
                                                    {{ substr($emploi->heure_debut, 0, 5) }} - {{ substr($emploi->heure_fin, 0, 5) }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded-full">
                                                {{ $emploi->enseignant->nom ?? 'N/A' }} {{ $emploi->enseignant->prenom ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">Aucun emploi du temps pour cette année scolaire</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations système -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Informations système</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Créé le</span>
                        <p class="font-medium text-gray-800">{{ $anneeScolaire->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">Dernière mise à jour</span>
                        <p class="font-medium text-gray-800">{{ $anneeScolaire->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection