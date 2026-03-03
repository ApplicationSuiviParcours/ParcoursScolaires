@extends('layouts.app')

@section('title', 'Tableau des notes par classe')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-green-700 to-teal-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center text-sm font-medium text-green-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Notes
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Tableau par classe</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Tableau des notes par classe
                </h1>
                <p class="text-green-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Visualisez et gérez les notes par classe et par évaluation
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.notes.import') }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12"></path>
                    </svg>
                    Importer
                </a>
                <a href="{{ route('admin.notes.index') }}" 
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

    <!-- Messages de notification -->
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8" onclick="this.parentElement.parentElement.remove()">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-in-down" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" onclick="this.parentElement.parentElement.remove()">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <!-- Formulaire de sélection -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-8 py-6">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-5">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">Sélectionner une classe</h2>
                    <p class="text-green-100 text-sm">Choisissez la classe, l'année scolaire et la période</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <form method="GET" action="{{ route('admin.notes.by-classe') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">Classe *</label>
                    <select name="classe_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 px-4 py-3" required>
                        <option value="">Sélectionner une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">Année scolaire *</label>
                    <select name="annee_scolaire_id" class="w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 px-4 py-3" required>
                        <option value="">Sélectionner une année</option>
                        @foreach($anneeScolaires as $annee)
                            <option value="{{ $annee->id }}" {{ $anneeScolaireId == $annee->id ? 'selected' : '' }}>
                                {{ $annee->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">Période</label>
                    <select name="periode" class="w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 px-4 py-3">
                        <option value="Trimestre 1" {{ $periode == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                        <option value="Trimestre 2" {{ $periode == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                        <option value="Trimestre 3" {{ $periode == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                        <option value="Semestre 1" {{ $periode == 'Semestre 1' ? 'selected' : '' }}>Semestre 1</option>
                        <option value="Semestre 2" {{ $periode == 'Semestre 2' ? 'selected' : '' }}>Semestre 2</option>
                    </select>
                </div>

                <div class="group">
                    <label class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">Type d'évaluation</label>
                    <select name="type_evaluation" class="w-full rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 px-4 py-3">
                        <option value="">Tous les types</option>
                        @foreach($typesEvaluation as $type)
                            <option value="{{ $type }}" {{ $typeEvaluation == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-4 flex justify-end space-x-4">
                    <a href="{{ route('admin.notes.by-classe') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300">
                        Réinitialiser
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Afficher
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($classeId && $anneeScolaireId && $eleves->isNotEmpty())
        <!-- Statistiques de la classe -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @foreach($stats as $matiereId => $stat)
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-800">{{ $stat['matiere']->nom }}</h3>
                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                            {{ $stat['count'] }} notes
                        </span>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Moyenne</span>
                            <span class="font-bold {{ $stat['moyenne'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($stat['moyenne'], 2) }}/20
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Min - Max</span>
                            <span class="font-medium">{{ number_format($stat['min'], 2) }} - {{ number_format($stat['max'], 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Réussites</span>
                            <span class="font-medium text-green-600">{{ $stat['reussites'] }}/{{ $stat['count'] }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            @php $pourcentage = $stat['count'] > 0 ? ($stat['reussites'] / $stat['count']) * 100 : 0; @endphp
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $pourcentage }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tableau des notes -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-8 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">Tableau des notes</h2>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="px-4 py-2 bg-white/10 backdrop-blur-lg text-white rounded-xl text-sm font-medium">
                            {{ $eleves->count() }} élève(s)
                        </span>
                        <span class="px-4 py-2 bg-white/10 backdrop-blur-lg text-white rounded-xl text-sm font-medium">
                            {{ $evaluations->count() }} évaluation(s)
                        </span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto p-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">Élève</th>
                            @foreach($evaluations as $evaluation)
                                <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">
                                    <div>{{ $evaluation->matiere->code ?? '' }}</div>
                                    <div class="text-[10px] text-gray-400">{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m') }}</div>
                                    <div class="text-[9px] text-gray-400">{{ $evaluation->type }}</div>
                                </th>
                            @endforeach
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($eleves as $eleve)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white group-hover:bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xs shadow-lg">
                                            {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                        </div>
                                        <div class="ml-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $eleve->nom }} {{ $eleve->prenom }}</div>
                                        </div>
                                    </div>
                                </td>
                                @foreach($evaluations as $evaluation)
                                    <td class="px-3 py-3 text-center">
                                        @php
                                            $note = $notesMatrice[$eleve->id][$evaluation->id] ?? null;
                                        @endphp
                                        @if($note)
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold {{ $note->note >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ number_format($note->note, 1) }}
                                            </span>
                                        @else
                                            <span class="text-gray-300 text-xs">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center bg-blue-50">
                                    @php
                                        $notesEleve = collect();
                                        foreach($evaluations as $evaluation) {
                                            if(isset($notesMatrice[$eleve->id][$evaluation->id])) {
                                                $notesEleve->push($notesMatrice[$eleve->id][$evaluation->id]->note);
                                            }
                                        }
                                        $moyenne = $notesEleve->isNotEmpty() ? $notesEleve->avg() : 0;
                                    @endphp
                                    <span class="inline-flex items-center justify-center w-12 h-8 rounded-lg text-sm font-bold {{ $moyenne >= 10 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ number_format($moyenne, 1) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($classeId && $anneeScolaireId && $eleves->isEmpty())
        <div class="bg-yellow-50 rounded-3xl p-12 text-center">
            <svg class="w-16 h-16 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <h3 class="text-xl font-bold text-yellow-800 mb-2">Aucun élève trouvé</h3>
            <p class="text-yellow-600">Aucun élève n'est inscrit dans cette classe pour l'année sélectionnée.</p>
        </div>
    @endif
</div>
@endsection