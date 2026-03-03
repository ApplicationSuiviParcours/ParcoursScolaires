@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Tableau de bord Enseignant') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Message de bienvenue amélioré -->
        <div class="relative overflow-hidden mb-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl transform hover:scale-[1.02] transition-all duration-500">
            <!-- Motifs de fond -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute w-64 h-64 bg-white rounded-full -top-24 -right-24 blur-3xl animate-pulse"></div>
                <div class="absolute w-64 h-64 delay-1000 bg-yellow-300 rounded-full -bottom-24 -left-24 blur-3xl animate-pulse"></div>
            </div>
            
            <div class="relative p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center space-x-6">
                        <!-- Avatar enseignant -->
                        <div class="relative group">
                            <div class="flex items-center justify-center w-24 h-24 transition-all duration-300 transform shadow-2xl bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl group-hover:rotate-6">
                                <span class="text-4xl font-bold text-white">
                                    {{ substr($enseignant->prenom ?? 'E', 0, 1) }}{{ substr($enseignant->nom ?? 'N', 0, 1) }}
                                </span>
                            </div>
                            <div class="absolute w-6 h-6 bg-green-400 border-4 border-indigo-600 rounded-full -bottom-2 -right-2 animate-pulse"></div>
                        </div>
                        
                        <div class="space-y-2">
                            <h1 class="text-4xl font-bold text-white">
                                Bonjour, {{ $enseignant->prenom ?? $enseignant->user->name ?? 'Enseignant' }} !
                            </h1>
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="inline-flex items-center px-4 py-2 text-white border bg-white/20 backdrop-blur-sm rounded-xl border-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Enseignant
                                </span>
                                <span class="inline-flex items-center px-4 py-2 text-white border bg-white/20 backdrop-blur-sm rounded-xl border-white/30">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ now()->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Stats rapides -->
                    <div class="flex gap-4 mt-6 md:mt-0">
                        <div class="min-w-[140px] p-4 bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 transform hover:scale-105 transition-all">
                            <p class="text-sm text-white/80">Classes</p>
                            <p class="text-3xl font-bold text-white">{{ $classesCount }}</p>
                        </div>
                        <div class="min-w-[140px] p-4 bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 transform hover:scale-105 transition-all">
                            <p class="text-sm text-white/80">Évaluations</p>
                            <p class="text-3xl font-bold text-white">{{ $evaluationsCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques Cards améliorées -->
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
            <!-- Classes -->
            <div class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center justify-center transition-transform shadow-lg w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl group-hover:scale-110">
                            <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">Actives</span>
                    </div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Mes Classes</p>
                    <p class="mb-2 text-4xl font-bold text-gray-900">{{ $classesCount }}</p>
                </div>
            </div>

            <!-- Évaluations -->
            <div class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center justify-center transition-transform shadow-lg w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl group-hover:scale-110">
                            <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold text-green-600 bg-green-100 rounded-full">Total</span>
                    </div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Évaluations</p>
                    <p class="mb-2 text-4xl font-bold text-gray-900">{{ $evaluationsCount }}</p>
                </div>
            </div>

            <!-- À venir -->
            <div class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center justify-center transition-transform shadow-lg w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl group-hover:scale-110">
                            <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold text-yellow-600 bg-yellow-100 rounded-full">Prévues</span>
                    </div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Évaluations à venir</p>
                    <p class="mb-2 text-4xl font-bold text-gray-900">{{ $evaluationsAVenir }}</p>
                </div>
            </div>

            <!-- Absences -->
            <div class="overflow-hidden transition-all duration-300 transform bg-white shadow-lg group rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center justify-center transition-transform shadow-lg w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl group-hover:scale-110">
                            <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold text-red-600 bg-red-100 rounded-full">Aujourd'hui</span>
                    </div>
                    <p class="mb-1 text-sm font-medium text-gray-500">Absences</p>
                    <p class="mb-2 text-4xl font-bold text-gray-900">{{ $absencesCount }}</p>
                </div>
            </div>
        </div>

        <!-- Section Performance et Dernières évaluations -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-3">
            <!-- Dernières évaluations -->
            <div class="overflow-hidden transition-all bg-white shadow-lg lg:col-span-2 rounded-2xl hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                    <div class="flex items-center justify-between">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Dernières évaluations
                        </h3>
                        <a href="{{ route('enseignant.evaluations.index') }}" class="text-sm text-white/80 hover:text-white">
                            Voir tout
                            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @if($dernieresEvaluations->count() > 0)
                    <div class="space-y-4">
                        @foreach($dernieresEvaluations as $evaluation)
                        @php
                            $dateEval = \Carbon\Carbon::parse($evaluation->date_evaluation);
                            $statut = $dateEval->isToday() ? 'Aujourd\'hui' : ($dateEval->isFuture() ? 'À venir' : 'Passée');
                            $couleurStatut = $dateEval->isToday() ? 'yellow' : ($dateEval->isFuture() ? 'green' : 'gray');
                        @endphp
                        <div class="flex items-center justify-between p-4 transition-all bg-gray-50 rounded-xl hover:bg-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-{{ $couleurStatut }}-500 to-{{ $couleurStatut }}-600 rounded-lg flex items-center justify-center text-white font-bold">
                                    {{ $dateEval->format('d') }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $evaluation->nom }}</p>
                                    <div class="flex items-center mt-1 space-x-2 text-sm text-gray-500">
                                        <span>{{ $evaluation->classe->nom ?? '-' }}</span>
                                        <span>•</span>
                                        <span>{{ $evaluation->matiere->nom ?? '-' }}</span>
                                        <span>•</span>
                                        <span>Coeff. {{ $evaluation->coefficient }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="px-3 py-1 text-xs font-semibold bg-{{ $couleurStatut }}-100 text-{{ $couleurStatut }}-800 rounded-full">
                                    {{ $statut }}
                                </span>
                                <a href="{{ route('enseignant.evaluations.show', $evaluation->id) }}" 
                                   class="p-2 text-blue-600 bg-blue-100 rounded-lg hover:bg-blue-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="py-12 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <p class="text-lg text-gray-500">Aucune évaluation</p>
                        <a href="{{ route('enseignant.evaluations.create') }}" class="inline-block px-4 py-2 mt-4 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                            Créer une évaluation
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Performance par matière -->
            <div class="overflow-hidden transition-all bg-white shadow-lg rounded-2xl hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-600">
                    <h3 class="flex items-center text-lg font-bold text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Performance par matière
                    </h3>
                </div>

                <div class="p-6">
                    @php
                        // Simuler des données de performance (à remplacer par vos données réelles)
                        $matieresPerformances = [
                            ['nom' => 'Mathématiques', 'moyenne' => 14.5, 'notes' => 24],
                            ['nom' => 'Français', 'moyenne' => 12.8, 'notes' => 18],
                            ['nom' => 'Anglais', 'moyenne' => 15.2, 'notes' => 22],
                            ['nom' => 'Physique', 'moyenne' => 13.1, 'notes' => 16],
                            ['nom' => 'SVT', 'moyenne' => 16.3, 'notes' => 20],
                        ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($matieresPerformances as $matiere)
                        @php
                            $pourcentage = ($matiere['moyenne'] / 20) * 100;
                            $couleur = $pourcentage >= 75 ? 'green' : ($pourcentage >= 50 ? 'yellow' : 'red');
                        @endphp
                        <div class="p-3 transition-all group hover:bg-gray-50 rounded-xl">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="font-semibold text-gray-800">{{ $matiere['nom'] }}</span>
                                    <span class="ml-2 text-xs text-gray-500">({{ $matiere['notes'] }} notes)</span>
                                </div>
                                <span class="text-lg font-bold {{ $couleur == 'green' ? 'text-green-600' : ($couleur == 'yellow' ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ number_format($matiere['moyenne'], 1) }}/20
                                </span>
                            </div>
                            <div class="relative w-full h-3 overflow-hidden bg-gray-100 rounded-full">
                                <div class="absolute top-0 left-0 h-full transition-all duration-500 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 group-hover:from-blue-600 group-hover:to-indigo-700" 
                                     style="width: {{ $pourcentage }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Notes et Absences récentes -->
        <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
            <!-- Dernières notes saisies -->
            <div class="overflow-hidden transition-all bg-white shadow-lg rounded-2xl hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-green-600 to-emerald-600">
                    <div class="flex items-center justify-between">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Dernières notes saisies
                        </h3>
                        <a href="{{ route('enseignant.notes.index') }}" class="text-sm text-white/80 hover:text-white">
                            Voir tout
                            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @php
                        // Simuler des notes récentes (à remplacer par vos données réelles)
                        $notesRecentes = [
                            ['eleve' => 'Jean Dupont', 'matiere' => 'Mathématiques', 'note' => 16.5, 'date' => '15/02/2024'],
                            ['eleve' => 'Marie Martin', 'matiere' => 'Français', 'note' => 14, 'date' => '15/02/2024'],
                            ['eleve' => 'Pierre Durand', 'matiere' => 'Anglais', 'note' => 12.5, 'date' => '14/02/2024'],
                            ['eleve' => 'Sophie Leroy', 'matiere' => 'Physique', 'note' => 18, 'date' => '14/02/2024'],
                            ['eleve' => 'Lucas Petit', 'matiere' => 'SVT', 'note' => 15.5, 'date' => '13/02/2024'],
                        ];
                    @endphp

                    <div class="space-y-3">
                        @foreach($notesRecentes as $note)
                        @php
                            $couleurNote = $note['note'] >= 16 ? 'green' : ($note['note'] >= 14 ? 'blue' : ($note['note'] >= 10 ? 'yellow' : 'red'));
                        @endphp
                        <div class="flex items-center justify-between p-4 transition-all bg-gray-50 rounded-xl hover:bg-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-{{ $couleurNote }}-500 to-{{ $couleurNote }}-600 flex items-center justify-center text-white font-bold">
                                    {{ $note['note'] }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $note['eleve'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $note['matiere'] }} • {{ $note['date'] }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-sm font-bold bg-{{ $couleurNote }}-100 text-{{ $couleurNote }}-700 rounded-full">
                                {{ number_format($note['note'], 1) }}/20
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Absences récentes -->
            <div class="overflow-hidden transition-all bg-white shadow-lg rounded-2xl hover:shadow-xl">
                <div class="p-6 bg-gradient-to-r from-red-600 to-pink-600">
                    <div class="flex items-center justify-between">
                        <h3 class="flex items-center text-lg font-bold text-white">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Absences récentes
                        </h3>
                        <a href="{{ route('enseignant.absences.index') }}" class="text-sm text-white/80 hover:text-white">
                            Voir tout
                            <svg class="inline w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    @php
                        // Simuler des absences récentes (à remplacer par vos données réelles)
                        $absencesRecentes = [
                            ['eleve' => 'Jean Dupont', 'matiere' => 'Mathématiques', 'date' => '15/02/2024', 'justifiee' => false],
                            ['eleve' => 'Marie Martin', 'matiere' => 'Français', 'date' => '15/02/2024', 'justifiee' => true],
                            ['eleve' => 'Pierre Durand', 'matiere' => 'Anglais', 'date' => '14/02/2024', 'justifiee' => false],
                            ['eleve' => 'Sophie Leroy', 'matiere' => 'Physique', 'date' => '14/02/2024', 'justifiee' => false],
                            ['eleve' => 'Lucas Petit', 'matiere' => 'SVT', 'date' => '13/02/2024', 'justifiee' => true],
                        ];
                    @endphp

                    <div class="space-y-3">
                        @foreach($absencesRecentes as $abs)
                        <div class="flex items-center justify-between p-4 transition-all {{ $abs['justifiee'] ? 'bg-green-50' : 'bg-red-50' }} rounded-xl hover:bg-opacity-70">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-lg {{ $abs['justifiee'] ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $abs['eleve'] }}</p>
                                    <p class="text-xs text-gray-600">{{ $abs['matiere'] }} • {{ $abs['date'] }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold {{ $abs['justifiee'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }} rounded-full">
                                {{ $abs['justifiee'] ? 'Justifiée' : 'Non justifiée' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Emploi du temps -->
        <div class="overflow-hidden transition-all bg-white shadow-lg rounded-2xl hover:shadow-xl">
            <div class="p-6 bg-gradient-to-r from-purple-600 to-indigo-600">
                <div class="flex items-center justify-between">
                    <h3 class="flex items-center text-lg font-bold text-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Emploi du temps de la semaine
                    </h3>
                    <span class="px-3 py-1 text-sm text-white rounded-full bg-white/20">
                        {{ now()->startOfWeek()->format('d/m') }} - {{ now()->endOfWeek()->format('d/m/Y') }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                @php
                    // Simuler un emploi du temps (à remplacer par vos données réelles)
                    $emploiDuTemps = [
                        ['jour' => 'Lundi', 'matiere' => 'Mathématiques', 'classe' => '3ème A', 'heure' => '08:00 - 10:00', 'salle' => '101'],
                        ['jour' => 'Lundi', 'matiere' => 'Physique', 'classe' => '3ème B', 'heure' => '10:00 - 12:00', 'salle' => '102'],
                        ['jour' => 'Mardi', 'matiere' => 'Mathématiques', 'classe' => '3ème C', 'heure' => '08:00 - 10:00', 'salle' => '103'],
                        ['jour' => 'Mercredi', 'matiere' => 'SVT', 'classe' => '3ème A', 'heure' => '09:00 - 11:00', 'salle' => '104'],
                        ['jour' => 'Jeudi', 'matiere' => 'Mathématiques', 'classe' => '3ème B', 'heure' => '13:00 - 15:00', 'salle' => '101'],
                        ['jour' => 'Vendredi', 'matiere' => 'Physique', 'classe' => '3ème C', 'heure' => '08:00 - 10:00', 'salle' => '102'],
                    ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Jour</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Horaire</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Matière</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Classe</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Salle</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($emploiDuTemps as $cours)
                            <tr class="transition-colors hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium text-purple-800 bg-purple-100 rounded-full">
                                        {{ $cours['jour'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $cours['heure'] }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $cours['matiere'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $cours['classe'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 text-sm text-blue-800 bg-blue-100 rounded-full">
                                        {{ $cours['salle'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="grid grid-cols-1 gap-4 mt-8 md:grid-cols-4">
            <a href="{{ route('enseignant.classes') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-300 transform group bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10"></div>
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <span class="block text-lg font-semibold">Mes Classes</span>
                <span class="text-sm text-blue-200">Voir mes classes</span>
            </a>
            
            <a href="{{ route('enseignant.evaluations.index') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-300 transform group bg-gradient-to-br from-green-600 to-green-700 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10"></div>
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="block text-lg font-semibold">Évaluations</span>
                <span class="text-sm text-green-200">Créer / Gérer</span>
            </a>
            
            <a href="{{ route('enseignant.notes.index') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-300 transform group bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10"></div>
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="block text-lg font-semibold">Saisir Notes</span>
                <span class="text-sm text-purple-200">Ajouter des notes</span>
            </a>
            
            <a href="{{ route('enseignant.absences.index') }}" 
               class="relative p-6 overflow-hidden text-center text-white transition-all duration-300 transform group bg-gradient-to-br from-red-600 to-red-700 rounded-2xl hover:shadow-2xl hover:-translate-y-1">
                <div class="absolute inset-0 transition-opacity bg-white opacity-0 group-hover:opacity-10"></div>
                <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="block text-lg font-semibold">Absences</span>
                <span class="text-sm text-red-200">Signaler</span>
            </a>
        </div>
    </div>
</div>

<style>
/* Animations personnalisées */
@keyframes pulse {
    0%, 100% { opacity: 0.6; }
    50% { opacity: 1; }
}

.animate-pulse {
    animation: pulse 2s ease-in-out infinite;
}

/* Transitions fluides */
.hover\:scale-105:hover {
    transform: scale(1.05);
}

.hover\:shadow-2xl:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endsection