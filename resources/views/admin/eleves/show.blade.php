@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de l\'élève') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Messages flash -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-lg animate-slide-down" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow-lg animate-slide-down" role="alert">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- En-tête de navigation -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('admin.eleves.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600 transition-colors group">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste des élèves
                </a>

                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">Dernière mise à jour :</span>
                    <span class="text-sm font-medium text-gray-700">{{ $eleve->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <!-- En-tête du profil -->
            <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-bold text-white">{{ $eleve->nom }} {{ $eleve->prenom }}</h3>
                                <div class="flex items-center mt-1">
                                    <span class="text-indigo-200 text-sm">Matricule :</span>
                                    <span class="ml-2 px-2 py-0.5 bg-indigo-500 text-white text-xs font-mono font-medium rounded">{{ $eleve->matricule }}</span>
                                    <span class="ml-3 px-2 py-0.5 rounded-full text-xs font-medium {{ $eleve->statut ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $eleve->statut ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.eleves.edit', $eleve) }}" 
                               class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 text-sm font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier
                            </a>

                            <!-- MODIFICATION: Vérifier les inscriptions avant suppression -->
                            @if($eleve->inscriptions->count() == 0)
                                <form action="{{ route('admin.eleves.destroy', $eleve) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-indigo-600 text-sm font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            @endif

                            @if(!$eleve->user)
                                <form action="{{ route('admin.eleves.create-user', $eleve) }}" method="POST" class="inline" id="create-user-form-{{ $eleve->id }}">
                                    @csrf
                                    <input type="hidden" name="password" value="password123">
                                    <input type="hidden" name="password_confirmation" value="password123">
                                    <button type="button" 
                                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-indigo-600 text-sm font-medium rounded-lg transition-colors create-user-btn"
                                            data-form-id="create-user-form-{{ $eleve->id }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Créer un compte
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille principale -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Colonne principale (2/3) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Carte Informations personnelles -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Informations personnelles</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Matricule</p>
                                            <p class="mt-1 text-base font-mono font-medium text-gray-900">{{ $eleve->matricule }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Nom</p>
                                            <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->nom }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Prénom</p>
                                            <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->prenom }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Genre</p>
                                            <p class="mt-1 text-base font-medium text-gray-900">
                                                {{ $eleve->genre === 'm' ? 'Masculin' : 'Féminin' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date de naissance</p>
                                            <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->date_naissance->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-50 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Lieu de naissance</p>
                                            <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->lieu_naissance }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Coordonnées -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                                <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Téléphone</p>
                                        <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->telephone ?? 'Non renseigné' }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</p>
                                        <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->email ?? 'Non renseigné' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex items-start bg-gray-50 p-3 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Adresse</p>
                                        <p class="mt-1 text-base font-medium text-gray-900">{{ $eleve->adresse }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Inscriptions (MODIFIÉE) -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Historique des inscriptions</h3>
                                </div>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    Total : {{ $eleve->inscriptions->count() }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($eleve->inscriptions->count() > 0)
                                @php
                                    $inscriptionActive = $eleve->inscriptions->firstWhere('statut', true);
                                @endphp

                                @if($inscriptionActive)
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Inscription active</p>
                                            <p class="text-sm text-gray-700">
                                                <span class="font-semibold">{{ $inscriptionActive->classe->nom ?? 'Classe non définie' }}</span>
                                                @if($inscriptionActive->classe && $inscriptionActive->classe->niveau)
                                                    ({{ $inscriptionActive->classe->niveau }})
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Depuis le {{ $inscriptionActive->date_inscription->format('d/m/Y') }}
                                                @if($inscriptionActive->anneeScolaire)
                                                    - {{ $inscriptionActive->anneeScolaire->nom }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Année scolaire</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date d'inscription</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Observation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($eleve->inscriptions as $inscription)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        <span class="px-2 py-1 {{ $inscription->statut ? 'bg-green-50 text-green-700 border-green-200' : 'bg-indigo-50 text-indigo-700 border-indigo-200' }} rounded-lg border">
                                                            {{ $inscription->classe->nom ?? 'Non définie' }}
                                                            @if($inscription->classe && $inscription->classe->niveau)
                                                                <span class="ml-1 text-xs">({{ $inscription->classe->niveau }})</span>
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $inscription->anneeScolaire->nom ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $inscription->date_inscription->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm">
                                                        @if($inscription->statut)
                                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full border border-green-200">Active</span>
                                                        @else
                                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full border border-gray-200">Ancienne</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                                        {{ $inscription->observation ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucune inscription trouvée</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Absences -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Dernières absences</h3>
                                </div>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    Total : {{ $stats['total_absences'] ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            @if(isset($eleve->absences) && $eleve->absences->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Matière</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Période</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statut</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Motif</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($eleve->absences as $absence)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $absence->date_absence->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        {{ $absence->matiere->nom ?? 'Non définie' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        @if($absence->heure_debut && $absence->heure_fin)
                                                            {{ \Carbon\Carbon::parse($absence->heure_debut)->format('H:i') }} - 
                                                            {{ \Carbon\Carbon::parse($absence->heure_fin)->format('H:i') }}
                                                        @else
                                                            1h
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm">
                                                        @if($absence->justifiee)
                                                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full border border-green-200">
                                                                Justifiée
                                                            </span>
                                                        @else
                                                            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full border border-red-200">
                                                                Non justifiée
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                                        {{ $absence->motif ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucune absence enregistrée</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Notes -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Dernières notes</h3>
                                </div>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    Total : {{ $stats['notes_count'] ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            @if(isset($eleve->notes) && $eleve->notes->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Évaluation</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Note</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Observation</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($eleve->notes as $note)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        {{ $note->evaluation->nom ?? 'Non définie' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm">
                                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 font-semibold rounded-full">
                                                            {{ number_format($note->note, 2) }}/20
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600 max-w-xs truncate">
                                                        {{ $note->observation ?? '-' }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $note->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucune note enregistrée</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Bulletins -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Bulletins</h3>
                                </div>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    Total : {{ $stats['bulletins_count'] ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            @if(isset($eleve->bulletins) && $eleve->bulletins->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Classe</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Année scolaire</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Période</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Moyenne</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Rang</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($eleve->bulletins as $bulletin)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-200">
                                                            {{ $bulletin->classe->nom ?? 'Non définie' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $bulletin->anneeScolaire->nom ?? $bulletin->annee_scolaire_id }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $bulletin->periode }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm">
                                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 font-semibold rounded-full">
                                                            {{ number_format($bulletin->moyenne_generale, 2) }}/20
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        {{ $bulletin->rang }} / {{ $bulletin->effectif_classe }}
                                                    </td>
                                                    <td class="px-4 py-3 text-sm text-gray-600">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                            {{ $bulletin->date_bulletin->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @if($bulletin->appreciation)
                                                    <tr class="bg-gray-50">
                                                        <td colspan="6" class="px-4 py-2 text-sm text-gray-600 italic">
                                                            <span class="font-semibold">Appréciation :</span> "{{ $bulletin->appreciation }}"
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucun bulletin disponible</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne latérale (1/3) -->
                <div class="space-y-6">
                    <!-- Carte Photo -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Photo</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($eleve->photo)
                                <div class="flex justify-center">
                                    <img src="{{ Storage::url($eleve->photo) }}" alt="{{ $eleve->prenom }}" class="w-48 h-48 object-cover rounded-lg border-4 border-gray-200 shadow-md">
                                </div>
                            @else
                                <div class="flex justify-center">
                                    <div class="w-48 h-48 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center border-4 border-indigo-100 shadow-md">
                                        <span class="text-6xl font-bold text-indigo-400">
                                            {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-center text-sm text-gray-500 mt-4">Aucune photo disponible</p>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Parents -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="ml-3 text-lg font-semibold text-gray-800">Parents / Tuteurs</h3>
                                </div>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">
                                    {{ $stats['parents_count'] ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            @if(isset($eleve->parents) && $eleve->parents->count() > 0)
                                <div class="space-y-4">
                                    @foreach($eleve->parents as $parent)
                                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                                            <div class="flex items-start">
                                                <div class="bg-indigo-100 p-2 rounded-full mr-3">
                                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-900">{{ $parent->nom }} {{ $parent->prenom }}</p>
                                                    @if($parent->pivot && $parent->pivot->lien_parental)
                                                        <p class="text-xs text-indigo-600 mt-1">Lien: {{ $parent->pivot->lien_parental }}</p>
                                                    @endif
                                                    <p class="text-sm text-gray-600 flex items-center mt-1">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                        </svg>
                                                        {{ $parent->telephone ?? 'Téléphone non renseigné' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucun parent associé</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Compte utilisateur -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Compte utilisateur</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            @if($eleve->user)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Compte actif</p>
                                            <p class="text-xs text-gray-600 mt-1">Email: {{ $eleve->user->email }}</p>
                                            <p class="text-xs text-gray-600">Rôle: {{ $eleve->user->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Aucun compte utilisateur</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Carte Statistiques -->
                    <div class="bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden">
                        <div class="border-b border-gray-200 px-6 py-4 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="ml-3 text-lg font-semibold text-gray-800">Statistiques</h3>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-indigo-600">{{ $stats['inscriptions_count'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Inscriptions</p>
                                </div>
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-indigo-600">{{ $stats['parents_count'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Parents</p>
                                </div>
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_absences'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Total absences</p>
                                </div>
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-green-600">{{ $stats['absences_justifiees'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Justifiées</p>
                                </div>
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-red-600">{{ $stats['absences_non_justifiees'] ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Non justifiées</p>
                                </div>
                                <div class="bg-gray-50 p-3 text-center border border-gray-200 rounded-lg">
                                    <p class="text-2xl font-bold text-indigo-600">{{ isset($stats['moyenne_generale']) && $stats['moyenne_generale'] ? number_format($stats['moyenne_generale'], 2) : 'N/A' }}</p>
                                    <p class="text-xs text-gray-600 uppercase tracking-wider mt-1">Moyenne</p>
                                </div>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Date d'inscription</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $eleve->date_inscription->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Âge</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $eleve->date_naissance->age }} ans</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Bulletins</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $stats['bulletins_count'] ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Notes</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $stats['notes_count'] ?? 0 }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Classe actuelle</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        @php
                                            $inscriptionActive = $eleve->inscriptions->firstWhere('statut', true);
                                            $classeActuelle = $inscriptionActive ? $inscriptionActive->classe : null;
                                        @endphp
                                        {{ $classeActuelle ? $classeActuelle->nom . ($classeActuelle->niveau ? ' (' . $classeActuelle->niveau . ')' : '') : 'Non assigné' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirmation de suppression avec SweetAlert2
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Êtes-vous sûr ?',
                        text: "Cette action est irréversible ! L'élève sera définitivement supprimé.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler',
                        background: '#ffffff',
                        backdrop: `rgba(0,0,0,0.4)`
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });

            // Confirmation pour la création de compte utilisateur
            const createUserBtns = document.querySelectorAll('.create-user-btn');
            createUserBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const formId = this.dataset.formId;
                    
                    Swal.fire({
                        title: 'Créer un compte utilisateur',
                        text: 'Un compte sera créé avec le mot de passe par défaut "password123". Voulez-vous continuer ?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Oui, créer',
                        cancelButtonText: 'Annuler',
                        background: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(formId).submit();
                        }
                    });
                });
            });
        });
        </script>
    @endpush
@endsection