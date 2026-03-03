@extends('layouts.app')

@section('title', 'Détails de la matière')

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
                            <a href="{{ route('admin.matieres.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Matières
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ $matiere->nom }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    {{ $matiere->nom }}
                </h1>
                <p class="text-blue-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Code: {{ $matiere->code }} • Coefficient: {{ $matiere->coefficient }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.matieres.edit', $matiere) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.matieres.index') }}" 
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
    <!-- Badge d'identité flottant -->
    <div class="relative mb-8">
        <div class="absolute -top-12 right-0">
            <div class="bg-white rounded-full shadow-xl px-6 py-3 flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">Matière :</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700">
                    {{ $matiere->code }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                    Coef. {{ $matiere->coefficient }}
                </span>
            </div>
        </div>
    </div>

    <!-- Cartes d'information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Carte Informations générales -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Informations générales</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                        {{ substr($matiere->nom, 0, 2) }}
                    </div>
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $matiere->nom }}</h2>
                        <div class="flex items-center space-x-2 mt-1">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">{{ $matiere->code }}</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-sm font-medium rounded-full">Coefficient {{ $matiere->coefficient }}</span>
                        </div>
                    </div>
                </div>

                @if($matiere->description)
                <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $matiere->description }}</p>
                </div>
                @endif

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-500">Créé le</p>
                        <p class="font-medium text-gray-800">{{ $matiere->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-500">Modifié le</p>
                        <p class="font-medium text-gray-800">{{ $matiere->updated_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Statistiques -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Statistiques</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Évaluations</p>
                                <p class="text-xl font-bold text-gray-800">{{ $stats['total_evaluations'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-lg">+{{ $stats['total_evaluations'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Absences</p>
                                <p class="text-xl font-bold text-gray-800">{{ $stats['total_absences'] }}</p>
                            </div>
                        </div>
                        <span class="text-sm text-orange-600 bg-orange-100 px-2 py-1 rounded-lg">{{ $stats['total_absences'] }}</span>
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
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Enseignants</p>
                                <p class="text-xl font-bold text-gray-800">{{ $stats['total_enseignants'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Performance -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Performance</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Moyenne générale -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-600">Moyenne générale</span>
                            <span class="text-lg font-bold {{ $stats['moyenne_notes'] >= 10 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $stats['moyenne_notes'] }}/20
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-3 rounded-full" 
                                 style="width: {{ ($stats['moyenne_notes'] / 20) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Notes min/max -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-red-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-red-600 mb-1">Note minimum</p>
                            <p class="text-2xl font-bold text-red-700">{{ $stats['note_min'] }}</p>
                            <p class="text-xs text-red-500">/20</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <p class="text-xs text-green-600 mb-1">Note maximum</p>
                            <p class="text-2xl font-bold text-green-700">{{ $stats['note_max'] }}</p>
                            <p class="text-xs text-green-500">/20</p>
                        </div>
                    </div>

                    <!-- Heures de cours -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Heures de cours</p>
                                <p class="text-xl font-bold text-gray-800">{{ $stats['total_heures_cours'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sections avec onglets -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="border-b border-gray-200" x-data="{ tab: 'classes' }">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button @click="tab = 'classes'" 
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'classes', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'classes' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                    </svg>
                    Classes associées ({{ $stats['total_classes'] }})
                </button>
                <button @click="tab = 'enseignants'" 
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'enseignants', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'enseignants' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Enseignants ({{ $stats['total_enseignants'] }})
                </button>
                <button @click="tab = 'evaluations'" 
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'evaluations', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'evaluations' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Dernières évaluations
                </button>
                <button @click="tab = 'absences'" 
                        :class="{ 'border-indigo-500 text-indigo-600': tab === 'absences', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'absences' }"
                        class="py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Dernières absences
                </button>
            </nav>

            <div class="p-6">
                <!-- Classes associées -->
                <div x-show="tab === 'classes'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                    @if($classes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($classes as $classe)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($classe->nom, 0, 2) }}
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-bold text-gray-800">{{ $classe->nom }}</h4>
                                            <p class="text-xs text-gray-500">Niveau {{ $classe->niveau ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Aucune classe associée à cette matière</p>
                    @endif
                </div>

                <!-- Enseignants -->
                <div x-show="tab === 'enseignants'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                    @if($enseignants->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($enseignants as $enseignant)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($enseignant->prenom, 0, 1) }}{{ substr($enseignant->nom, 0, 1) }}
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="font-bold text-gray-800">{{ $enseignant->prenom }} {{ $enseignant->nom }}</h4>
                                            <p class="text-xs text-gray-500">{{ $enseignant->specialite ?? 'Enseignant' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Aucun enseignant associé à cette matière</p>
                    @endif
                </div>

                <!-- Dernières évaluations -->
                <div x-show="tab === 'evaluations'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                    @if($matiere->evaluations->count() > 0)
                        <div class="space-y-3">
                            @foreach($matiere->evaluations as $evaluation)
                                <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $evaluation->titre }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $evaluation->classe->nom ?? 'N/A' }} • 
                                                {{ $evaluation->date_evaluation->format('d/m/Y') }} •
                                                {{ $evaluation->notes_count ?? 0 }} notes
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
                        <p class="text-gray-500 text-center py-8">Aucune évaluation pour cette matière</p>
                    @endif
                </div>

                <!-- Dernières absences -->
                <div x-show="tab === 'absences'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100">
                    @if($matiere->absences->count() > 0)
                        <div class="space-y-3">
                            @foreach($matiere->absences as $absence)
                                <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">{{ $absence->eleve->prenom ?? '' }} {{ $absence->eleve->nom ?? '' }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $absence->classe->nom ?? 'N/A' }} • 
                                                {{ $absence->date_absence->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <span class="px-3 py-1 {{ $absence->justifiee ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs font-medium rounded-full">
                                            {{ $absence->justifiee ? 'Justifiée' : 'Non justifiée' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">Aucune absence pour cette matière</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions supplémentaires -->
    <div class="flex justify-end space-x-4">
        <button onclick="window.print()" 
                class="group px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
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
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }
    
    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
    }
    
    .animation-delay-200 {
        animation-delay: 200ms;
        opacity: 0;
    }
</style>
@endpush