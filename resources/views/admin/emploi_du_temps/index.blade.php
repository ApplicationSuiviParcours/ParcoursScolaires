@extends('layouts.app')

@section('title', 'Emplois du temps')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl shadow-lg flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Emplois du temps</h1>
            </div>
            <!-- Boutons : wrappés sur mobile, en ligne sur sm+ -->
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.emploi_du_temps.byClasse') }}"
                   class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-3 bg-green-100 text-green-700 font-medium rounded-xl hover:bg-green-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Par classe
                </a>
                <a href="{{ route('admin.emploi_du_temps.byEnseignant') }}"
                   class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-3 bg-purple-100 text-purple-700 font-medium rounded-xl hover:bg-purple-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Par enseignant
                </a>
                <a href="{{ route('admin.emploi_du_temps.create') }}"
                   class="inline-flex items-center px-4 py-2 sm:px-6 sm:py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 text-sm">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouveau cours
                </a>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="mb-8 animate__animated animate__fadeInUp">
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl p-4 sm:p-6 border border-white/20">
                <form method="GET" class="space-y-4">
                    <!-- 1 col mobile → 2 col sm → 2 col md → 4 col lg (boutons en 5e colonne lg) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                        <!-- Classe -->
                        <div class="space-y-2">
                            <label for="classe_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Classe</span>
                                </span>
                            </label>
                            <select name="classe_id" id="classe_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Toutes les classes</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ ($classeId ?? '') == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Enseignant -->
                        <div class="space-y-2">
                            <label for="enseignant_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Enseignant</span>
                                </span>
                            </label>
                            <select name="enseignant_id" id="enseignant_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Tous les enseignants</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ ($enseignantId ?? '') == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Année scolaire -->
                        <div class="space-y-2">
                            <label for="annee_scolaire_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Année scolaire</span>
                                </span>
                            </label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Toutes les années</option>
                                @foreach($anneeScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ ($anneeScolaireId ?? '') == $annee->id ? 'selected' : ($annee->active ? 'selected' : '') }}>
                                        {{ $annee->nom }} {{ $annee->active ? '(En cours)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jour -->
                        <div class="space-y-2">
                            <label for="jour" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Jour</span>
                                </span>
                            </label>
                            <select name="jour" id="jour" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Tous les jours</option>
                                <option value="1" {{ ($jour ?? '') == '1' ? 'selected' : '' }}>Lundi</option>
                                <option value="2" {{ ($jour ?? '') == '2' ? 'selected' : '' }}>Mardi</option>
                                <option value="3" {{ ($jour ?? '') == '3' ? 'selected' : '' }}>Mercredi</option>
                                <option value="4" {{ ($jour ?? '') == '4' ? 'selected' : '' }}>Jeudi</option>
                                <option value="5" {{ ($jour ?? '') == '5' ? 'selected' : '' }}>Vendredi</option>
                                <option value="6" {{ ($jour ?? '') == '6' ? 'selected' : '' }}>Samedi</option>
                                <option value="7" {{ ($jour ?? '') == '7' ? 'selected' : '' }}>Dimanche</option>
                            </select>
                        </div>

                        <!-- Boutons filtre : pleine largeur sur sm, alignés en bas sur lg -->
                        <div class="flex items-end sm:col-span-2 lg:col-span-1">
                            <div class="flex flex-wrap gap-2 w-full">
                                <button type="submit"
                                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Filtrer
                                </button>
                                <a href="{{ route('admin.emploi_du_temps.index') }}"
                                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-all duration-300 text-sm">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Réinitialiser
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Statistiques : 2 colonnes mobile → 4 colonnes md+ -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-8 animate__animated animate__fadeInUp">
            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Total cours</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $emplois->count() }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Classes</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $emplois->groupBy('classe_id')->count() }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Enseignants</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $emplois->groupBy('enseignant_id')->count() }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-lg rounded-xl shadow-lg p-4 sm:p-6 border border-white/20 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Jours actifs</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-800">{{ $emplois->groupBy('jour')->count() }}</p>
                    </div>
                    <div class="p-2 sm:p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des emplois du temps -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/80 px-4 sm:px-6 py-4 border-b border-gray-200">
                <h2 class="text-base sm:text-lg font-semibold text-gray-700">Liste des cours</h2>
            </div>

            <!-- TABLEAU — visible sur lg+ -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Jour</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Horaire</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Classe</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Matière</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Enseignant</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Salle</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($emplois as $emploi)
                            @php
                                $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                                $jourIndex = intval($emploi->jour);
                                $jourFr = $jours[$jourIndex - 1] ?? $emploi->jour;
                                $debut = \Carbon\Carbon::parse($emploi->heure_debut);
                                $fin   = \Carbon\Carbon::parse($emploi->heure_fin);
                            @endphp
                            <tr class="hover:bg-white/60 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-medium text-gray-900">{{ $jourFr }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-sm font-medium">{{ $debut->format('H:i') }}</span>
                                        <span class="text-gray-400">-</span>
                                        <span class="text-sm font-medium">{{ $fin->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $emploi->classe->nom ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $emploi->matiere->nom ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($emploi->enseignant)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2 flex-shrink-0">
                                                {{ substr($emploi->enseignant->nom, 0, 1) }}{{ substr($emploi->enseignant->prenom, 0, 1) }}
                                            </div>
                                            <span class="text-sm">{{ $emploi->enseignant->nom }} {{ $emploi->enseignant->prenom }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($emploi->salle)
                                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">{{ $emploi->salle }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-3 md:px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                        <a href="{{ route('admin.emploi_du_temps.show', $emploi) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none flex-shrink-0" title="Voir">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.emploi_du_temps.edit', $emploi) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none flex-shrink-0" title="Modifier">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.emploi_du_temps.destroy', $emploi) }}" method="POST" class="inline m-0 p-0 delete-form flex-shrink-0" onsubmit="return confirm('Supprimer ce cours ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer">
                                                <svg class="w-4 h-4 md:w-5 md:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="mt-2 text-gray-500 text-lg">Aucun cours trouvé</p>
                                        <p class="text-gray-400 text-sm">Modifiez vos filtres ou créez un nouveau cours</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- CARTES — visible sur mobile/tablet (< lg) -->
            <div class="lg:hidden divide-y divide-gray-200">
                @forelse($emplois as $emploi)
                    @php
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
                        $jourIndex = intval($emploi->jour);
                        $jourFr = $jours[$jourIndex - 1] ?? $emploi->jour;
                        $debut = \Carbon\Carbon::parse($emploi->heure_debut);
                        $fin   = \Carbon\Carbon::parse($emploi->heure_fin);
                    @endphp
                    <div class="p-4 hover:bg-white/60 transition-colors duration-300">
                        <!-- Ligne 1 : Jour + horaire + classe -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-gray-900">{{ $jourFr }}</span>
                                    <span class="text-sm text-gray-500">
                                        {{ $debut->format('H:i') }} – {{ $fin->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        {{ $emploi->classe->nom ?? '-' }}
                                    </span>
                                    @if($emploi->salle)
                                        <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">
                                            Salle : {{ $emploi->salle }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Actions -->
                            <div class="flex items-center space-x-1.5 flex-shrink-0 ml-2">
                                <a href="{{ route('admin.emploi_du_temps.show', $emploi) }}"
                                   class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition-all duration-300" title="Voir">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.emploi_du_temps.edit', $emploi) }}"
                                   class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition-all duration-300" title="Modifier">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.emploi_du_temps.destroy', $emploi) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-all duration-300" title="Supprimer"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Ligne 2 : Matière + Enseignant -->
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Matière</p>
                                <p class="text-gray-900 font-medium">{{ $emploi->matiere->nom ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Enseignant</p>
                                @if($emploi->enseignant)
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 flex-shrink-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($emploi->enseignant->nom, 0, 1) }}{{ substr($emploi->enseignant->prenom, 0, 1) }}
                                        </div>
                                        <span class="text-gray-900 truncate">{{ $emploi->enseignant->nom }} {{ $emploi->enseignant->prenom }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-gray-500 text-lg">Aucun cours trouvé</p>
                            <p class="text-gray-400 text-sm">Modifiez vos filtres ou créez un nouveau cours</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@push('styles')
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate__animated   { animation-duration: 0.6s; animation-fill-mode: both; }
    .animate__fadeInDown { animation-name: fadeInDown; }
    .animate__fadeInUp   { animation-name: fadeInUp; }
</style>
@endpush
@endsection