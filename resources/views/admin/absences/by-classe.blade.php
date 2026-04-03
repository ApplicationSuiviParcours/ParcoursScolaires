@extends('layouts.app')

@section('title', 'Absences par classe')

@section('header')
    <div class="relative overflow-hidden bg-gradient-to-br from-teal-600 via-teal-700 to-cyan-800 py-8 md:py-12">
        <!-- Éléments décoratifs animés -->
        <div class="absolute inset-0 opacity-10">
            <div
                class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000">
            </div>
        </div>

        <!-- Particules flottantes (masquées sur mobile) -->
        <div class="absolute inset-0 overflow-hidden hidden sm:block">
            @for($i = 1; $i <= 4; $i++)
                <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                    style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
            @endfor
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.absences.index') }}"
                                    class="inline-flex items-center text-sm font-medium text-teal-200 hover:text-white transition-colors duration-300">
                                    <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    <span class="hidden sm:inline">Absences</span>
                                    <span class="sm:hidden">Liste</span>
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 md:w-6 md:h-6 text-teal-300" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-white md:ml-2">Par classe</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                        Récapitulatif
                    </h1>
                    <p class="text-teal-200 text-sm md:text-base animate-fade-in-up animation-delay-200">
                        Statistiques d'absences par classe
                    </p>
                </div>
                <div class="flex justify-center md:justify-end animate-fade-in-right">
                    <a href="{{ route('admin.absences.index') }}"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20 text-sm">
                        <svg class="w-5 h-5 sm:mr-2 transform group-hover:-translate-x-1 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Retour à la liste</span>
                        <span class="sm:hidden">Retour</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Vague décorative -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z">
                </path>
            </svg>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">
        <!-- Formulaire de sélection -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden mb-6 md:mb-8">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Sélection</h2>
                        <p class="text-teal-100 text-xs md:text-sm">Classe et année scolaire</p>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <form method="GET" action="{{ route('admin.absences.byClasse') }}"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <div class="group">
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Classe *</label>
                        <select name="classe_id"
                            class="w-full rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-4 py-2.5 md:py-3 text-sm md:text-base"
                            required>
                            <option value="">Sélectionner</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ $classeId == $classe->id ? 'selected' : '' }}>
                                    {{ $classe->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="group">
                        <label class="block text-xs md:text-sm font-semibold text-gray-700 mb-1 md:mb-2">Année scolaire
                            *</label>
                        <select name="annee_scolaire_id"
                            class="w-full rounded-xl border-2 border-gray-200 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 px-4 py-2.5 md:py-3 text-sm md:text-base"
                            required>
                            <option value="">Sélectionner</option>
                            @foreach($anneeScolaires as $annee)
                                <option value="{{ $annee->id }}" {{ $anneeScolaireId == $annee->id ? 'selected' : '' }}>
                                    {{ $annee->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-3 sm:col-span-2 lg:col-span-1">
                        <a href="{{ route('admin.absences.byClasse') }}"
                            class="flex-1 sm:flex-none text-center px-4 py-2.5 md:py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm font-medium">
                            Reinitialiser
                        </a>
                        <button type="submit"
                            class="flex-1 px-4 py-2.5 md:py-3 bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 text-sm md:text-base">
                            Afficher
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($classeId && $anneeScolaireId && isset($eleves) && $eleves->isNotEmpty())
            <!-- Statistiques globales -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                <div
                    class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-teal-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase">Total élèves</p>
                            <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total_eleves'] }}</p>
                        </div>
                        <div class="bg-teal-100 rounded-lg md:rounded-xl p-2 md:p-3">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-teal-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-orange-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase">Total absences</p>
                            <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['total_absences'] }}</p>
                        </div>
                        <div class="bg-orange-100 rounded-lg md:rounded-xl p-2 md:p-3">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase">Moyenne/élève</p>
                            <p class="text-xl md:text-3xl font-bold text-gray-800">{{ $stats['moyenne_par_eleve'] }}</p>
                        </div>
                        <div class="bg-blue-100 rounded-lg md:rounded-xl p-2 md:p-3">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase">Taux justif.</p>
                            <p class="text-xl md:text-3xl font-bold text-green-600">{{ $stats['taux_justification'] }}%</p>
                        </div>
                        <div class="bg-green-100 rounded-lg md:rounded-xl p-2 md:p-3">
                            <svg class="w-5 h-5 md:w-8 md:h-8 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des absences par élève -->
            <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-4 md:px-8 py-4 md:py-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 bg-white/10 backdrop-blur-lg rounded-lg md:rounded-xl flex items-center justify-center mr-3 md:mr-4">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-lg md:text-xl font-bold text-white">Détail par élève</h2>
                        </div>
                        <span
                            class="px-3 py-1 md:px-4 md:py-2 bg-white/10 backdrop-blur-lg text-white rounded-lg md:rounded-xl text-xs md:text-sm font-medium">
                            {{ $eleves->count() }} él.
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-3 md:px-6 py-3 md:py-4 text-left text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    Élève</th>
                                <th
                                    class="px-3 md:px-6 py-3 md:py-4 text-center text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[60px]">
                                    Total</th>
                                <th
                                    class="hidden sm:table-cell px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Justifiées</th>
                                <th
                                    class="hidden sm:table-cell px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Non justifiées</th>
                                <th
                                    class="px-3 md:px-6 py-3 md:py-4 text-center text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[80px]">
                                    Taux</th>
                                <th
                                    class="px-3 md:px-6 py-3 md:py-4 text-center text-[10px] md:text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($eleves as $eleve)
                                @php
                                    $total = $absencesParEleve[$eleve->id]['total'] ?? 0;
                                    $justifiees = $absencesParEleve[$eleve->id]['justifiees'] ?? 0;
                                    $nonJustifiees = $absencesParEleve[$eleve->id]['non_justifiees'] ?? 0;
                                    $taux = $total > 0 ? round(($justifiees / $total) * 100, 1) : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-3 md:px-6 py-3 md:py-4 sticky left-0 bg-white z-10">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 md:h-10 md:w-10 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-lg flex items-center justify-center text-white font-bold text-sm md:text-lg shadow">
                                                {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                            </div>
                                            <div class="ml-2 md:ml-4 min-w-0">
                                                <div class="text-xs md:text-sm font-semibold text-gray-900 truncate">
                                                    {{ $eleve->nom }} {{ $eleve->prenom }}
                                                </div>
                                                <div class="text-[10px] md:text-xs text-gray-500 hidden sm:block">
                                                    {{ $eleve->matricule ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                                        <span class="text-sm md:text-lg font-bold text-gray-800">{{ $total }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell px-6 py-4 text-center">
                                        <span class="text-base md:text-lg font-bold text-green-600">{{ $justifiees }}</span>
                                    </td>
                                    <td class="hidden sm:table-cell px-6 py-4 text-center">
                                        <span class="text-base md:text-lg font-bold text-red-600">{{ $nonJustifiees }}</span>
                                    </td>
                                    <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <div class="relative w-10 h-10 md:w-16 md:h-16">
                                                <svg class="w-10 h-10 md:w-16 md:h-16 transform -rotate-90">
                                                    <circle cx="20" cy="20" r="9" md:cx="32" md:cy="32" md:r="14"
                                                        stroke="currentColor" stroke-width="3" md:stroke-width="4" fill="none"
                                                        class="text-gray-200" />
                                                    <circle cx="20" cy="20" r="9" md:cx="32" md:cy="32" md:r="14"
                                                        stroke="currentColor" stroke-width="3" md:stroke-width="4" fill="none"
                                                        stroke-dasharray="{{ 2 * 3.14 * 9 }}"
                                                        md:stroke-dasharray="{{ 2 * 3.14 * 14 }}"
                                                        stroke-dashoffset="{{ 2 * 3.14 * 9 * (1 - $taux / 100) }}"
                                                        class="text-teal-500 transition-all duration-500"
                                                        style="stroke-linecap: round;" />
                                                </svg>
                                                <span
                                                    class="absolute inset-0 flex items-center justify-center text-[9px] md:text-xs font-bold {{ $taux >= 50 ? 'text-green-600' : 'text-orange-600' }}">
                                                    {{ $taux }}%
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 md:px-6 py-3 md:py-4 text-center">
                                        <a href="{{ route('admin.absences.by-eleve', $eleve) }}?annee_scolaire_id={{ $anneeScolaireId }}"
                                            class="inline-flex items-center px-2 py-1 md:px-3 md:py-2 bg-teal-100 text-teal-700 rounded-lg md:rounded-xl hover:bg-teal-600 hover:text-white transition-all duration-300 transform hover:scale-105 text-[10px] md:text-sm">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 sm:mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <span class="hidden sm:inline">Détails</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($classeId && $anneeScolaireId && isset($eleves) && $eleves->isEmpty())
            <div class="bg-yellow-50 rounded-2xl md:rounded-3xl p-8 md:p-12 text-center">
                <svg class="w-12 h-12 md:w-16 md:h-16 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                <h3 class="text-lg md:text-xl font-bold text-yellow-800 mb-2">Aucun élève trouvé</h3>
                <p class="text-yellow-600 text-sm md:text-base">Aucun élève inscrit pour cette sélection.</p>
            </div>
        @endif
    </div>
@endsection