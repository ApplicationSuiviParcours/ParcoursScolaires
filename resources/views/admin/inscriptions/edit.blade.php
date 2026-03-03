@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modifier l\'inscription') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Fil d'Ariane -->
            <div class="mb-6">
                <nav class="flex items-center text-sm text-gray-500">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-600 transition-colors">Dashboard</a>
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.inscriptions.index') }}"
                        class="hover:text-yellow-600 transition-colors">Inscriptions</a>
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <a href="{{ route('admin.inscriptions.show', $inscription) }}"
                        class="hover:text-yellow-600 transition-colors">Détails</a>
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">Modification</span>
                </nav>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Formulaire principal -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                        <div class="bg-gradient-to-r from-yellow-500 to-amber-600 px-6 py-5">
                            <div class="flex items-center">
                                <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-filter backdrop-blur-lg mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Modification de l'inscription</h3>
                                    <p class="text-yellow-100 text-sm">Modifiez les informations de l'inscription</p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('admin.inscriptions.update', $inscription) }}" method="POST" class="p-6"
                            id="edit-form">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Informations principales -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Élève -->
                                    <div class="space-y-1">
                                        <label for="eleve_id" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Élève <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select name="eleve_id" id="eleve_id"
                                                class="block w-full pl-10 pr-10 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all appearance-none bg-white @error('eleve_id') border-red-500 ring-red-500 @enderror"
                                                required>
                                                <option value="" class="text-gray-500">Sélectionnez un élève</option>
                                                @foreach($eleves as $eleve)
                                                    <option value="{{ $eleve->id }}" {{ old('eleve_id', $inscription->eleve_id) == $eleve->id ? 'selected' : '' }} class="py-2">
                                                        {{ $eleve->nom }} {{ $eleve->prenom }}
                                                        ({{ $eleve->matricule ?? 'N/A' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('eleve_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Classe -->
                                    <div class="space-y-1">
                                        <label for="classe_id" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                                Classe <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select name="classe_id" id="classe_id"
                                                class="block w-full pl-10 pr-10 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all appearance-none bg-white @error('classe_id') border-red-500 ring-red-500 @enderror"
                                                required>
                                                <option value="" class="text-gray-500">Sélectionnez une classe</option>
                                                @foreach($classes as $classe)
                                                    <option value="{{ $classe->id }}" {{ old('classe_id', $inscription->classe_id) == $classe->id ? 'selected' : '' }} class="py-2">
                                                        {{ $classe->nom }}
                                                        ({{ $classe->niveau }}{{ $classe->serie ? ' - ' . $classe->serie : '' }})
                                                        - Capacité: {{ $classe->capacite }} places
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('classe_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Année scolaire -->
                                    <div class="space-y-1">
                                        <label for="annee_scolaire_id" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Année scolaire <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <select name="annee_scolaire_id" id="annee_scolaire_id"
                                                class="block w-full pl-10 pr-10 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all appearance-none bg-white @error('annee_scolaire_id') border-red-500 ring-red-500 @enderror"
                                                required>
                                                @foreach($anneesScolaires as $annee)
                                                    <option value="{{ $annee->id }}" {{ old('annee_scolaire_id', $inscription->annee_scolaire_id) == $annee->id ? 'selected' : '' }}
                                                        class="py-2">
                                                        {{ $annee->nom }} @if($annee->statut)
                                                            <span class="text-green-600 font-medium">(Active)</span>
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('annee_scolaire_id')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Date d'inscription -->
                                    <div class="space-y-1">
                                        <label for="date_inscription" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Date d'inscription <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="date" name="date_inscription" id="date_inscription"
                                                value="{{ old('date_inscription', $inscription->date_inscription->format('Y-m-d')) }}"
                                                class="block w-full pl-10 pr-3 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all @error('date_inscription') border-red-500 ring-red-500 @enderror"
                                                required>
                                        </div>
                                        @error('date_inscription')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Statut -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-1">
                                        <label for="statut" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Statut
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <select name="statut" id="statut"
                                                class="block w-full pl-10 pr-10 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all appearance-none bg-white">
                                                <option value="1" {{ old('statut', $inscription->statut) == '1' ? 'selected' : '' }} class="py-2">Actif</option>
                                                <option value="0" {{ old('statut', $inscription->statut) == '0' ? 'selected' : '' }} class="py-2">Inactif</option>
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Observation -->
                                <div class="space-y-1">
                                    <label for="observation" class="block text-sm font-semibold text-gray-700">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-yellow-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                                </path>
                                            </svg>
                                            Observation
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <textarea name="observation" id="observation" rows="4"
                                            class="block w-full px-4 py-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition-all @error('observation') border-red-500 ring-red-500 @enderror"
                                            placeholder="Ajoutez une observation si nécessaire...">{{ old('observation', $inscription->observation) }}</textarea>
                                    </div>
                                    @error('observation')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Message d'alerte pour les vérifications -->
                            <div id="eligibility-message" class="mt-6 hidden transition-all duration-300"></div>

                            <!-- Boutons d'action -->
                            <div class="mt-8 flex items-center justify-end space-x-4">
                                <a href="{{ route('admin.inscriptions.show', $inscription) }}"
                                    class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Annuler
                                </a>
                                <button type="submit" id="submit-btn"
                                    class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-white rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 shadow-lg hover:shadow-xl flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar avec informations -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Carte d'information sur l'inscription -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Informations
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">ID Inscription</span>
                                    <span class="text-sm font-semibold text-gray-900">#{{ $inscription->id }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Date de création</span>
                                    <span
                                        class="text-sm font-semibold text-gray-900">{{ $inscription->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">Dernière modification</span>
                                    <span
                                        class="text-sm font-semibold text-gray-900">{{ $inscription->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="pt-4 border-t border-gray-200">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-600">
                                            <strong class="text-gray-800">Règle importante :</strong> Un élève ne peut être
                                            inscrit qu'une seule fois par année scolaire.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carte des actions rapides -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <h4 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Actions rapides
                            </h4>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('admin.inscriptions.show', $inscription) }}"
                                    class="flex items-center p-3 text-sm text-gray-700 hover:bg-blue-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Voir les détails
                                </a>
                                <a href="{{ route('admin.inscriptions.index') }}"
                                    class="flex items-center p-3 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                    Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Carte d'aide -->
                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-6 border border-yellow-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-semibold text-yellow-800">Besoin d'aide ?</h3>
                                <p class="mt-2 text-sm text-yellow-700">
                                    La modification peut affecter les statistiques. Vérifiez que l'élève n'est pas déjà
                                    inscrit ailleurs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Zone de danger (suppression) -->
            <div class="mt-6 bg-white rounded-xl shadow-lg overflow-hidden border border-red-200">
                <div class="bg-gradient-to-r from-red-50 to-red-100 px-6 py-4 border-b border-red-200">
                    <h4 class="text-lg font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        Zone de danger
                    </h4>
                </div>
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-700 font-medium">Supprimer cette inscription</p>
                                <p class="text-sm text-gray-500 mt-1">Une fois supprimée, cette inscription ne pourra pas
                                    être récupérée. Toutes les données associées seront perdues.</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.inscriptions.destroy', $inscription) }}" method="POST"
                            onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer cette inscription ? Cette action est irréversible.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 shadow-md hover:shadow-xl flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Supprimer définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const eleveSelect = document.getElementById('eleve_id');
                const classeSelect = document.getElementById('classe_id');
                const anneeSelect = document.getElementById('annee_scolaire_id');
                const submitBtn = document.getElementById('submit-btn');
                const messageDiv = document.getElementById('eligibility-message');
                const form = document.getElementById('edit-form');
                const inscriptionId = {{ $inscription->id }};

                // Animation des champs au focus
                const inputs = document.querySelectorAll('input, select, textarea');
                inputs.forEach(input => {
                    input.addEventListener('focus', function () {
                        this.classList.add('ring-2', 'ring-yellow-500', 'border-transparent');
                    });
                    input.addEventListener('blur', function () {
                        this.classList.remove('ring-2', 'ring-yellow-500', 'border-transparent');
                    });
                });

                function checkEligibility() {
                    const eleveId = eleveSelect.value;
                    const classeId = classeSelect.value;
                    const anneeId = anneeSelect.value;

                    if (eleveId && classeId && anneeId) {
                        // Afficher un message de chargement
                        messageDiv.classList.remove('hidden', 'bg-red-100', 'bg-green-100', 'bg-yellow-100');
                        messageDiv.classList.add('bg-yellow-100', 'text-yellow-700', 'p-4', 'rounded-lg', 'border-l-4', 'border-yellow-500');
                        messageDiv.innerHTML = '<div class="flex items-center"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Vérification en cours...</div>';

                        fetch('{{ route("admin.inscriptions.check-eligibility") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                eleve_id: eleveId,
                                classe_id: classeId,
                                annee_scolaire_id: anneeId,
                                inscription_id: inscriptionId
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                messageDiv.classList.remove('hidden', 'bg-red-100', 'bg-green-100', 'bg-yellow-100');

                                if (data.deja_inscrit_annee) {
                                    messageDiv.classList.add('bg-red-100', 'text-red-700', 'p-4', 'rounded-lg', 'border-l-4', 'border-red-500');
                                    messageDiv.innerHTML = `
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 mr-2 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <strong class="font-bold">❌ Non éligible</strong>
                                        <p class="text-sm mt-1">Cet élève est déjà inscrit pour cette année scolaire.</p>
                                        <p class="text-xs mt-1">Un élève ne peut être inscrit qu'une seule fois par année scolaire.</p>
                                    </div>
                                </div>`;
                                    submitBtn.disabled = true;
                                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                } else if (data.deja_inscrit_classe) {
                                    messageDiv.classList.add('bg-red-100', 'text-red-700', 'p-4', 'rounded-lg', 'border-l-4', 'border-red-500');
                                    messageDiv.innerHTML = `
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 mr-2 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <strong class="font-bold">❌ Non éligible</strong>
                                        <p class="text-sm mt-1">Cet élève est déjà inscrit dans cette classe.</p>
                                    </div>
                                </div>`;
                                    submitBtn.disabled = true;
                                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                } else if (data.places_disponibles <= 0) {
                                    messageDiv.classList.add('bg-red-100', 'text-red-700', 'p-4', 'rounded-lg', 'border-l-4', 'border-red-500');
                                    messageDiv.innerHTML = `
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 mr-2 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <strong class="font-bold">❌ Non éligible</strong>
                                        <p class="text-sm mt-1">Cette classe n'a plus de places disponibles.</p>
                                    </div>
                                </div>`;
                                    submitBtn.disabled = true;
                                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                                } else {
                                    messageDiv.classList.add('bg-green-100', 'text-green-700', 'p-4', 'rounded-lg', 'border-l-4', 'border-green-500');
                                    messageDiv.innerHTML = `
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 mr-2 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <strong class="font-bold">✅ Éligible</strong>
                                        <p class="text-sm mt-1">${data.places_disponibles} place(s) disponible(s) dans cette classe.</p>
                                    </div>
                                </div>`;
                                    submitBtn.disabled = false;
                                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                                }
                            })
                            .catch(error => {
                                console.error('Erreur:', error);
                                messageDiv.classList.add('bg-red-100', 'text-red-700', 'p-4', 'rounded-lg');
                                messageDiv.innerHTML = '<div class="flex items-center"><svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Erreur lors de la vérification. Veuillez réessayer.</div>';
                            });
                    } else {
                        messageDiv.classList.add('hidden');
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                }

                eleveSelect.addEventListener('change', checkEligibility);
                classeSelect.addEventListener('change', checkEligibility);
                anneeSelect.addEventListener('change', checkEligibility);

                // Validation du formulaire
                form.addEventListener('submit', function (e) {
                    if (submitBtn.disabled) {
                        e.preventDefault();
                        alert('Veuillez corriger les erreurs avant de soumettre.');
                    }
                });

                // Vérification initiale si tous les champs sont remplis
                if (eleveSelect.value && classeSelect.value && anneeSelect.value) {
                    checkEligibility();
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .animate-spin {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            #eligibility-message {
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            select option {
                padding: 0.5rem;
            }

            /* Animation pour les boutons */
            button,
            a {
                transition: all 0.2s ease-in-out;
            }

            /* Style pour les champs de formulaire */
            input[type="date"]::-webkit-calendar-picker-indicator {
                opacity: 0.5;
                transition: opacity 0.2s;
            }

            input[type="date"]::-webkit-calendar-picker-indicator:hover {
                opacity: 1;
            }
        </style>
    @endpush

@endsection