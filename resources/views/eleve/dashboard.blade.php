@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Tableau de bord Élève') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Welcome Banner avec animation de particules -->
        <div class="relative mb-8 overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 animate-gradient-x"></div>
            <div class="absolute inset-0 opacity-20">
                <div class="absolute bg-white rounded-full w-96 h-96 -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
                <div class="absolute bg-yellow-300 rounded-full w-96 h-96 -bottom-48 -left-48 blur-3xl animate-pulse-slow animation-delay-2000"></div>
            </div>
            
            <!-- Particules flottantes -->
            <div class="absolute inset-0">
                @for($i = 0; $i < 5; $i++)
                <div class="absolute w-2 h-2 bg-white rounded-full animate-float-random" style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
                @endfor
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar avec effet de halo -->
                        <div class="relative group">
                            <div class="absolute inset-0 transition-opacity duration-500 opacity-75 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-2xl blur-xl group-hover:opacity-100"></div>
                            <div class="relative flex items-center justify-center w-24 h-24 transition-all duration-500 transform shadow-2xl bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl group-hover:scale-110 group-hover:rotate-3">
                                <span class="text-4xl font-bold text-white drop-shadow-lg">{{ substr($eleve->prenom ?? 'E', 0, 1) }}{{ substr($eleve->nom ?? 'L', 0, 1) }}</span>
                            </div>
                            <div class="absolute w-5 h-5 bg-green-400 border-4 border-indigo-600 rounded-full -bottom-1 -right-1 animate-ping"></div>
                            <div class="absolute w-5 h-5 bg-green-400 border-4 border-indigo-600 rounded-full -bottom-1 -right-1"></div>
                        </div>
                        
                        <div class="transition-all duration-500 transform translate-y-0 opacity-100 animate-slide-up">
                            <h1 class="text-4xl font-bold text-white drop-shadow-lg">Bonjour, {{ $eleve->prenom ?? Auth::user()->name }} !</h1>
                            <div class="flex flex-wrap gap-3 mt-3">
                                <span class="inline-flex items-center px-4 py-2 text-sm text-white transition-all duration-300 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 hover:scale-105">
                                    <svg class="w-4 h-4 mr-2 animate-bounce-subtle" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    {{ $inscription->classe->nom ?? 'Non assigné' }}
                                </span>
                                <span class="inline-flex items-center px-4 py-2 text-sm text-white transition-all duration-300 bg-white/20 backdrop-blur-sm rounded-xl hover:bg-white/30 hover:scale-105">
                                    <svg class="w-4 h-4 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $anneeScolaire->nom ?? 'Année scolaire' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats rapides avec compteurs animés -->
                    <div class="flex gap-4 mt-6 md:mt-0">
                        <div class="px-6 py-4 text-center transition-all duration-500 bg-white/10 backdrop-blur-sm rounded-2xl min-w-[140px] hover:bg-white/20 hover:scale-105 group">
                            <p class="text-sm text-white/80">Moyenne</p>
                            <div class="relative">
                                <p class="text-3xl font-bold text-white animate-count">{{ $moyenneGenerale ? number_format($moyenneGenerale, 2) : '-' }}</p>
                                <div class="absolute w-2 h-2 bg-green-400 rounded-full -top-1 -right-2 animate-ping"></div>
                            </div>
                            <p class="text-xs text-white/60">/20</p>
                        </div>
                        <div class="px-6 py-4 text-center transition-all duration-500 bg-white/10 backdrop-blur-sm rounded-2xl min-w-[140px] hover:bg-white/20 hover:scale-105 group">
                            <p class="text-sm text-white/80">Notes</p>
                            <p class="text-3xl font-bold text-white animate-count">{{ $notes->count() }}</p>
                            <p class="text-xs text-white/60">total</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards avec effets 3D -->
        <div class="grid grid-cols-2 gap-4 mb-8 lg:grid-cols-4">
            <div class="group perspective">
                <div class="relative transition-all duration-500 cursor-pointer preserve-3d group-hover:rotate-y-180">
                    <!-- Face avant -->
                    <div class="backface-hidden">
                        <div class="p-5 transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Moyenne</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $moyenneGenerale ? number_format($moyenneGenerale, 2) : '-' }}</p>
                                </div>
                                <div class="p-3 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 animate-float">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Face arrière -->
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex items-center justify-center h-full p-5 shadow-lg bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                            <p class="font-semibold text-white">Performance globale</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group perspective">
                <div class="relative transition-all duration-500 cursor-pointer preserve-3d group-hover:rotate-y-180">
                    <div class="backface-hidden">
                        <div class="p-5 transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Notes</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $notes->count() }}</p>
                                </div>
                                <div class="p-3 rounded-lg bg-gradient-to-br from-green-500 to-green-600 animate-float animation-delay-200">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex items-center justify-center h-full p-5 shadow-lg bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                            <p class="font-semibold text-white">{{ $notes->count() }} notes</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group perspective">
                <div class="relative transition-all duration-500 cursor-pointer preserve-3d group-hover:rotate-y-180">
                    <div class="backface-hidden">
                        <div class="p-5 transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Absences</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $absences->count() }}</p>
                                </div>
                                <div class="p-3 rounded-lg bg-gradient-to-br from-red-500 to-red-600 animate-float animation-delay-400">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex items-center justify-center h-full p-5 shadow-lg bg-gradient-to-br from-red-500 to-red-600 rounded-xl">
                            <p class="font-semibold text-white">{{ $absencesNonJustifiees }} non justifiées</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group perspective">
                <div class="relative transition-all duration-500 cursor-pointer preserve-3d group-hover:rotate-y-180">
                    <div class="backface-hidden">
                        <div class="p-5 transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Bulletins</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $bulletins->count() }}</p>
                                </div>
                                <div class="p-3 rounded-lg bg-gradient-to-br from-purple-500 to-purple-600 animate-float animation-delay-600">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute inset-0 backface-hidden rotate-y-180">
                        <div class="flex items-center justify-center h-full p-5 shadow-lg bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                            <p class="font-semibold text-white">{{ $bulletins->count() }} bulletins</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section principale avec deux colonnes -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <!-- Colonne de gauche -->
            <div class="space-y-6">
                <!-- Dernier bulletin avec effet de carte premium -->
                <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="relative px-6 py-4 overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
                        <div class="absolute inset-0 transition-transform duration-700 transform translate-x-full -skew-x-12 bg-white/10 group-hover:translate-x-0"></div>
                        <div class="flex items-center justify-between">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Dernier bulletin
                                <span class="px-3 py-1 ml-3 text-xs font-medium text-indigo-600 rounded-full bg-white/20 backdrop-blur-sm animate-pulse">
                                    {{ $bulletinCourant->periode ?? 'N/A' }}
                                </span>
                            </h3>
                            <div class="w-8 h-8 rounded-full bg-white/20 animate-ping-slow"></div>
                        </div>
                    </div>

                    <div class="p-6">
                        @if($bulletinCourant)
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative group">
                                    <div class="absolute inset-0 transition-opacity opacity-50 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl blur-lg group-hover:opacity-75"></div>
                                    <div class="relative flex items-center justify-center w-20 h-20 transition-transform transform bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl group-hover:scale-110">
                                        <span class="text-3xl font-bold text-white animate-count">{{ number_format($bulletinCourant->moyenne_generale, 1) }}</span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center space-x-4">
                                        <div class="transition-all transform hover:scale-110">
                                            <span class="text-xs text-gray-400">Rang</span>
                                            <p class="font-semibold text-indigo-600">{{ $bulletinCourant->rang ?? '-' }}{{ $bulletinCourant->rang ? 'ème' : '' }}</p>
                                        </div>
                                        <div class="transition-all transform hover:scale-110">
                                            <span class="text-xs text-gray-400">Moy. classe</span>
                                            <p class="font-semibold text-green-600">{{ number_format($bulletinCourant->moyenne_classe ?? 0, 1) }}</p>
                                        </div>
                                    </div>
                                    @if($bulletinCourant->decision_conseil)
                                    <span class="inline-flex px-3 py-1 {{ $bulletinCourant->decision_conseil == 'Admis' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} font-semibold rounded-full text-sm animate-pulse">
                                        {{ $bulletinCourant->decision_conseil }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if($bulletinCourant->appreciation)
                        <div class="p-4 mt-4 border-l-4 border-indigo-500 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl animate-slide-right">
                            <p class="text-sm italic text-gray-600">"{{ $bulletinCourant->appreciation }}"</p>
                        </div>
                        @endif
                        @else
                        <div class="py-8 text-center">
                            <div class="relative inline-block">
                                <div class="absolute inset-0 bg-gray-300 rounded-full opacity-50 blur-xl"></div>
                                <svg class="relative w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="mt-4 text-gray-500">Aucun bulletin disponible</p>
                        </div>
                        @endif
                        <div class="mt-4 text-right">
                            <a href="{{ route('eleve.bulletin') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-all transform rounded-lg bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 hover:scale-105 group">
                                Voir tous les bulletins
                                <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dernières notes avec animations -->
                <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-green-600 to-emerald-600">
                        <h3 class="flex items-center text-lg font-semibold text-white">
                            <svg class="w-5 h-5 mr-2 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Dernières notes
                        </h3>
                        <a href="{{ route('eleve.notes') }}" class="flex items-center transition-colors text-white/80 hover:text-white group">
                            <span class="text-sm">Voir tout</span>
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="p-6">
                        @if($dernieresNotes->count() > 0)
                        <div class="space-y-3">
                            @foreach($dernieresNotes as $index => $note)
                            @php
                                $noteValue = $note->note ?? $note->valeur ?? 0;
                                $colors = [
                                    ['bg' => 'from-green-500 to-green-600', 'text' => 'text-green-600', 'bg-light' => 'bg-green-50'],
                                    ['bg' => 'from-blue-500 to-blue-600', 'text' => 'text-blue-600', 'bg-light' => 'bg-blue-50'],
                                    ['bg' => 'from-purple-500 to-purple-600', 'text' => 'text-purple-600', 'bg-light' => 'bg-purple-50'],
                                ];
                                $colorIndex = $index % 3;
                            @endphp
                            <div class="flex items-center justify-between p-3 rounded-xl {{ $colors[$colorIndex]['bg-light'] }} transform transition-all hover:scale-102 hover:shadow-md animate-slide-up" style="animation-delay: {{ $index * 100 }}ms">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $colors[$colorIndex]['bg'] }} flex items-center justify-center shadow-lg">
                                        <span class="text-lg font-bold text-white">{{ $noteValue }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $note->evaluation->matiere->nom ?? 'Matière' }}</p>
                                        <p class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $note->evaluation->type ?? 'Évaluation' }} • {{ $note->created_at?->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 font-bold {{ $colors[$colorIndex]['text'] }} bg-white rounded-full shadow-sm">
                                    {{ number_format($noteValue, 1) }}/20
                                </span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="py-8 text-center">
                            <div class="relative inline-block animate-float">
                                <div class="absolute inset-0 bg-green-300 rounded-full opacity-50 blur-xl"></div>
                                <svg class="relative w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <p class="mt-4 text-gray-500">Aucune note disponible</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne de droite -->
            <div class="space-y-6">
                <!-- Performance par matière avec barres animées -->
                <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600">
                        <h3 class="flex items-center text-lg font-semibold text-white">
                            <svg class="w-5 h-5 mr-2 animate-spin-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Performance par matière
                        </h3>
                    </div>

                    <div class="p-6">
                        @if(count($moyennesParMatiere) > 0)
                        <div class="space-y-5">
                            @foreach($moyennesParMatiere as $index => $matiere)
                            @php
                                $percentage = ($matiere['moyenne'] / 20) * 100;
                                $barColor = $percentage >= 75 ? 'from-green-500 to-green-600' : ($percentage >= 50 ? 'from-yellow-500 to-yellow-600' : 'from-red-500 to-red-600');
                                $textColor = $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600');
                                $delay = $index * 100;
                            @endphp
                            <div class="transition-all transform hover:scale-102">
                                <div class="flex justify-between mb-1 text-sm">
                                    <span class="flex items-center font-medium text-gray-700">
                                        <span class="w-2 h-2 rounded-full bg-gradient-to-r {{ $barColor }} mr-2 animate-pulse"></span>
                                        {{ $matiere['nom'] }}
                                    </span>
                                    <span class="font-semibold {{ $textColor }} animate-count">{{ number_format($matiere['moyenne'], 1) }}/20</span>
                                </div>
                                <div class="relative w-full h-3 overflow-hidden bg-gray-100 rounded-full">
                                    <div class="absolute top-0 left-0 h-full bg-gradient-to-r {{ $barColor }} rounded-full transition-all duration-1000 ease-out"
                                         style="width: 0%"
                                         x-data="{ show: false }"
                                         x-init="setTimeout(() => show = true, {{ $delay }})"
                                         :style="show ? 'width: {{ $percentage }}%' : 'width: 0%'">
                                    </div>
                                </div>
                                <p class="flex items-center mt-1 text-xs text-gray-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    {{ $matiere['nombreNotes'] }} note(s)
                                </p>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="py-8 text-center">
                            <div class="relative inline-block animate-float animation-delay-200">
                                <div class="absolute inset-0 bg-purple-300 rounded-full opacity-50 blur-xl"></div>
                                <svg class="relative w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <p class="mt-4 text-gray-500">Aucune donnée disponible</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Absences récentes avec timeline -->
                <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                    <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-red-600 to-pink-600">
                        <h3 class="flex items-center text-lg font-semibold text-white">
                            <svg class="w-5 h-5 mr-2 animate-shake" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Absences récentes
                        </h3>
                        <a href="{{ route('eleve.absences') }}" class="flex items-center transition-colors text-white/80 hover:text-white group">
                            <span class="text-sm">Voir tout</span>
                            <svg class="w-4 h-4 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="p-6">
                        @php $recentAbsences = $absences->take(3); @endphp
                        @if($recentAbsences->count() > 0)
                        <div class="relative">
                            <!-- Timeline line -->
                            <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                            
                            <div class="space-y-4">
                                @foreach($recentAbsences as $index => $abs)
                                <div class="relative flex items-start space-x-4 animate-slide-left" style="animation-delay: {{ $index * 150 }}ms">
                                    <div class="relative z-10">
                                        <div class="w-10 h-10 rounded-full {{ $abs->justifie ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center shadow-lg transform transition-transform hover:scale-110">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 p-3 rounded-xl {{ $abs->justifie ? 'bg-green-50' : 'bg-red-50' }} transform transition-all hover:scale-102">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($abs->date_absence)->format('d/m/Y') }}</p>
                                                <p class="flex items-center mt-1 text-xs text-gray-600">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                    {{ $abs->matiere->nom ?? 'Matière' }}
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $abs->justifie ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                {{ $abs->justifie ? 'Justifiée' : 'Non justifiée' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @else
                        <div class="py-8 text-center">
                            <div class="relative inline-block animate-float animation-delay-400">
                                <div class="absolute inset-0 bg-green-300 rounded-full opacity-50 blur-xl"></div>
                                <svg class="relative w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="mt-4 text-gray-500">Aucune absence</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Emploi du temps avec design moderne -->
        <div class="overflow-hidden transition-all duration-500 transform bg-white border border-gray-100 shadow-xl rounded-2xl hover:shadow-2xl hover:-translate-y-1">
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600">
                <h3 class="flex items-center text-lg font-semibold text-white">
                    <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Emploi du temps
                </h3>
                <span class="px-4 py-2 text-sm text-white rounded-full bg-white/20 backdrop-blur-sm animate-pulse">
                    {{ now()->startOfWeek()->format('d/m') }} - {{ now()->endOfWeek()->format('d/m/Y') }}
                </span>
            </div>

            <div class="p-6">
                @if($emploiDuTemps->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Jour</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Horaire</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Matière</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Enseignant</th>
                                <th class="px-4 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Salle</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($emploiDuTemps as $index => $edt)
                            <tr class="transition-colors hover:bg-gray-50 animate-slide-up" style="animation-delay: {{ $index * 50 }}ms">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-indigo-700 bg-indigo-100 rounded-full">
                                        <span class="w-2 h-2 mr-2 bg-indigo-600 rounded-full animate-pulse"></span>
                                        {{ $edt->jour }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ substr($edt->heure_debut, 0, 5) }} - {{ substr($edt->heure_fin, 0, 5) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="font-medium text-gray-900">{{ $edt->matiere->nom ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $edt->enseignant->nom ?? '-' }} {{ $edt->enseignant->prenom ?? '' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm text-blue-700 bg-blue-100 rounded-full">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $edt->salle ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="py-12 text-center">
                    <div class="relative inline-block animate-float animation-delay-600">
                        <div class="absolute inset-0 bg-indigo-300 rounded-full opacity-50 blur-xl"></div>
                        <svg class="relative w-20 h-20 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <p class="mt-4 text-lg text-gray-500">Aucune séance planifiée cette semaine</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions rapides avec effets -->
        <div class="grid grid-cols-2 gap-4 mt-8 lg:grid-cols-4">
            <a href="{{ route('eleve.notes') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-500 transform group bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute inset-0 transition-opacity duration-500 bg-white opacity-0 group-hover:opacity-20"></div>
                <div class="absolute transition-opacity duration-500 opacity-0 -inset-1 bg-gradient-to-r from-blue-400 to-blue-500 rounded-2xl blur group-hover:opacity-50"></div>
                <div class="relative">
                    <svg class="w-10 h-10 mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="block text-lg font-semibold">Mes notes</span>
                    <span class="text-sm text-blue-200">Consulter mes notes</span>
                </div>
            </a>
            
            <a href="{{ route('eleve.absences') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-500 transform group bg-gradient-to-br from-red-500 to-red-600 rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute inset-0 transition-opacity duration-500 bg-white opacity-0 group-hover:opacity-20"></div>
                <div class="absolute transition-opacity duration-500 opacity-0 -inset-1 bg-gradient-to-r from-red-400 to-red-500 rounded-2xl blur group-hover:opacity-50"></div>
                <div class="relative">
                    <svg class="w-10 h-10 mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="block text-lg font-semibold">Absences</span>
                    <span class="text-sm text-red-200">Suivre mes absences</span>
                </div>
            </a>
            
            <a href="{{ route('eleve.bulletin') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-500 transform group bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute inset-0 transition-opacity duration-500 bg-white opacity-0 group-hover:opacity-20"></div>
                <div class="absolute transition-opacity duration-500 opacity-0 -inset-1 bg-gradient-to-r from-purple-400 to-purple-500 rounded-2xl blur group-hover:opacity-50"></div>
                <div class="relative">
                    <svg class="w-10 h-10 mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="block text-lg font-semibold">Bulletins</span>
                    <span class="text-sm text-purple-200">Mes bulletins</span>
                </div>
            </a>
            
            <a href="{{ route('eleve.emploi-du-temps') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-500 transform group bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="absolute inset-0 transition-opacity duration-500 bg-white opacity-0 group-hover:opacity-20"></div>
                <div class="absolute transition-opacity duration-500 opacity-0 -inset-1 bg-gradient-to-r from-indigo-400 to-indigo-500 rounded-2xl blur group-hover:opacity-50"></div>
                <div class="relative">
                    <svg class="w-10 h-10 mx-auto mb-3 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="block text-lg font-semibold">Emploi du temps</span>
                    <span class="text-sm text-indigo-200">Mon planning</span>
                </div>
            </a>
        </div>
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

@keyframes slide-up {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-left {
    from {
        opacity: 0;
        transform: translateX(20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slide-right {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes ping-slow {
    75%, 100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
    20%, 40%, 60%, 80% { transform: translateX(2px); }
}

@keyframes count {
    from { opacity: 0; transform: scale(0.5); }
    to { opacity: 1; transform: scale(1); }
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

.animate-slide-up {
    animation: slide-up 0.6s ease-out forwards;
}

.animate-slide-left {
    animation: slide-left 0.6s ease-out forwards;
}

.animate-slide-right {
    animation: slide-right 0.6s ease-out forwards;
}

.animate-ping-slow {
    animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

.animate-count {
    animation: count 0.5s ease-out;
}

.animate-spin-slow {
    animation: spin 3s linear infinite;
}

.animate-bounce-subtle {
    animation: bounce 2s ease-in-out infinite;
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

/* Perspectives 3D */
.perspective {
    perspective: 1000px;
}

.preserve-3d {
    transform-style: preserve-3d;
}

.backface-hidden {
    backface-visibility: hidden;
}

.rotate-y-180 {
    transform: rotateY(180deg);
}

.hover\:rotate-y-180:hover {
    transform: rotateY(180deg);
}

/* Échelle personnalisée */
.hover\:scale-102:hover {
    transform: scale(1.02);
}

/* Délais d'animation personnalisés */
.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
.delay-400 { animation-delay: 400ms; }
.delay-500 { animation-delay: 500ms; }
</style>

<!-- Alpine.js pour les animations dynamiques -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection