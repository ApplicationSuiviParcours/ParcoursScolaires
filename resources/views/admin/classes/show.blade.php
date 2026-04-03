{{-- resources/views/admin/classes/show.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de la Classe') }}
    </h2>
@endsection

@section('content')
<div class="py-6 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-3 md:p-4 rounded-r-lg shadow-md text-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 md:p-4 rounded-r-lg shadow-md text-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- En-tête avec infos classe -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-xl mb-6 md:mb-8 overflow-hidden border border-gray-100">
            <!-- Bannière dégradée -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 px-4 md:px-8 py-4 md:py-6">
                <!-- Éléments décoratifs -->
                <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32"></div>

                <div class="relative flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center space-x-3 md:space-x-4">
                            <div class="bg-white/20 p-2 md:p-3 rounded-lg md:rounded-xl backdrop-blur-sm flex-shrink-0">
                                <svg class="w-6 h-6 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="text-xl md:text-3xl font-bold text-white truncate">{{ $classe->nom }}</h3>
                                    <span class="px-2 py-0.5 bg-white/20 backdrop-blur-sm rounded-full text-white text-[10px] md:text-xs font-semibold">
                                        ID: {{ $classe->id }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 md:gap-4 text-indigo-100 text-xs md:text-sm">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <span class="font-semibold ml-1 text-white">{{ $classe->niveau }}</span>
                                    </span>

                                    @if($classe->serie)
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                            </svg>
                                            Série: <span class="font-semibold ml-1 text-white">{{ $classe->serie }}</span>
                                        </span>
                                    @endif

                                    @if($classe->anneeScolaire)
                                        <span class="flex items-center hidden sm:flex">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $classe->anneeScolaire->nom }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 md:gap-3">
                        <a href="{{ route('admin.classes.pdf', $classe) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 md:py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-lg md:rounded-xl transition-all text-xs font-medium shadow-sm group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                            </svg>
                            PDF
                        </a>

                        <a href="{{ route('admin.classes.edit', $classe) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 md:py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg md:rounded-xl transition-all text-xs font-medium shadow-sm group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Modifier
                        </a>

                        <a href="{{ route('admin.classes.index') }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 md:py-2.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg md:rounded-xl transition-all text-xs font-medium shadow-sm group">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cartes statistiques -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 p-4 md:p-6 bg-gradient-to-br from-gray-50 to-white">
                <!-- Total élèves -->
                <div class="group bg-white rounded-lg md:rounded-xl shadow p-3 md:p-5 border-l-4 border-indigo-500 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase">Total élèves</p>
                            <p class="text-lg md:text-2xl font-bold text-gray-800 mt-1">{{ $inscriptions->count() }}</p>
                        </div>
                        <div class="bg-indigo-100 p-2 md:p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Places disponibles -->
                <div class="group bg-white rounded-lg md:rounded-xl shadow p-3 md:p-5 border-l-4 border-emerald-500 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase">Places dispo.</p>
                            <p class="text-lg md:text-2xl font-bold text-gray-800 mt-1">{{ max(0, $classe->capacite - $inscriptions->count()) }}</p>
                        </div>
                        <div class="bg-emerald-100 p-2 md:p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Taux d'occupation -->
                <div class="group bg-white rounded-lg md:rounded-xl shadow p-3 md:p-5 border-l-4 border-amber-500 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase">Occupation</p>
                            @php $taux = $classe->capacite > 0 ? round(($inscriptions->count() / $classe->capacite) * 100) : 0; @endphp
                            <p class="text-lg md:text-2xl font-bold text-gray-800 mt-1">{{ $taux }}%</p>
                        </div>
                        <div class="bg-amber-100 p-2 md:p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Élèves actifs -->
                <div class="group bg-white rounded-lg md:rounded-xl shadow p-3 md:p-5 border-l-4 border-purple-500 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] md:text-xs font-medium text-gray-500 uppercase">Actifs</p>
                            <p class="text-lg md:text-2xl font-bold text-gray-800 mt-1">{{ $inscriptions->where('statut', true)->count() }}</p>
                        </div>
                        <div class="bg-purple-100 p-2 md:p-3 rounded-lg group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des élèves inscrits -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- En-tête de la section -->
            <div class="bg-gradient-to-r from-gray-50 to-white px-4 md:px-6 py-4 md:py-5 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-2 md:gap-3">
                        <div class="bg-gradient-to-br from-indigo-100 to-indigo-200 p-1.5 md:p-2.5 rounded-lg md:rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-base md:text-lg font-bold text-gray-800">Liste des élèves</h4>
                            <p class="text-xs md:text-sm text-gray-500 hidden sm:block">Inscriptions dans cette classe</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 md:gap-3">
                        @if(Route::has('admin.inscriptions.create'))
                        <a href="{{ route('admin.inscriptions.create', ['classe_id' => $classe->id]) }}"
                           class="w-full sm:w-auto inline-flex items-center justify-center px-3 md:px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-lg md:rounded-xl text-xs font-medium shadow-sm group">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Inscrire
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tableau des élèves -->
            <div class="overflow-x-auto">
                <table class="min-w-full w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase">Photo</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase">Matricule</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase">Nom</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase hidden sm:table-cell">Prénom</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Date naiss.</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Genre</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase hidden lg:table-cell">Téléphone</th>
                            <th class="px-3 md:px-6 py-3 text-left text-[10px] md:text-xs font-semibold text-gray-600 uppercase hidden md:table-cell">Statut</th>
                            <th class="px-3 md:px-6 py-3 text-right text-[10px] md:text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($inscriptions as $inscription)
                            @if($inscription->eleve)
                                <tr class="hover:bg-indigo-50/50 transition-all">
                                    <!-- Photo -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap">
                                        @if($inscription->eleve->photo)
                                            <img class="h-8 w-8 md:h-10 md:w-10 rounded-lg object-cover border"
                                                 src="{{ Storage::url($inscription->eleve->photo) }}"
                                                 alt="{{ $inscription->eleve->prenom }}">
                                        @else
                                            <div class="h-8 w-8 md:h-10 md:w-10 rounded-lg bg-indigo-100 flex items-center justify-center border">
                                                <span class="text-[10px] md:text-xs font-bold text-indigo-700">
                                                    {{ strtoupper(substr($inscription->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($inscription->eleve->nom, 0, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Matricule -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-700 rounded text-[10px] md:text-xs font-mono font-semibold">
                                            {{ $inscription->eleve->matricule ?? '-' }}
                                        </span>
                                    </td>

                                    <!-- Nom -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap">
                                        <div class="text-xs md:text-sm font-semibold text-gray-900">{{ $inscription->eleve->nom ?? '-' }}</div>
                                    </td>

                                    <!-- Prénom -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap hidden sm:table-cell">
                                        <div class="text-xs md:text-sm text-gray-700">{{ $inscription->eleve->prenom ?? '-' }}</div>
                                    </td>

                                    <!-- Date naissance -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap hidden md:table-cell">
                                        <div class="text-xs md:text-sm text-gray-600">
                                            {{ $inscription->eleve->date_naissance ? $inscription->eleve->date_naissance->format('d/m/Y') : '-' }}
                                        </div>
                                    </td>

                                    <!-- Genre -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap hidden lg:table-cell">
                                        @if($inscription->eleve->genre == 'm')
                                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full bg-blue-100 text-blue-800">
                                                M
                                            </span>
                                        @elseif($inscription->eleve->genre == 'f')
                                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full bg-pink-100 text-pink-800">
                                                F
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <!-- Téléphone -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap hidden lg:table-cell">
                                        <div class="text-xs md:text-sm text-gray-600">{{ $inscription->eleve->telephone ?? '-' }}</div>
                                    </td>

                                    <!-- Statut -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap hidden md:table-cell">
                                        @if($inscription->statut)
                                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full bg-green-100 text-green-800">
                                                Actif
                                            </span>
                                        @else
                                            <span class="px-2 py-1 text-[10px] font-semibold rounded-full bg-red-100 text-red-800">
                                                Inactif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-3 md:px-6 py-3 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-1 md:gap-2">
                                            <a href="{{ route('admin.eleves.show', $inscription->eleve) }}"
                                               class="p-1.5 md:p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all"
                                               title="Voir">
                                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>

                                            @if(Route::has('admin.inscriptions.toggle-status'))
                                            <form action="{{ route('admin.inscriptions.toggle-status', $inscription) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="p-1.5 md:p-2 {{ $inscription->statut ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }} rounded-lg transition-all"
                                                        title="{{ $inscription->statut ? 'Désactiver' : 'Activer' }}">
                                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($inscription->statut)
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        @endif
                                                    </svg>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 md:px-6 py-10 md:py-16">
                                    <div class="flex flex-col items-center justify-center text-center">
                                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gray-100 rounded-xl flex items-center justify-center mb-3 md:mb-4">
                                            <svg class="w-8 h-8 md:w-10 md:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="text-base md:text-lg font-bold text-gray-800 mb-1 md:mb-2">Aucun élève inscrit</h4>
                                        <p class="text-gray-500 text-xs md:text-sm mb-4 md:mb-6">Cette classe est vide</p>
                                        @if(Route::has('admin.inscriptions.create'))
                                        <a href="{{ route('admin.inscriptions.create', ['classe_id' => $classe->id]) }}"
                                           class="px-4 md:px-6 py-2 md:py-3 bg-indigo-600 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl shadow">
                                            Inscrire un élève
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pied de tableau -->
            @if($inscriptions->count() > 0)
            <div class="bg-gray-50 px-4 md:px-6 py-3 md:py-4 border-t">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs md:text-sm text-gray-600">
                    <div class="flex items-center">
                        <span>Total: <span class="font-semibold text-indigo-600">{{ $inscriptions->count() }}</span> élève(s)</span>
                    </div>
                    <div>
                        <span class="font-semibold text-green-600">{{ $inscriptions->where('statut', true)->count() }}</span> actif(s) ·
                        <span class="font-semibold text-red-600">{{ $inscriptions->where('statut', false)->count() }}</span> inactif(s)
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
