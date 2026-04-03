@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
        {{ __('Gestion des Inscriptions') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                // Solution temporaire : récupérer les données si elles ne sont pas fournies par le contrôleur
                if (!isset($classes) || !$classes) {
                    $classes = App\Models\Classe::orderBy('nom')->get();
                }
                if (!isset($anneesScolaires) || !$anneesScolaires) {
                    $anneesScolaires = App\Models\AnneeScolaire::orderBy('nom', 'desc')->get();
                }
            @endphp

            <!-- Messages de succès -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-md text-sm" role="alert">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="p-1 hover:bg-green-200 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Statistiques rapides -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-green-100 rounded-full">
                            <svg class="w-5 h-5 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Total</p>
                            <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $inscriptions->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-blue-100 rounded-full">
                            <svg class="w-5 h-5 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Classes</p>
                            <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $classes->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-yellow-100 rounded-full">
                            <svg class="w-5 h-5 sm:w-8 sm:h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Actives</p>
                            <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $inscriptions->where('statut', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-2 sm:p-3 bg-purple-100 rounded-full">
                            <svg class="w-5 h-5 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 sm:ml-4">
                            <p class="text-xs sm:text-sm font-medium text-gray-500">Années</p>
                            <p class="text-lg sm:text-2xl font-semibold text-gray-900">{{ $anneesScolaires->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- En-tête avec filtres -->
            <div class="bg-white rounded-xl shadow-lg mb-6 overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-green-600 to-emerald-700 px-4 sm:px-6 py-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-filter backdrop-blur-lg">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-white">Liste des inscriptions</h3>
                                <p class="text-green-100 text-xs sm:text-sm hidden sm:block">Gérez toutes les inscriptions des élèves</p>
                            </div>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button onclick="resetFilters()" class="inline-flex items-center px-3 sm:px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg transition duration-200 text-xs sm:text-sm font-medium">
                                <svg class="w-4 h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Réinitialiser
                            </button>
                            <a href="{{ route('admin.inscriptions.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 bg-white text-green-600 hover:bg-green-50 rounded-lg font-semibold text-xs sm:text-sm transition duration-200 shadow-lg">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Nouveau
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filtres avancés -->
                <div class="p-4 sm:p-6 bg-gray-50 border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.inscriptions.index') }}" id="filter-form" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Classe</label>
                            <div class="relative">
                                <select name="classe_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2 text-xs sm:text-sm">
                                    <option value="">Toutes les classes</option>
                                    @forelse($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Aucune classe</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Année scolaire</label>
                            <div class="relative">
                                <select name="annee_scolaire_id" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2 text-xs sm:text-sm">
                                    <option value="">Toutes les années</option>
                                    @forelse($anneesScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Aucune année</option>
                                    @endforelse
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Statut</label>
                            <div class="relative">
                                <select name="statut" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 appearance-none bg-white pl-3 pr-10 py-2 text-xs sm:text-sm">
                                    <option value="">Tous</option>
                                    <option value="1" {{ request('statut') === '1' ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ request('statut') === '0' ? 'selected' : '' }}>Inactif</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 font-medium text-xs sm:text-sm">
                                Filtrer
                            </button>
                            <a href="{{ route('admin.inscriptions.index') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition duration-200 text-xs sm:text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Résultats de la recherche -->
                <div class="px-4 sm:px-6 py-3 bg-white border-b border-gray-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                    <p class="text-xs sm:text-sm text-gray-600">
                        <span class="font-medium">{{ $inscriptions->firstItem() ?? 0 }}</span> - 
                        <span class="font-medium">{{ $inscriptions->lastItem() ?? 0 }}</span> sur 
                        <span class="font-medium">{{ $inscriptions->total() }}</span>
                    </p>
                    <div class="flex items-center space-x-2">
                        <span class="text-xs text-gray-500 hidden sm:inline">Trier par:</span>
                        <select class="text-xs border-gray-300 rounded-lg focus:border-green-500 py-1 px-2">
                            <option>Date récente</option>
                            <option>Nom élève</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tableau des inscriptions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase">Élève</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase">Classe</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Année</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden sm:table-cell">Date</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase">Statut</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Observation</th>
                                <th class="px-3 sm:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($inscriptions as $inscription)
                                <tr class="hover:bg-green-50 transition-colors duration-200 group">
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-md">
                                                <span class="text-white font-semibold text-xs sm:text-sm">
                                                    {{ substr($inscription->eleve->prenom ?? 'N', 0, 1) }}{{ substr($inscription->eleve->nom ?? 'A', 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-2 sm:ml-4">
                                                <div class="text-xs sm:text-sm font-semibold text-gray-900">
                                                    {{ $inscription->eleve->nom ?? 'N/A' }} {{ $inscription->eleve->prenom ?? '' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $inscription->eleve->matricule ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $inscription->classe->nom ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500 hidden sm:block">{{ $inscription->classe->niveau ?? '' }}</div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden md:table-cell">
                                        <div class="text-xs sm:text-sm text-gray-900">{{ $inscription->anneeScolaire->nom ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap hidden sm:table-cell">
                                        <div class="text-xs sm:text-sm text-gray-900">{{ $inscription->date_inscription ? \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') : 'N/A' }}</div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap">
                                        <span class="px-2 sm:px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $inscription->statut ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $inscription->statut ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 hidden lg:table-cell">
                                        <div class="text-xs sm:text-sm text-gray-500 max-w-xs truncate">
                                            {{ Str::limit($inscription->observation, 20) ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center justify-end gap-1 md:gap-2 whitespace-nowrap">
                                            <a href="{{ route('admin.inscriptions.show', $inscription) }}" class="p-1.5 md:p-2 text-blue-600 bg-transparent hover:bg-blue-50 rounded-lg transition-colors border-none" title="Voir">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <a href="{{ route('admin.inscriptions.edit', $inscription) }}" class="p-1.5 md:p-2 text-amber-600 bg-transparent hover:bg-amber-50 rounded-lg transition-colors border-none" title="Modifier">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.inscriptions.toggle-status', $inscription) }}" method="POST" class="inline toggle-status-form m-0 p-0">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-1.5 md:p-2 {{ $inscription->statut ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }} bg-transparent rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer toggle-status-btn" title="{{ $inscription->statut ? 'Désactiver' : 'Activer' }}">
                                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($inscription->statut)
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        @endif
                                                    </svg>
                                                </button>
                                            </form>
                                            <button type="button" class="p-1.5 md:p-2 text-red-600 bg-transparent hover:bg-red-50 rounded-lg transition-colors border-none flex items-center justify-center cursor-pointer" title="Supprimer" onclick="confirmDelete({{ $inscription->id }})">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $inscription->id }}" action="{{ route('admin.inscriptions.destroy', $inscription) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-base sm:text-xl font-medium text-gray-500 mb-2">Aucune inscription trouvée</p>
                                            <p class="text-xs sm:text-sm text-gray-400 mb-6">Créez une nouvelle inscription ou ajustez vos filtres</p>
                                            <div class="flex flex-col sm:flex-row gap-3">
                                                <button onclick="resetFilters()" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium">
                                                    Réinitialiser
                                                </button>
                                                <a href="{{ route('admin.inscriptions.create') }}" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium shadow-lg">
                                                    Nouvelle inscription
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($inscriptions->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-xs sm:text-sm text-gray-600 order-2 sm:order-1">
                                Affichage de <span class="font-medium">{{ $inscriptions->firstItem() }}</span> à <span class="font-medium">{{ $inscriptions->lastItem() }}</span>
                            </div>

                            <div class="order-1 sm:order-2">
                                {{ $inscriptions->links() }}
                            </div>

                            <div class="flex items-center space-x-2 order-3">
                                <select id="per-page" class="text-xs sm:text-sm border-gray-300 rounded-lg py-1 px-2">
                                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                </select>
                                <span class="text-xs sm:text-sm text-gray-600">/ page</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 bg-gray-50 text-center text-xs sm:text-sm text-gray-600">
                        <span class="font-medium">{{ $inscriptions->total() }}</span> inscription(s) au total
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        function resetFilters() {
            window.location.href = "{{ route('admin.inscriptions.index') }}";
        }

        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('[role="alert"]');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            }

            document.getElementById('per-page')?.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                window.location.href = url.toString();
            });
        });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Pagination styling */
            .pagination { display: flex; gap: 0.25rem; flex-wrap: wrap; justify-content: center; }
            .pagination .page-item { display: inline-block; }
            .pagination .page-link {
                padding: 0.4rem 0.75rem; border-radius: 0.5rem; background-color: white;
                color: #374151; font-weight: 500; transition: all 0.2s; border: 1px solid #e5e7eb;
                font-size: 0.75rem; /* smaller font for pagination */
            }
            .pagination .page-link:hover { background-color: #f3f4f6; border-color: #10b981; }
            .pagination .active .page-link { background-color: #10b981; color: white; border-color: #10b981; }
            
            /* Responsive text size adjustments if needed */
            @media (max-width: 640px) {
                .pagination .page-link { padding: 0.3rem 0.5rem; }
            }
        </style>
    @endpush

@endsection