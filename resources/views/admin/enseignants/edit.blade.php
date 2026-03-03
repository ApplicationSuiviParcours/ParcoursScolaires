@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modifier un enseignant') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header moderne avec dégradé -->
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 rounded-2xl shadow-2xl mb-8 overflow-hidden relative group">
            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-32 translate-x-32 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-24 -translate-x-24 group-hover:translate-y-0 group-hover:translate-x-0 transition-transform duration-700"></div>
            
            <div class="relative px-8 py-6">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-3 rounded-xl backdrop-blur-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">Modifier un enseignant</h3>
                        <p class="text-blue-100 text-sm mt-1">{{ $enseignant->prenom }} {{ $enseignant->nom }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages flash -->
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-lg shadow-md animate-slideDown" role="alert">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Formulaire principal -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- En-tête du formulaire -->
            <div class="px-6 py-5 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-gradient-to-br from-blue-100 to-blue-200 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-semibold text-gray-900">Informations personnelles</h4>
                            <p class="text-sm text-gray-500">Modifiez les informations de l'enseignant</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.enseignants.show', $enseignant) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all duration-200 group">
                            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Retour au profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Barre d'information sur le matricule -->
            <div class="px-6 pt-4">
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-xl p-4 border border-indigo-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="bg-indigo-200 p-2 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-xs text-gray-500">Matricule</p>
                            <p class="text-sm font-mono font-semibold text-gray-900">{{ $enseignant->matricule ?? 'ENS-'.str_pad($enseignant->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-xs text-gray-500">Âge</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $enseignant->age ?? 'N/A' }} ans</p>
                        </div>
                        <div class="h-8 w-px bg-gray-300"></div>
                        <div>
                            @if($enseignant->statut)
                                <span class="px-3 py-1.5 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                                    Actif
                                </span>
                            @else
                                <span class="px-3 py-1.5 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                    Inactif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques rapides -->
            <div class="px-6 mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                    <p class="text-xs text-blue-600 uppercase font-semibold">Classes enseignées</p>
                    <p class="text-xl font-bold text-blue-800">{{ $enseignant->nombre_classes ?? 0 }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                    <p class="text-xs text-green-600 uppercase font-semibold">Matières enseignées</p>
                    <p class="text-xl font-bold text-green-800">{{ $enseignant->nombre_matieres ?? 0 }}</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                    <p class="text-xs text-purple-600 uppercase font-semibold">Évaluations</p>
                    <p class="text-xl font-bold text-purple-800">{{ $enseignant->evaluations_count ?? 0 }}</p>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-6">
                <form method="POST" action="{{ route('admin.enseignants.update', $enseignant) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Photo -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Photo de profil</label>
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border-2 border-gray-300 overflow-hidden shadow-md" id="photo-preview-container">
                                    @if($enseignant->photo)
                                        <img src="{{ Storage::url($enseignant->photo) }}" alt="{{ $enseignant->prenom }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-2xl font-bold text-indigo-500">
                                            {{ strtoupper(substr($enseignant->prenom ?? '', 0, 1)) }}{{ strtoupper(substr($enseignant->nom ?? '', 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                                <p class="mt-1 text-xs text-gray-500">Laissez vide pour conserver la photo actuelle. Formats acceptés : JPEG, PNG, JPG, GIF (max. 2 Mo)</p>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informations importantes -->
                    <div class="bg-yellow-50 rounded-xl p-4 border border-yellow-200 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Note importante</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Le matricule ({{ $enseignant->matricule }}) est généré automatiquement et ne peut pas être modifié. L'âge est calculé automatiquement à partir de la date de naissance.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Utilisateur associé -->
                        <div class="md:col-span-2">
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Utilisateur associé <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <select name="user_id" id="user_id" required
                                        class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 appearance-none bg-white @error('user_id') border-red-400 @enderror">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == old('user_id', $enseignant->user_id) ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M3 18h18"></path>
                                    </svg>
                                </div>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $enseignant->nom) }}" required
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('nom') border-red-400 @enderror">
                            </div>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prénom -->
                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $enseignant->prenom) }}" required
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('prenom') border-red-400 @enderror">
                            </div>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Genre -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">
                                Genre <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <select name="genre" id="genre" required
                                        class="block w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 appearance-none bg-white @error('genre') border-red-400 @enderror">
                                    <option value="m" {{ old('genre', $enseignant->genre) == 'm' ? 'selected' : '' }}>Masculin</option>
                                    <option value="f" {{ old('genre', $enseignant->genre) == 'f' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('genre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de naissance -->
                        <div>
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">
                                Date de naissance <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" name="date_naissance" id="date_naissance" 
                                       value="{{ old('date_naissance', $enseignant->date_naissance?->format('Y-m-d')) }}" required
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('date_naissance') border-red-400 @enderror">
                            </div>
                            @error('date_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lieu de naissance -->
                        <div>
                            <label for="lieu_naissance" class="block text-sm font-medium text-gray-700 mb-1">
                                Lieu de naissance <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="lieu_naissance" id="lieu_naissance" 
                                       value="{{ old('lieu_naissance', $enseignant->lieu_naissance) }}" required
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('lieu_naissance') border-red-400 @enderror">
                            </div>
                            @error('lieu_naissance')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">
                                Téléphone
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="tel" name="telephone" id="telephone" 
                                       value="{{ old('telephone', $enseignant->telephone) }}"
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('telephone') border-red-400 @enderror">
                            </div>
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', $enseignant->email) }}"
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('email') border-red-400 @enderror">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Spécialité -->
                        <div>
                            <label for="specialite" class="block text-sm font-medium text-gray-700 mb-1">
                                Spécialité
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="specialite" id="specialite" 
                                       value="{{ old('specialite', $enseignant->specialite) }}"
                                       class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('specialite') border-red-400 @enderror">
                            </div>
                            @error('specialite')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">
                                Statut
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <select name="statut" id="statut"
                                        class="block w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 appearance-none bg-white @error('statut') border-red-400 @enderror">
                                    <option value="1" {{ old('statut', $enseignant->statut) == 1 ? 'selected' : '' }}>Actif</option>
                                    <option value="0" {{ old('statut', $enseignant->statut) == 0 ? 'selected' : '' }}>Inactif</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Un enseignant inactif ne peut pas être assigné à de nouvelles classes</p>
                            @error('statut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="md:col-span-2">
                            <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">
                                Adresse <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                                <textarea name="adresse" id="adresse" rows="3" required
                                          class="block w-full pl-10 pr-3 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('adresse') border-red-400 @enderror">{{ old('adresse', $enseignant->adresse) }}</textarea>
                            </div>
                            @error('adresse')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.enseignants.show', $enseignant) }}"
                           class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-200 font-medium text-sm flex items-center group border-2 border-transparent hover:border-gray-300">
                            <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium text-sm shadow-lg shadow-blue-200 flex items-center group">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section des assignations (matières/classes) -->
        @if($enseignant->enseignantMatiereClasses->isNotEmpty())
        <div class="mt-8 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Assignations actuelles</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($enseignant->enseignantMatiereClasses as $assignation)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-indigo-600">{{ $assignation->matiere->nom ?? 'Matière' }}</span>
                                <span class="text-xs px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full">{{ $assignation->classe->nom ?? 'Classe' }}</span>
                            </div>
                            <p class="text-xs text-gray-500">Année scolaire: {{ $assignation->anneeScolaire->libelle ?? 'N/A' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animations des barres de progression */
    .progress-bar {
        transition: width 1s ease-out;
    }

    /* Animation d'apparition */
    @keyframes slideDown {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    /* Amélioration du focus */
    input:focus, select:focus, textarea:focus {
        outline: none;
    }

    /* Style pour les placeholders */
    ::placeholder {
        color: #9ca3af;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validation du téléphone
        const telephoneInput = document.getElementById('telephone');
        if (telephoneInput) {
            telephoneInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9+]/g, '');
            });
        }

        // Aperçu de la photo
        const photoInput = document.getElementById('photo');
        const previewContainer = document.getElementById('photo-preview-container');
        
        if (photoInput && previewContainer) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Vérification de la taille du fichier (2 Mo max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Le fichier est trop volumineux. Taille maximale : 2 Mo');
                        this.value = '';
                        return;
                    }
                    
                    // Vérification du type de fichier
                    if (!file.type.match('image.*')) {
                        alert('Veuillez sélectionner une image valide (JPEG, PNG, JPG, GIF)');
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewContainer.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Validation de l'email
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const email = this.value;
                if (email && !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    this.classList.add('border-red-400');
                    // Créer un message d'erreur
                    let errorMsg = this.parentElement.nextElementSibling;
                    if (!errorMsg || !errorMsg.classList.contains('email-error')) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'mt-1 text-sm text-red-600 email-error';
                        errorMsg.textContent = 'Veuillez entrer une adresse email valide';
                        this.parentElement.parentElement.appendChild(errorMsg);
                    }
                } else {
                    this.classList.remove('border-red-400');
                    const errorMsg = this.parentElement.parentElement.querySelector('.email-error');
                    if (errorMsg) errorMsg.remove();
                }
            });
        }

        // Validation avant soumission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = document.querySelectorAll('[required]');
                let isValid = true;
                let firstInvalid = null;

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('border-red-400', 'bg-red-50');
                        if (!firstInvalid) firstInvalid = field;
                        isValid = false;
                    } else {
                        field.classList.remove('border-red-400', 'bg-red-50');
                        field.classList.add('border-gray-200');
                    }
                });

                // Validation supplémentaire pour l'email
                const email = document.getElementById('email');
                if (email && email.value && !email.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    email.classList.add('border-red-400');
                    isValid = false;
                    if (!firstInvalid) firstInvalid = email;
                }

                if (!isValid) {
                    e.preventDefault();
                    firstInvalid?.focus();
                    
                    // Notification toast
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg z-50 animate-slideDown';
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Veuillez remplir tous les champs obligatoires correctement.</span>
                        </div>
                    `;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.remove();
                    }, 3000);
                }
            });
        }

        // Animation des champs au focus
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.closest('.group')?.classList.add('scale-[1.02]');
            });
            input.addEventListener('blur', function() {
                this.closest('.group')?.classList.remove('scale-[1.02]');
            });
        });
    });
</script>
@endpush