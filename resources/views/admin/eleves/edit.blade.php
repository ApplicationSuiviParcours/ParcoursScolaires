@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modifier un élève') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Messages flash -->
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

        <!-- En-tête avec progression -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-medium text-gray-700">Modification élève</h3>
                <span class="text-sm text-gray-500">Formulaire de modification</span>
            </div>
            <div class="w-full bg-gray-200 h-0.5">
                <div class="bg-indigo-600 h-0.5 w-full"></div>
            </div>
        </div>

        <!-- Formulaire principal -->
        <div class="bg-white shadow-lg overflow-hidden border border-gray-200 rounded-xl">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="bg-indigo-500 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-white">Modification de l'élève</h3>
                        <p class="text-indigo-200 text-sm">{{ $eleve->nom }} {{ $eleve->prenom }} - <span class="font-mono">{{ $eleve->matricule }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-8">
                <form method="POST" action="{{ route('admin.eleves.update', $eleve) }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Section Photo actuelle -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Photo d'identité</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center space-x-6">
                                <!-- Photo actuelle -->
                                <div class="flex-shrink-0" id="photo-container">
                                    @if($eleve->photo)
                                        <img src="{{ Storage::url($eleve->photo) }}" alt="{{ $eleve->prenom }}" class="w-24 h-24 rounded-lg object-cover border-2 border-indigo-200 shadow-md" id="photo-preview">
                                    @else
                                        <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center border-2 border-indigo-100 shadow-md" id="photo-preview">
                                            <span class="text-3xl font-bold text-indigo-400">
                                                {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Photo actuelle</p>
                                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour conserver cette photo</p>
                                </div>
                            </div>

                            <!-- Upload nouvelle photo -->
                            <div>
                                <label for="photo" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Nouvelle photo
                                </label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('photo') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF (max. 2 Mo)</p>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Informations personnelles -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-600 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Identité</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Matricule (lecture seule) - NOUVEAU FORMAT -->
                            <div>
                                <label for="matricule" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Matricule
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="matricule" id="matricule" value="{{ $eleve->matricule }}" required readonly
                                           class="pl-10 block w-full px-4 py-3 bg-gray-50 border border-gray-300 text-gray-500 text-sm cursor-not-allowed rounded-lg">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Le matricule ne peut pas être modifié - Format: Année + Lettre + Numéro</p>
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Nom <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="nom" id="nom" required
                                           placeholder="DIOP"
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('nom') border-red-500 @enderror"
                                           value="{{ old('nom', $eleve->nom) }}">
                                </div>
                                @error('nom')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Prénom <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="prenom" id="prenom" required
                                           placeholder="Mamadou"
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('prenom') border-red-500 @enderror"
                                           value="{{ old('prenom', $eleve->prenom) }}">
                                </div>
                                @error('prenom')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Genre <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <select name="genre" id="genre" required
                                            class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('genre') border-red-500 @enderror">
                                        <option value="m" {{ old('genre', $eleve->genre) === 'm' ? 'selected' : '' }}>Masculin</option>
                                        <option value="f" {{ old('genre', $eleve->genre) === 'f' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                                @error('genre')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Naissance -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-400 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Naissance</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Date de naissance -->
                            <div>
                                <label for="date_naissance" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Date de naissance <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" name="date_naissance" id="date_naissance" required
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('date_naissance') border-red-500 @enderror"
                                           value="{{ old('date_naissance', $eleve->date_naissance->format('Y-m-d')) }}">
                                </div>
                                @error('date_naissance')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lieu de naissance -->
                            <div>
                                <label for="lieu_naissance" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Lieu de naissance <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="lieu_naissance" id="lieu_naissance" required
                                           placeholder="Dakar, Sénégal"
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('lieu_naissance') border-red-500 @enderror"
                                           value="{{ old('lieu_naissance', $eleve->lieu_naissance) }}">
                                </div>
                                @error('lieu_naissance')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Contact -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-500 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Coordonnées</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Téléphone -->
                            <div>
                                <label for="telephone" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Téléphone
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input type="tel" name="telephone" id="telephone"
                                           placeholder="77 123 45 67"
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('telephone') border-red-500 @enderror"
                                           value="{{ old('telephone', $eleve->telephone) }}">
                                </div>
                                @error('telephone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email"
                                           placeholder="eleve@exemple.com"
                                           class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('email') border-red-500 @enderror"
                                           value="{{ old('email', $eleve->email) }}">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Inscriptions (MODIFIÉE) -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Inscriptions</h4>
                        </div>

                        @php
                            $inscriptionActive = $eleve->inscriptions()->where('statut', true)->first();
                            $classeActive = $inscriptionActive ? $inscriptionActive->classe : null;
                            $autresInscriptions = $eleve->inscriptions()->where('statut', false)->with('classe', 'anneeScolaire')->get();
                        @endphp

                        <!-- Classe actuelle (inscription active) -->
                        @if($classeActive)
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Inscription active</p>
                                        <p class="text-sm text-gray-700">
                                            <span class="font-semibold">{{ $classeActive->nom_complet ?? $classeActive->nom }}</span> 
                                            ({{ $classeActive->niveau }} @if($classeActive->serie)- {{ $classeActive->serie }}@endif)
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Depuis le {{ $inscriptionActive->date_inscription->format('d/m/Y') }}
                                            @if($inscriptionActive->anneeScolaire) - {{ $inscriptionActive->anneeScolaire->nom }}@endif
                                        </p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Active</span>
                            </div>
                        </div>
                        @else
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-yellow-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Aucune inscription active</p>
                                    <p class="text-xs text-gray-600">Cet élève n'est actuellement inscrit dans aucune classe.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Nouvelle inscription (optionnelle) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nouvelle_classe_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Nouvelle inscription
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <select name="nouvelle_classe_id" id="nouvelle_classe_id"
                                            class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('nouvelle_classe_id') border-red-500 @enderror">
                                        <option value="">Inscrire dans une nouvelle classe (optionnel)</option>
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}" {{ old('nouvelle_classe_id') == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom_complet ?? $classe->nom }} - {{ $classe->niveau }} @if($classe->serie)({{ $classe->serie }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Créer une nouvelle inscription (ne modifie pas les inscriptions existantes)</p>
                                @error('nouvelle_classe_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Statut élève <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative flex items-center space-x-6 pt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="statut" value="1" class="form-radio text-indigo-600" {{ old('statut', $eleve->statut) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Actif</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="statut" value="0" class="form-radio text-red-600" {{ old('statut', $eleve->statut) ? '' : 'checked' }}>
                                        <span class="ml-2 text-sm text-gray-700">Inactif</span>
                                    </label>
                                </div>
                                @error('statut')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Historique des inscriptions -->
                        @if($autresInscriptions->count() > 0)
                        <div class="mt-4">
                            <details class="group">
                                <summary class="flex items-center cursor-pointer text-xs font-semibold text-gray-600 uppercase tracking-wider hover:text-indigo-600">
                                    <svg class="w-4 h-4 mr-1 group-open:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Historique des inscriptions ({{ $autresInscriptions->count() }})
                                </summary>
                                <div class="mt-2 space-y-2">
                                    @foreach($autresInscriptions as $inscription)
                                    <div class="p-2 bg-gray-50 border border-gray-200 rounded-lg text-xs">
                                        <div class="flex justify-between">
                                            <span class="font-medium">{{ $inscription->classe->nom_complet ?? $inscription->classe->nom }}</span>
                                            <span class="text-gray-500">{{ $inscription->date_inscription->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="text-gray-500">
                                            {{ $inscription->anneeScolaire->nom ?? 'Année inconnue' }}
                                            @if($inscription->observation)
                                                - {{ $inscription->observation }}
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </details>
                        </div>
                        @endif
                    </div>

                    <!-- Section Adresse -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Résidence</h4>
                        </div>

                        <!-- Adresse -->
                        <div>
                            <label for="adresse" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                Adresse complète <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                                <textarea name="adresse" id="adresse" rows="3" required
                                          placeholder="123 Rue Liberté, Dakar"
                                          class="pl-10 block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('adresse') border-red-500 @enderror">{{ old('adresse', $eleve->adresse) }}</textarea>
                            </div>
                            @error('adresse')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section Compte utilisateur -->
                    @if($eleve->user)
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Compte utilisateur</h4>
                        </div>

                        <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-indigo-100 p-2 rounded-lg">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Compte utilisateur existant</p>
                                        <p class="text-xs text-gray-500">Email: {{ $eleve->user->email }}</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Actif</span>
                            </div>
                            <div class="mt-4 flex items-center">
                                <input type="checkbox" name="update_user" id="update_user" value="1" {{ old('update_user') ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="update_user" class="ml-2 block text-sm text-gray-900">
                                    Mettre à jour le mot de passe
                                </label>
                            </div>

                            <!-- Champs de mot de passe (affichés conditionnellement) -->
                            <div id="password_fields" class="{{ old('update_user') ? '' : 'hidden' }} mt-4 space-y-4">
                                <div>
                                    <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                        Nouveau mot de passe <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="password" name="password" id="password"
                                           class="block w-full px-4 py-2 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                        Confirmer le mot de passe <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="block w-full px-4 py-2 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Boutons d'action -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleves.show', $eleve) }}" 
                           class="px-6 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-sm font-medium rounded-lg transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm font-medium rounded-lg transition-colors shadow-lg shadow-indigo-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Message d'aide -->
        <div class="mt-4 bg-gray-50 border border-gray-200 p-4 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold">Information :</span> Le matricule <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $eleve->matricule }}</span> ne peut pas être modifié. 
                        Les champs marqués d'un <span class="text-red-500 font-bold">*</span> sont obligatoires.
                        Laissez le champ photo vide pour conserver la photo actuelle.
                        <br><span class="text-indigo-600">Pour changer la classe de l'élève, créez une nouvelle inscription. L'ancienne inscription sera automatiquement désactivée.</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Aperçu de l'image avant upload
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const photoContainer = document.getElementById('photo-container');
    const updateUserCheckbox = document.getElementById('update_user');
    const passwordFields = document.getElementById('password_fields');
    
    // Aperçu photo
    if (photoInput && photoContainer) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const currentPreview = document.getElementById('photo-preview');
                    if (currentPreview.tagName === 'IMG') {
                        currentPreview.src = e.target.result;
                    } else {
                        // Remplacer le div d'initiales par une image
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.alt = "Nouvelle photo";
                        newImg.className = "w-24 h-24 rounded-lg object-cover border-2 border-indigo-200 shadow-md";
                        newImg.id = "photo-preview";
                        photoContainer.innerHTML = '';
                        photoContainer.appendChild(newImg);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Affichage conditionnel des champs de mot de passe
    if (updateUserCheckbox && passwordFields) {
        updateUserCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.classList.remove('hidden');
                if (document.getElementById('password')) {
                    document.getElementById('password').setAttribute('required', 'required');
                }
                if (document.getElementById('password_confirmation')) {
                    document.getElementById('password_confirmation').setAttribute('required', 'required');
                }
            } else {
                passwordFields.classList.add('hidden');
                if (document.getElementById('password')) {
                    document.getElementById('password').removeAttribute('required');
                }
                if (document.getElementById('password_confirmation')) {
                    document.getElementById('password_confirmation').removeAttribute('required');
                }
            }
        });
    }
});
</script>
@endpush
@endsection