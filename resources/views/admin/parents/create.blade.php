@extends('layouts.app')

@section('title', 'Nouveau parent')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 py-10 sm:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-64 sm:w-96 h-64 sm:h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-64 sm:w-96 h-64 sm:h-96 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Particules flottantes -->
    <div class="absolute inset-0 overflow-hidden">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div class="text-center md:text-left">
                <!-- Fil d'Ariane -->
                <nav class="flex justify-center md:justify-start mb-3 sm:mb-4" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.parents.index') }}"
                               class="inline-flex items-center text-xs sm:text-sm font-medium text-emerald-200 hover:text-white transition-colors duration-300">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Parents
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-emerald-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-xs sm:text-sm font-medium text-white md:ml-2">Nouveau parent</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Nouveau parent
                </h1>
                <p class="text-emerald-200 text-sm sm:text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Ajouter un nouveau parent ou tuteur
                </p>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"/>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 lg:px-6 py-8 sm:py-10 bg-gray-50">
    <div class="max-w-4xl mx-auto">

        {{-- ── FORMULAIRE PRINCIPAL ─────────────────────────────────── --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl overflow-hidden">

            {{-- En-tête du formulaire --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-5 sm:px-8 py-5 sm:py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-3 sm:gap-5">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-lg rounded-xl sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white mb-0.5">Informations du parent</h2>
                            <p class="text-emerald-100 text-xs sm:text-sm">* Champs obligatoires</p>
                        </div>
                    </div>
                    <!-- Barre de progression -->
                    <div class="flex items-center gap-3 sm:flex-col sm:items-end sm:gap-1">
                        <span class="text-white/80 text-xs sm:text-sm whitespace-nowrap">Complétion</span>
                        <div class="flex-1 sm:flex-none sm:w-32 h-2 bg-white/20 rounded-full overflow-hidden">
                            <div class="bg-white h-2 rounded-full transition-all duration-500" style="width: 0%" id="progressBar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6 lg:p-8">
                <form action="{{ route('admin.parents.store') }}" method="POST" enctype="multipart/form-data" id="createForm">
                    @csrf

                    {{-- Aperçu rapide --}}
                    <div class="mb-6 sm:mb-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl sm:rounded-2xl border border-emerald-200 hidden" id="previewSection">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-emerald-500 rounded-xl flex items-center justify-center text-white font-bold text-lg sm:text-2xl flex-shrink-0" id="previewInitiales">
                                ?
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-emerald-700">Aperçu</p>
                                <p class="text-base sm:text-lg font-bold text-gray-800" id="previewName">Nouveau parent</p>
                            </div>
                        </div>
                    </div>

                    {{-- ── INFORMATIONS PERSONNELLES ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            Informations personnelles
                        </h3>

                        {{-- 1 col mobile → 2 col md --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                            {{-- Compte utilisateur --}}
                            <div class="group">
                                <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Compte utilisateur
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <select name="user_id" id="user_id"
                                            class="w-full pl-10 sm:pl-12 pr-9 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                   transition-all duration-300 @error('user_id') border-red-500 @enderror
                                                   appearance-none bg-white text-sm">
                                        <option value="">Aucun compte (créer plus tard)</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('user_id')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Genre --}}
                            <div class="group">
                                <label for="genre" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Genre <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <select name="genre" id="genre" required
                                            class="w-full pl-10 sm:pl-12 pr-9 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                   transition-all duration-300 @error('genre') border-red-500 @enderror
                                                   appearance-none bg-white text-sm">
                                        <option value="">Sélectionnez le genre</option>
                                        <option value="m" {{ old('genre') == 'm' ? 'selected' : '' }}>Masculin</option>
                                        <option value="f" {{ old('genre') == 'f' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('genre')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Nom --}}
                            <div class="group">
                                <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                                           placeholder="Nom de famille" required
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('nom') border-red-500 @enderror text-sm">
                                </div>
                                @error('nom')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Prénom --}}
                            <div class="group">
                                <label for="prenom" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}"
                                           placeholder="Prénom" required
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('prenom') border-red-500 @enderror text-sm">
                                </div>
                                @error('prenom')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Date de naissance --}}
                            <div class="group">
                                <label for="date_naissance" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Date de naissance
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}"
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('date_naissance') border-red-500 @enderror text-sm">
                                </div>
                                @error('date_naissance')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Lieu de naissance --}}
                            <div class="group">
                                <label for="lieu_naissance" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Lieu de naissance
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="lieu_naissance" id="lieu_naissance" value="{{ old('lieu_naissance') }}"
                                           placeholder="Lieu de naissance"
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('lieu_naissance') border-red-500 @enderror text-sm">
                                </div>
                                @error('lieu_naissance')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Profession --}}
                            <div class="group">
                                <label for="profession" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Profession
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="profession" id="profession" value="{{ old('profession') }}"
                                           placeholder="Profession (optionnel)"
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('profession') border-red-500 @enderror text-sm">
                                </div>
                                @error('profession')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            {{-- Statut --}}
                            <div class="group">
                                <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Statut
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <select name="statut" id="statut"
                                            class="w-full pl-10 sm:pl-12 pr-9 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                   focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                   transition-all duration-300 @error('statut') border-red-500 @enderror
                                                   appearance-none bg-white text-sm">
                                        <option value="1" {{ old('statut', '1') == '1' ? 'selected' : '' }}>Actif</option>
                                        <option value="0" {{ old('statut') == '0' ? 'selected' : '' }}>Inactif</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 sm:pr-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                @error('statut')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── PHOTO ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            Photo
                        </h3>
                        <div class="flex items-center gap-4 sm:gap-6">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-200 rounded-xl flex items-center justify-center" id="photoPreview">
                                    <svg class="w-7 h-7 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="w-full text-xs sm:text-sm text-gray-500
                                              file:mr-3 sm:file:mr-4 file:py-1.5 sm:file:py-2 file:px-3 sm:file:px-4
                                              file:rounded-xl file:border-0 file:text-xs sm:file:text-sm file:font-semibold
                                              file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all duration-300">
                                <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPG, PNG, GIF. Max 2 Mo</p>
                                @error('photo')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── COORDONNÉES ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </span>
                            Coordonnées
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            {{-- Téléphone --}}
                            <div class="group">
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Téléphone <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input type="tel" name="telephone" id="telephone" value="{{ old('telephone') }}"
                                           placeholder="Numéro de téléphone" required
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('telephone') border-red-500 @enderror text-sm">
                                </div>
                                @error('telephone')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            {{-- Email --}}
                            <div class="group">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                           placeholder="adresse@email.com"
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('email') border-red-500 @enderror text-sm">
                                </div>
                                @error('email')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            {{-- Adresse (pleine largeur) --}}
                            <div class="group md:col-span-2">
                                <label for="adresse" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-emerald-600 transition-colors duration-300">
                                    Adresse <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}"
                                           placeholder="Adresse complète" required
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 @error('adresse') border-red-500 @enderror text-sm">
                                </div>
                                @error('adresse')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── RÉSEAUX SOCIAUX ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                            </span>
                            Réseaux sociaux <span class="text-xs sm:text-sm font-normal text-gray-400">(optionnel)</span>
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            {{-- Facebook --}}
                            <div class="group">
                                <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"/>
                                        </svg>
                                    </div>
                                    <input type="url" name="facebook" id="facebook" value="{{ old('facebook') }}"
                                           placeholder="https://facebook.com/..."
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 text-sm">
                                </div>
                            </div>
                            {{-- WhatsApp --}}
                            <div class="group">
                                <label for="whatsapp" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp') }}"
                                           placeholder="Numéro WhatsApp"
                                           class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border-2 border-gray-200
                                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                                  transition-all duration-300 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── NOTES INTERNES ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </span>
                            Notes internes
                        </h3>
                        <textarea name="notes" id="notes" rows="4"
                                  placeholder="Ajoutez des notes internes sur ce parent (optionnel)..."
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200
                                         focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200
                                         transition-all duration-300 @error('notes') border-red-500 @enderror
                                         text-sm resize-y">{{ old('notes') }}</textarea>
                        @error('notes')<p class="mt-1.5 text-xs sm:text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- ── ENFANTS ASSOCIÉS ── --}}
                    <div class="mb-7 sm:mb-8">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 flex items-center gap-3">
                            <span class="w-7 h-7 sm:w-8 sm:h-8 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </span>
                            Enfants associés
                        </h3>

                        <div class="bg-gray-50 rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2 border-gray-200">
                            @if($eleves->count() > 0)
                                <div class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto pr-1 sm:pr-2">
                                    @foreach($eleves as $eleve)
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 p-3 bg-white rounded-xl border-2 border-gray-200 hover:border-emerald-300 hover:bg-emerald-50 transition-all duration-300">
                                            {{-- Checkbox + label --}}
                                            <div class="flex items-center gap-2 sm:gap-3 flex-1 min-w-0">
                                                <input type="checkbox"
                                                       name="eleve_ids[]"
                                                       value="{{ $eleve->id }}"
                                                       {{ in_array($eleve->id, old('eleve_ids', [])) ? 'checked' : '' }}
                                                       class="eleve-checkbox w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 focus:ring-2 flex-shrink-0"
                                                       id="eleve_{{ $eleve->id }}">
                                                <label for="eleve_{{ $eleve->id }}" class="cursor-pointer min-w-0">
                                                    <span class="font-medium text-gray-700 text-sm">{{ $eleve->nom }} {{ $eleve->prenom }}</span>
                                                    @if($eleve->classe)
                                                        <span class="ml-1 text-xs text-gray-500">({{ $eleve->classe->nom }})</span>
                                                    @endif
                                                    @if($eleve->matricule)
                                                        <span class="ml-1 text-xs text-gray-400">#{{ $eleve->matricule }}</span>
                                                    @endif
                                                </label>
                                            </div>
                                            {{-- Select lien parental --}}
                                            <select name="liens_parentaux[{{ $loop->index }}]"
                                                    class="lien-select w-full sm:w-auto sm:ml-auto px-3 py-1.5 rounded-lg border-2 border-gray-200 text-xs sm:text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 flex-shrink-0"
                                                    {{ !in_array($eleve->id, old('eleve_ids', [])) ? 'disabled' : '' }}>
                                                <option value="pere">Père</option>
                                                <option value="mere">Mère</option>
                                                <option value="tuteur">Tuteur</option>
                                                <option value="autre">Autre</option>
                                            </select>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="mt-3 text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Cochez les enfants associés et sélectionnez le lien parental
                                </p>
                            @else
                                <div class="text-center py-6 sm:py-8">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300 mx-auto mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm mb-1">Aucun élève disponible</p>
                                    <p class="text-xs text-gray-400">Vous pourrez associer des enfants plus tard</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── BOUTONS D'ACTION ─────────────────────────────────
                         Empilés col-reverse sur mobile, côte à côte sur sm+
                    ──────────────────────────────────────────────────────── --}}
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 sm:gap-4 pt-5 sm:pt-6 border-t-2 border-gray-100">
                        <a href="{{ route('admin.parents.index') }}"
                           class="inline-flex items-center justify-center px-6 sm:px-8 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-sm">
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center px-6 sm:px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @keyframes float-1 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(10px,-10px)} }
    @keyframes float-2 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-15px,5px)} }
    @keyframes float-3 { 0%,100%{transform:translate(0,0) scale(1)} 50%{transform:translate(8px,8px) scale(1.1)} }
    @keyframes float-4 { 0%,100%{transform:translate(0,0)} 50%{transform:translate(-12px,-8px)} }
    .animate-float-1{animation:float-1 8s ease-in-out infinite}
    .animate-float-2{animation:float-2 10s ease-in-out infinite}
    .animate-float-3{animation:float-3 12s ease-in-out infinite}
    .animate-float-4{animation:float-4 9s ease-in-out infinite}

    @keyframes fadeInUp   { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
    @keyframes fadeInRight{ from{opacity:0;transform:translateX(-20px)} to{opacity:1;transform:translateX(0)} }
    .animate-fade-in-up   { animation: fadeInUp    0.8s ease-out forwards; }
    .animate-fade-in-right{ animation: fadeInRight 0.8s ease-out forwards; }
    .animation-delay-200  { animation-delay: 200ms; opacity: 0; }

    select:disabled { opacity: 0.5; cursor: not-allowed; }

    .overflow-y-auto::-webkit-scrollbar       { width: 6px; }
    .overflow-y-auto::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .overflow-y-auto::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
    .overflow-y-auto::-webkit-scrollbar-thumb:hover { background: #059669; }

    .group:hover input:not(:focus):not(:disabled),
    .group:hover select:not(:focus):not(:disabled),
    .group:hover textarea:not(:focus):not(:disabled) {
        border-color: #6ee7b7;
    }
</style>
@endpush

@push('scripts')
<script>
    // ── Alerte avant de quitter ─────────────────────────────────────
    let formModified = false;
    document.querySelectorAll('input, select, textarea').forEach(el => {
        el.addEventListener('change', () => formModified = true);
        el.addEventListener('keyup',  () => { if (['INPUT','TEXTAREA'].includes(el.tagName)) formModified = true; });
    });
    window.addEventListener('beforeunload', e => {
        if (formModified) { e.preventDefault(); e.returnValue = ''; }
    });
    document.querySelector('form').addEventListener('submit', () => formModified = false);

    // ── Gestion liens parentaux --────────────────────────────────────
    document.querySelectorAll('.eleve-checkbox').forEach(cb => {
        cb.addEventListener('change', function () {
            const select = this.closest('.flex, [class*="flex"]')?.querySelector('.lien-select');
            if (select) {
                select.disabled = !this.checked;
                if (!this.checked) select.value = 'pere';
            }
            updateProgressBar();
        });
    });

    // ── Prévisualisation photo ──────────────────────────────────────
    document.getElementById('photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('photoPreview').innerHTML =
                    `<img src="${e.target.result}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl object-cover">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // ── Aperçu du nom ──────────────────────────────────────────────
    function updatePreview() {
        const nom    = document.getElementById('nom').value;
        const prenom = document.getElementById('prenom').value;
        const section = document.getElementById('previewSection');
        if (nom || prenom) {
            section.classList.remove('hidden');
            document.getElementById('previewName').textContent = (prenom + ' ' + nom).trim() || 'Nouveau parent';
            document.getElementById('previewInitiales').textContent =
                ((prenom ? prenom[0] : '') + (nom ? nom[0] : '')).toUpperCase() || '?';
        } else {
            section.classList.add('hidden');
        }
    }
    document.getElementById('nom').addEventListener('input', updatePreview);
    document.getElementById('prenom').addEventListener('input', updatePreview);

    // ── Barre de progression ───────────────────────────────────────
    function updateProgressBar() {
        const required = document.querySelectorAll('[required]');
        const filled   = Array.from(required).filter(f => f.value && f.value.trim());
        document.getElementById('progressBar').style.width =
            Math.round((filled.length / required.length) * 100) + '%';
    }
    document.querySelectorAll('input, select').forEach(f => {
        f.addEventListener('change', updateProgressBar);
        f.addEventListener('keyup',  updateProgressBar);
    });

    // ── Validation téléphone ───────────────────────────────────────
    document.getElementById('telephone').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });
</script>
@endpush