@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Mon Bulletin') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header avec animation -->
        <div class="relative mb-8 overflow-hidden group rounded-2xl">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 via-pink-500 to-indigo-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules flottantes -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 8; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" 
                     style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s; opacity: 0.6;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex items-center justify-between">
                    <div class="transition-all duration-700 transform animate-slide-in-left">
                        <h3 class="text-3xl font-bold text-white drop-shadow-lg">Mes Bulletins</h3>
                        <p class="flex items-center mt-2 text-purple-100">
                            <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Consultez vos bulletins scolaires
                        </p>
                    </div>
                    <div class="hidden transition-all duration-700 transform md:block animate-slide-in-right hover:rotate-12 hover:scale-110">
                        <div class="p-5 border rounded-full bg-white/20 backdrop-blur-sm border-white/30">
                            <svg class="w-16 h-16 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="mb-8 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl animate-fade-in-up">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="flex items-center text-lg font-semibold text-gray-900">
                    <svg class="w-5 h-5 mr-2 text-purple-600 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filtrer les bulletins
                </h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('eleve.bulletin') }}" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Période
                        </label>
                        <select name="periode" class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 hover:border-purple-400 hover:shadow-lg">
                            <option value="">Toutes les périodes</option>
                            @foreach($periodes as $key => $periode)
                                <option value="{{ $key }}" {{ request('periode') == $key ? 'selected' : '' }}>
                                    {{ $periode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="transition-all duration-300 transform hover:scale-105">
                        <label class="flex items-center mb-2 text-sm font-medium text-gray-700">
                            <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Année scolaire
                        </label>
                        <select name="annee_scolaire_id" class="w-full transition-all duration-300 border-gray-300 rounded-xl focus:border-purple-500 focus:ring-purple-500 hover:border-purple-400 hover:shadow-lg">
                            <option value="">Toutes les années</option>
                            @foreach($anneesScolaires as $annee)
                                <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 md:col-span-1">
                        <a href="{{ route('eleve.bulletin') }}" 
                           class="flex items-center px-6 py-3 font-semibold text-gray-700 transition-all duration-300 transform bg-gray-100 rounded-xl hover:bg-gray-200 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-5 h-5 mr-2 transition-transform duration-500 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Réinitialiser
                        </a>
                        <button type="submit" class="flex items-center px-6 py-3 font-semibold text-white transition-all duration-300 transform bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl hover:from-purple-600 hover:to-purple-700 hover:scale-105 hover:shadow-lg group">
                            <svg class="w-5 h-5 mr-2 transition-all duration-500 group-hover:animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des bulletins -->
        @forelse($bulletins as $bulletin)
            <div class="mb-8 overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                <!-- Bulletin Header avec dégradé -->
                <div class="relative p-8 overflow-hidden bg-gradient-to-r from-purple-700 via-purple-600 to-indigo-600">
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute w-64 h-64 bg-white rounded-full -top-32 -right-32 blur-3xl"></div>
                        <div class="absolute w-64 h-64 bg-yellow-300 rounded-full -bottom-32 -left-32 blur-3xl"></div>
                    </div>
                    
                    <div class="relative flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="transition-all duration-700 transform hover:scale-105">
                            <div class="flex items-center space-x-4">
                                <div class="p-4 bg-white/20 rounded-2xl">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">{{ $bulletin->periode }}</h3>
                                    <p class="flex items-center mt-1 text-purple-100">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Classe: {{ $bulletin->classe->nom ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center md:mt-0 md:text-right">
                            <p class="text-sm text-purple-200">Moyenne générale</p>
                            <div class="flex items-center justify-center space-x-2 md:justify-end">
                                <span class="text-5xl font-bold text-white">{{ number_format($bulletin->moyenne_generale ?? 0, 2) }}</span>
                                <span class="text-xl text-purple-200">/20</span>
                            </div>
                            <div class="mt-2">
                                @php
                                    $mention = '';
                                    $mentionColor = '';
                                    if(($bulletin->moyenne_generale ?? 0) >= 16) {
                                        $mention = 'Très bien';
                                        $mentionColor = 'bg-green-500';
                                    } elseif(($bulletin->moyenne_generale ?? 0) >= 14) {
                                        $mention = 'Bien';
                                        $mentionColor = 'bg-blue-500';
                                    } elseif(($bulletin->moyenne_generale ?? 0) >= 12) {
                                        $mention = 'Assez bien';
                                        $mentionColor = 'bg-yellow-500';
                                    } elseif(($bulletin->moyenne_generale ?? 0) >= 10) {
                                        $mention = 'Passable';
                                        $mentionColor = 'bg-orange-500';
                                    } else {
                                        $mention = 'Insuffisant';
                                        $mentionColor = 'bg-red-500';
                                    }
                                @endphp
                                <span class="inline-block px-4 py-1 text-sm font-semibold text-white {{ $mentionColor }} rounded-full">
                                    {{ $mention }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bulletin Content -->
                <div class="p-8">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 gap-4 mb-8 md:grid-cols-3">
                        <div class="p-5 transition-all duration-300 transform border border-blue-100 bg-gradient-to-br from-blue-50 to-white rounded-xl hover:shadow-lg hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Rang</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $bulletin->rang ?? '-' }}
                                        @if($bulletin->effectif_classe)
                                            <span class="text-sm font-normal text-gray-500">/{{ $bulletin->effectif_classe }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="p-3 bg-blue-100 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 transition-all duration-300 transform border border-green-100 bg-gradient-to-br from-green-50 to-white rounded-xl hover:shadow-lg hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Moyenne de la classe</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        @if($bulletin->moyenne_classe)
                                            {{ number_format($bulletin->moyenne_classe, 2) }}
                                        @else
                                            @php
                                                // Utiliser notesDirectes au lieu de notesBulletin
                                                $notesDirectes = $bulletin->notesDirectes ?? collect([]);
                                                if($notesDirectes->count() > 0) {
                                                    $totalNotes = 0;
                                                    $compteur = 0;
                                                    foreach($notesDirectes as $note) {
                                                        $totalNotes += $note->note;
                                                        $compteur++;
                                                    }
                                                    if($compteur > 0) {
                                                        echo number_format($totalNotes / $compteur, 2);
                                                    } else {
                                                        echo '-';
                                                    }
                                                } else {
                                                    echo '-';
                                                }
                                            @endphp
                                        @endif
                                        <span class="text-sm font-normal text-gray-500">/20</span>
                                    </p>
                                </div>
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="p-5 transition-all duration-300 transform border border-purple-100 bg-gradient-to-br from-purple-50 to-white rounded-xl hover:shadow-lg hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Écart avec la classe</p>
                                    @php
                                        $moyenneEleve = $bulletin->moyenne_generale ?? 0;
                                        $moyenneClasse = $bulletin->moyenne_classe ?? 0;
                                        
                                        // Utiliser notesDirectes au lieu de notesBulletin
                                        $notesDirectes = $bulletin->notesDirectes ?? collect([]);
                                        if($moyenneClasse == 0 && $notesDirectes->count() > 0) {
                                            $totalNotes = 0;
                                            $compteur = 0;
                                            foreach($notesDirectes as $note) {
                                                $totalNotes += $note->note;
                                                $compteur++;
                                            }
                                            if($compteur > 0) {
                                                $moyenneClasse = round($totalNotes / $compteur, 2);
                                            }
                                        }
                                        
                                        $ecart = $moyenneEleve - $moyenneClasse;
                                        $ecartColor = $ecart >= 0 ? 'text-green-600' : 'text-red-600';
                                    @endphp
                                    <p class="text-2xl font-bold {{ $ecartColor }}">
                                        {{ $moyenneEleve && $moyenneClasse ? number_format($ecart, 2) : '-' }}
                                    </p>
                                </div>
                                <div class="p-3 bg-purple-100 rounded-lg">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l.01 0M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appréciation -->
                    @if($bulletin->appreciation)
                    <div class="p-5 mb-8 transition-all duration-300 transform border border-yellow-200 bg-gradient-to-r from-yellow-50 to-white rounded-xl hover:shadow-lg">
                        <div class="flex items-start space-x-3">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="mb-1 text-sm font-medium text-gray-500">Appréciation du professeur principal</p>
                                <p class="italic text-gray-700">"{{ $bulletin->appreciation }}"</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Notes par matière - VERSION CORRIGÉE -->
                    <h4 class="flex items-center mb-4 text-lg font-semibold text-gray-900">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Détail des notes par matière
                    </h4>

                    @php
                        // Utiliser notesDirectes au lieu de notesBulletin
                        $notesDirectes = $bulletin->notesDirectes ?? collect([]);
                    @endphp

                    @if($notesDirectes->count() > 0)
                        @php
                            // Regrouper les notes par matière
                            $notesParMatiere = [];
                            $totalPoints = 0;
                            $totalCoeffs = 0;
                            
                            foreach($notesDirectes as $note) {
                                if($note->evaluation && $note->evaluation->matiere) {
                                    $matiereId = $note->evaluation->matiere->id;
                                    $coefficient = $note->evaluation->coefficient ?? 1;
                                    
                                    if(!isset($notesParMatiere[$matiereId])) {
                                        $notesParMatiere[$matiereId] = [
                                            'nom' => $note->evaluation->matiere->nom,
                                            'coefficient' => $coefficient,
                                            'notes' => collect(),
                                            'total' => 0,
                                            'count' => 0,
                                            'total_pondere' => 0
                                        ];
                                    }
                                    
                                    $notesParMatiere[$matiereId]['notes']->push($note);
                                    $notesParMatiere[$matiereId]['total'] += $note->note;
                                    $notesParMatiere[$matiereId]['total_pondere'] += $note->note * $coefficient;
                                    $notesParMatiere[$matiereId]['count']++;
                                    
                                    $totalPoints += $note->note * $coefficient;
                                    $totalCoeffs += $coefficient;
                                }
                            }
                        @endphp

                        <div class="overflow-hidden border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-purple-50 to-indigo-50">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Matière</th>
                                        <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Coefficient</th>
                                        <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Notes</th>
                                        <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Moyenne</th>
                                        <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Appréciation</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($notesParMatiere as $matiereId => $matiereData)
                                        @php
                                            $moyenneMatiere = $matiereData['count'] > 0 ? round($matiereData['total'] / $matiereData['count'], 2) : 0;
                                            $noteClass = $moyenneMatiere >= 16 ? 'bg-green-100 text-green-800' : 
                                                        ($moyenneMatiere >= 14 ? 'bg-blue-100 text-blue-800' : 
                                                        ($moyenneMatiere >= 10 ? 'bg-yellow-100 text-yellow-800' : 
                                                        'bg-red-100 text-red-800'));
                                        @endphp
                                        <tr class="transition-all duration-300 hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg shadow-md bg-gradient-to-br from-purple-500 to-indigo-600">
                                                        <span class="text-xs font-bold text-white">{{ substr($matiereData['nom'], 0, 2) }}</span>
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $matiereData['nom'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-purple-700 bg-purple-100 rounded-full">
                                                    {{ $matiereData['coefficient'] }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($matiereData['notes'] as $note)
                                                        @php
                                                            $couleurNote = $note->note >= 16 ? 'green' : 
                                                                          ($note->note >= 14 ? 'blue' : 
                                                                          ($note->note >= 10 ? 'yellow' : 'red'));
                                                        @endphp
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-{{ $couleurNote }}-100 text-{{ $couleurNote }}-800 rounded-md" 
                                                              title="{{ $note->evaluation->type }} du {{ $note->evaluation->date_evaluation?->format('d/m/Y') }}">
                                                            {{ number_format($note->note, 1) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-4 py-2 inline-flex text-sm font-bold rounded-xl {{ $noteClass }}">
                                                    {{ number_format($moyenneMatiere, 2) }}/20
                                                </span>
                                            </td>
                                            <td class="max-w-xs px-6 py-4 text-sm text-gray-600">
                                                {{ $matiereData['notes']->first()->pivot->appreciation ?? $matiereData['notes']->first()->observation ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                    <!-- Ligne récapitulative -->
                                    <tr class="font-semibold bg-gradient-to-r from-purple-50 to-indigo-50">
                                        <td colspan="2" class="px-6 py-4 text-sm text-gray-700">Total général</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $totalPoints ?? 0 }} points</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Coeff. {{ $totalCoeffs ?? 0 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">Moy. {{ $totalCoeffs > 0 ? number_format($totalPoints / $totalCoeffs, 2) : '-' }}/20</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-8 text-center border border-gray-200 rounded-xl">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-500">Aucune note disponible pour ce bulletin</p>
                            <p class="mt-2 text-sm text-gray-400">Les notes n'ont pas encore été associées à ce bulletin.</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-16 text-center bg-white shadow-xl rounded-2xl">
                <div class="relative inline-block animate-float">
                    <div class="absolute inset-0 bg-purple-300 rounded-full opacity-50 blur-xl"></div>
                    <svg class="relative text-purple-400 w-28 h-28" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="mt-6 text-2xl font-semibold text-gray-700">Aucun bulletin disponible</h3>
                <p class="mt-2 text-gray-500">Vos bulletins scolaires apparaîtront ici une fois publiés par l'administration.</p>
            </div>
        @endforelse

        <!-- Pagination -->
        @if(method_exists($bulletins, 'links'))
            <div class="mt-8">
                {{ $bulletins->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* Animations personnalisées */
@keyframes gradient-x {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
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
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-in-right {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes pulse-slow {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

.animate-gradient-x {
    background-size: 200% 200%;
    animation: gradient-x 15s ease infinite;
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

.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}

.animate-pulse-slow {
    animation: pulse-slow 3s ease-in-out infinite;
}

.animation-delay-200 {
    animation-delay: 200ms;
}

.animation-delay-2000 {
    animation-delay: 2000ms;
}

/* Transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}

.hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endsection