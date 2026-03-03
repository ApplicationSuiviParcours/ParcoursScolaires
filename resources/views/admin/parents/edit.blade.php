@extends('layouts.app')

@section('title', 'Modifier le parent')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                            <a href="{{ route('admin.parents.index') }}" class="inline-flex items-center text-sm font-medium text-amber-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Parents
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('admin.parents.show', $parent) }}" class="ml-1 text-sm font-medium text-amber-200 hover:text-white md:ml-2 transition-colors duration-300">
                                    {{ $parent->full_name }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Modification</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Modifier le parent
                </h1>
                <p class="text-amber-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    {{ $parent->full_name }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.parents.show', $parent) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Voir détails
                </a>
                <a href="{{ route('admin.parents.index') }}" 
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
    <div class="max-w-4xl mx-auto">
        <!-- Formulaire -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Modifier les informations</h2>
                        <p class="text-amber-100 text-sm">Tous les champs avec * sont obligatoires</p>
                    </div>
                </div>
                <!-- Barre de progression -->
                <div class="mt-4 w-full bg-white/20 rounded-full h-2">
                    <div class="bg-white h-2 rounded-full" style="width: 75%"></div>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.parents.update', $parent) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Aperçu rapide avec photo -->
                    <div class="mb-8 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border border-amber-200">
                        <div class="flex items-center">
                            @if($parent->photo)
                                <img src="{{ Storage::url($parent->photo) }}" alt="{{ $parent->full_name }}" 
                                     class="w-16 h-16 rounded-xl object-cover mr-4 border-2 border-amber-300">
                            @else
                                <div class="w-16 h-16 {{ $parent->avatar_color }} rounded-xl flex items-center justify-center text-white font-bold text-2xl mr-4">
                                    {{ $parent->initiales }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-amber-700">Modification en cours pour</p>
                                <p class="text-lg font-bold text-gray-800">{{ $parent->full_name }}</p>
                                <p class="text-xs text-gray-500">ID: #{{ $parent->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informations personnelles -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            Informations personnelles
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User ID -->
                            <div class="group">
                                <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Compte utilisateur
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <select name="user_id" 
                                            id="user_id" 
                                            class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('user_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Aucun compte utilisateur</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $parent->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('user_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div class="group">
                                <label for="genre" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Genre <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <select name="genre" 
                                            id="genre" 
                                            class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('genre') border-red-500 @enderror appearance-none bg-white"
                                            required>
                                        <option value="">Sélectionnez le genre</option>
                                        <option value="m" {{ old('genre', $parent->genre) == 'm' ? 'selected' : '' }}>Masculin</option>
                                        <option value="f" {{ old('genre', $parent->genre) == 'f' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('genre')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="group">
                                <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="nom" 
                                           id="nom" 
                                           value="{{ old('nom', $parent->nom) }}"
                                           placeholder="Nom de famille"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('nom') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('nom')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div class="group">
                                <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="prenom" 
                                           id="prenom" 
                                           value="{{ old('prenom', $parent->prenom) }}"
                                           placeholder="Prénom"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('prenom') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('prenom')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date de naissance -->
                            <div class="group">
                                <label for="date_naissance" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Date de naissance
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="date" 
                                           name="date_naissance" 
                                           id="date_naissance" 
                                           value="{{ old('date_naissance', $parent->date_naissance ? $parent->date_naissance->format('Y-m-d') : '') }}"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('date_naissance') border-red-500 @enderror">
                                </div>
                                @error('date_naissance')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lieu de naissance -->
                            <div class="group">
                                <label for="lieu_naissance" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Lieu de naissance
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="lieu_naissance" 
                                           id="lieu_naissance" 
                                           value="{{ old('lieu_naissance', $parent->lieu_naissance) }}"
                                           placeholder="Lieu de naissance"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('lieu_naissance') border-red-500 @enderror">
                                </div>
                                @error('lieu_naissance')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Profession -->
                            <div class="group">
                                <label for="profession" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Profession
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="profession" 
                                           id="profession" 
                                           value="{{ old('profession', $parent->profession) }}"
                                           placeholder="Profession (optionnel)"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('profession') border-red-500 @enderror">
                                </div>
                                @error('profession')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="group">
                                <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Statut
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <select name="statut" 
                                            id="statut" 
                                            class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('statut') border-red-500 @enderror appearance-none bg-white">
                                        <option value="1" {{ old('statut', $parent->statut) == 1 ? 'selected' : '' }}>Actif</option>
                                        <option value="0" {{ old('statut', $parent->statut) == 0 ? 'selected' : '' }}>Inactif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('statut')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Photo -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                            Photo
                        </h3>

                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0">
                                @if($parent->photo)
                                    <img src="{{ Storage::url($parent->photo) }}" alt="Photo actuelle" 
                                         class="w-20 h-20 rounded-xl object-cover border-2 border-amber-300">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" 
                                           name="photo" 
                                           id="photo" 
                                           accept="image/*"
                                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition-all duration-300">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPG, PNG, GIF. Max 2 Mo</p>
                                @error('photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Coordonnées -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </span>
                            Coordonnées
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Téléphone -->
                            <div class="group">
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Téléphone <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <input type="tel" 
                                           name="telephone" 
                                           id="telephone" 
                                           value="{{ old('telephone', $parent->telephone) }}"
                                           placeholder="Numéro de téléphone"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('telephone') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('telephone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="group">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" 
                                           name="email" 
                                           id="email" 
                                           value="{{ old('email', $parent->email) }}"
                                           placeholder="adresse@email.com"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('email') border-red-500 @enderror">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="group md:col-span-2">
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                    Adresse <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="adresse" 
                                           id="adresse" 
                                           value="{{ old('adresse', $parent->adresse) }}"
                                           placeholder="Adresse complète"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('adresse') border-red-500 @enderror"
                                           required>
                                </div>
                                @error('adresse')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Réseaux sociaux (optionnel) -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </span>
                            Réseaux sociaux (optionnel)
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Facebook -->
                            <div class="group">
                                <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"></path>
                                        </svg>
                                    </div>
                                    <input type="url" 
                                           name="facebook" 
                                           id="facebook" 
                                           value="{{ old('facebook', $parent->facebook ?? '') }}"
                                           placeholder="https://facebook.com/..."
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300">
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="group">
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="whatsapp" 
                                           id="whatsapp" 
                                           value="{{ old('whatsapp', $parent->whatsapp ?? '') }}"
                                           placeholder="Numéro WhatsApp"
                                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes internes -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </span>
                            Notes internes
                        </h3>

                        <div class="relative">
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="4"
                                      placeholder="Ajoutez des notes internes sur ce parent (optionnel)..."
                                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('notes') border-red-500 @enderror">{{ old('notes', $parent->notes) }}</textarea>
                        </div>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Enfants avec liens parentaux -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <span class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </span>
                            Enfants associés
                        </h3>

                        <div class="bg-gray-50 rounded-2xl p-6 border-2 border-gray-200">
                            <div class="grid grid-cols-1 gap-4">
                                @foreach($eleves as $eleve)
                                    <div class="flex items-center p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-amber-300 hover:bg-amber-50 transition-all duration-300">
                                        <input type="checkbox" 
                                               name="eleve_ids[]" 
                                               value="{{ $eleve->id }}"
                                               {{ in_array($eleve->id, old('eleve_ids', $parent->eleves->pluck('id')->toArray())) ? 'checked' : '' }}
                                               class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 focus:ring-2 mr-3"
                                               id="eleve_{{ $eleve->id }}">
                                        
                                        <label for="eleve_{{ $eleve->id }}" class="flex-1 cursor-pointer">
                                            <span class="font-medium text-gray-700">{{ $eleve->nom }} {{ $eleve->prenom }}</span>
                                            @if($eleve->classe)
                                                <span class="ml-2 text-xs text-gray-500">({{ $eleve->classe->nom }})</span>
                                            @endif
                                        </label>

                                        <select name="liens_parentaux[{{ $loop->index }}]" 
                                                class="ml-4 px-3 py-1 rounded-lg border-2 border-gray-200 text-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                                                {{ !in_array($eleve->id, old('eleve_ids', $parent->eleves->pluck('id')->toArray())) ? 'disabled' : '' }}>
                                            <option value="pere" {{ isset($liensExistants[$eleve->id]) && $liensExistants[$eleve->id] == 'pere' ? 'selected' : '' }}>Père</option>
                                            <option value="mere" {{ isset($liensExistants[$eleve->id]) && $liensExistants[$eleve->id] == 'mere' ? 'selected' : '' }}>Mère</option>
                                            <option value="tuteur" {{ isset($liensExistants[$eleve->id]) && $liensExistants[$eleve->id] == 'tuteur' ? 'selected' : '' }}>Tuteur</option>
                                            <option value="autre" {{ isset($liensExistants[$eleve->id]) && $liensExistants[$eleve->id] == 'autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4 flex items-center text-xs text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Cochez les enfants associés et sélectionnez le lien parental
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end space-x-4 pt-6 border-t-2 border-gray-100">
                        <a href="{{ route('admin.parents.show', $parent) }}" 
                           class="px-8 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Zone de danger (suppression) -->
        <div class="mt-8 bg-white rounded-3xl shadow-xl overflow-hidden border-l-8 border-red-500">
            <div class="bg-gradient-to-r from-red-50 to-red-100 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-red-500 rounded-2xl flex items-center justify-center mr-5 animate-pulse">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-800 mb-1">Zone de danger</h3>
                        <p class="text-red-600 text-sm">Actions irréversibles - Manipuler avec précaution</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">Supprimer ce parent</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Une fois supprimé, ce parent sera définitivement effacé de la base de données. 
                            Cette action est irréversible et ne peut pas être annulée.
                        </p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            ID : <span class="font-mono ml-1">#{{ $parent->id }}</span>
                        </div>
                    </div>
                    
                    <div class="md:text-right">
                        <form action="{{ route('admin.parents.destroy', $parent) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer ce parent ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer définitivement
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    
    /* Style pour les champs désactivés */
    select:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    // Confirmation avant de quitter si le formulaire est modifié
    let formModified = false;
    
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('change', () => formModified = true);
        element.addEventListener('keyup', () => {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                formModified = true;
            }
        });
    });
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
        }
    });
    
    document.querySelector('form').addEventListener('submit', function() {
        formModified = false;
    });

    // Gestion des liens parentaux
    document.querySelectorAll('input[name="eleve_ids[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const select = this.closest('.flex').querySelector('select[name^="liens_parentaux"]');
            if (select) {
                select.disabled = !this.checked;
                if (!this.checked) {
                    select.value = '';
                }
            }
        });
    });

    // Prévisualisation de la photo
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('.flex-shrink-0 img, .flex-shrink-0 div');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    // Remplacer le div par une image
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.className = 'w-20 h-20 rounded-xl object-cover border-2 border-amber-300';
                    preview.parentNode.replaceChild(newImg, preview);
                }
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush