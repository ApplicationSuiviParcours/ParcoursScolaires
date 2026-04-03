{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Modifier un utilisateur') }}
    </h2>
@endsection

@section('content')
    <div class="py-6 sm:py-8 md:py-12 overflow-x-hidden">
        <div class="max-w-4xl mx-auto px-3 sm:px-4 lg:px-6">
            <!-- Fil d'Ariane - Responsive -->
            <div class="mb-3 sm:mb-4 flex flex-wrap items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-gray-500 animate-fade-in">
                <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors">Utilisateurs</a>
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <a href="{{ route('admin.users.show', $user) }}" class="hover:text-blue-600 transition-colors truncate max-w-[120px] sm:max-w-none">{{ $user->name }}</a>
                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-700">Modifier</span>
            </div>

            <div class="bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- En-tête avec photo et informations - Responsive -->
                <div class="px-4 sm:px-5 md:px-6 py-4 sm:py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-3 sm:gap-4">
                        <!-- Photo de profil -->
                        <div class="relative group flex-shrink-0">
                            <div class="h-16 w-16 sm:h-18 sm:w-18 md:h-20 md:w-20 rounded-full overflow-hidden ring-4 ring-white shadow-xl transform group-hover:scale-105 transition-all duration-300">
                                @if($user->photo)
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold text-xl sm:text-2xl">
                                        {{ $user->initials }}
                                    </div>
                                @endif
                            </div>
                            <!-- Badge de statut -->
                            <div class="absolute -bottom-0.5 -right-0.5 h-4 w-4 sm:h-5 sm:w-5 md:h-6 md:w-6 rounded-full border-2 border-white 
                                {{ $user->is_active ? 'bg-green-400' : 'bg-red-400' }} group-hover:animate-pulse">
                            </div>
                            
                            <!-- Indicateur de modification de photo -->
                            <div class="absolute -top-1 -right-1 bg-yellow-400 rounded-full p-0.5 sm:p-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300" title="Modifier la photo">
                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <div class="flex-1 text-center sm:text-left min-w-0">
                            <h4 class="text-base sm:text-lg md:text-xl font-bold flex flex-wrap items-center justify-center sm:justify-start gap-1.5 sm:gap-2">
                                Modifier l'utilisateur
                                <span class="text-[10px] sm:text-xs bg-white/20 backdrop-blur-sm px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full">ID: #{{ $user->id }}</span>
                            </h4>
                            <p class="text-blue-100 flex flex-wrap items-center justify-center sm:justify-start gap-1.5 sm:gap-2 mt-1 text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="truncate">{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <span class="text-[9px] sm:text-xs bg-green-500 text-white px-1.5 py-0.5 rounded-full">Vérifié</span>
                                @else
                                    <span class="text-[9px] sm:text-xs bg-yellow-500 text-white px-1.5 py-0.5 rounded-full">Non vérifié</span>
                                @endif
                            </p>
                        </div>
                        
                        <!-- Bouton retour rapide - Masqué sur mobile -->
                        <a href="{{ route('admin.users.show', $user) }}" class="hidden sm:block p-1.5 sm:p-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors" title="Voir les détails">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <!-- Indicateur de progression -->
                    <div class="mt-2 sm:mt-3 flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs text-blue-100">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Les champs marqués d'une <span class="text-red-300">*</span> sont obligatoires</span>
                    </div>
                </div>

                <div class="p-4 sm:p-5 md:p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-4 sm:space-y-5 md:space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Photo de profil avec gestion complète - Responsive -->
                        <div class="mb-4 sm:mb-5 p-3 sm:p-4 md:p-5 bg-gradient-to-r from-gray-50 to-white rounded-lg sm:rounded-xl border-2 border-gray-200 hover:border-blue-300 transition-colors duration-300">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2 sm:mb-3">
                                <span class="flex items-center gap-1.5 sm:gap-2">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Photo de profil
                                </span>
                            </label>
                            
                            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-5 md:gap-6">
                                <!-- Aperçu de la photo actuelle -->
                                <div class="shrink-0">
                                    <div id="preview" class="h-20 w-20 sm:h-24 sm:w-24 md:h-28 md:w-28 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center border-4 border-white shadow-lg overflow-hidden">
                                        @if($user->photo)
                                            <img src="{{ $user->photo_url }}" class="h-full w-full object-cover" alt="Photo actuelle">
                                        @else
                                            <div class="h-full w-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold text-xl sm:text-2xl md:text-3xl">
                                                {{ $user->initials }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Statut de la photo -->
                                    <div class="text-center mt-1.5 sm:mt-2">
                                        @if($user->photo)
                                            <span class="text-[9px] sm:text-xs text-green-600 flex items-center justify-center gap-0.5 sm:gap-1">
                                                <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Photo existante
                                            </span>
                                        @else
                                            <span class="text-[9px] sm:text-xs text-gray-400">Pas de photo</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Options de gestion de photo -->
                                <div class="flex-1 space-y-3 sm:space-y-4">
                                    <div class="flex flex-wrap justify-center sm:justify-start gap-2 sm:gap-3">
                                        <!-- Bouton Changer la photo -->
                                        <label class="cursor-pointer group">
                                            <span class="inline-flex items-center px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5 bg-white border-2 border-gray-300 border-dashed rounded-lg sm:rounded-xl font-medium text-[10px] sm:text-xs md:text-sm text-gray-700 hover:border-blue-500 hover:bg-blue-50 transition-all duration-300 group-hover:scale-105 transform shadow-sm">
                                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 text-gray-500 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                                </svg>
                                                Changer
                                            </span>
                                            <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                                        </label>
                                        
                                        <!-- Bouton Supprimer la photo (si existe) -->
                                        @if($user->photo)
                                            <label class="cursor-pointer group">
                                                <span class="inline-flex items-center px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5 bg-red-50 border-2 border-red-200 rounded-lg sm:rounded-xl font-medium text-[10px] sm:text-xs md:text-sm text-red-600 hover:bg-red-100 hover:border-red-300 transition-all duration-300 group-hover:scale-105 transform">
                                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Supprimer
                                                </span>
                                                <input type="checkbox" name="remove_photo" id="remove_photo" value="1" class="hidden">
                                            </label>
                                        @endif
                                        
                                        <!-- Lien vers la vue détaillée -->
                                        <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5 bg-gray-100 border-2 border-gray-200 rounded-lg sm:rounded-xl font-medium text-[10px] sm:text-xs md:text-sm text-gray-600 hover:bg-gray-200 transition-all duration-300 group">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Voir
                                        </a>
                                    </div>
                                    
                                    <div class="bg-blue-50 p-2 sm:p-2.5 md:p-3 rounded-lg border border-blue-100">
                                        <p class="text-[9px] sm:text-xs text-blue-700 flex items-center gap-1.5 sm:gap-2">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Formats : JPG, PNG, GIF (max. 2MB)
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            @error('photo')
                                <p class="text-red-500 text-[10px] sm:text-xs mt-2 flex items-center gap-1 bg-red-50 p-1.5 sm:p-2 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Informations personnelles - Responsive Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Nom complet - pleine largeur sur mobile -->
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Nom complet <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       class="w-full px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-sm sm:text-base @error('name') border-red-500 @enderror"
                                       placeholder="Jean Dupont">
                                @error('name')
                                    <p class="text-red-500 text-[10px] sm:text-xs mt-1 flex items-center gap-1">
                                        <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-span-1 md:col-span-1">
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    <span class="flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Email <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full px-3 sm:px-4 py-2 sm:py-2.5 md:py-3 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-sm sm:text-base @error('email') border-red-500 @enderror"
                                       placeholder="jean.dupont@exemple.com">
                                @error('email')
                                    <p class="text-red-500 text-[10px] sm:text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut email vérifié (admin only) -->
                            @if(auth()->user()->isAdmin())
                                <div class="col-span-1 md:col-span-1">
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                        <span class="flex items-center gap-1.5 sm:gap-2">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Vérification email
                                        </span>
                                    </label>
                                    <div class="flex flex-wrap items-center gap-2 p-2 sm:p-3 bg-gray-50 border-2 border-gray-200 rounded-lg sm:rounded-xl">
                                        <input type="checkbox" 
                                               name="email_verified" 
                                               id="email_verified" 
                                               value="1" 
                                               {{ $user->email_verified_at ? 'checked' : '' }}
                                               class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <label for="email_verified" class="text-[10px] sm:text-xs text-gray-700">
                                            Marquer comme vérifié
                                        </label>
                                        @if($user->email_verified_at)
                                            <span class="text-[8px] sm:text-[9px] text-gray-500 ml-auto">
                                                ({{ $user->email_verified_at->format('d/m/Y') }})
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Section Mot de passe (optionnel) - Responsive -->
                        <div class="p-3 sm:p-4 md:p-5 bg-gray-50 rounded-lg sm:rounded-xl border-2 border-gray-200">
                            <h4 class="text-xs sm:text-sm font-semibold text-gray-700 mb-2 sm:mb-3 flex flex-wrap items-center gap-1.5 sm:gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Changer le mot de passe
                                <span class="text-[9px] sm:text-xs font-normal text-gray-500 ml-0 sm:ml-2">(Laissez vide pour conserver l'actuel)</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <!-- Nouveau mot de passe -->
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-medium text-gray-700 mb-1">
                                        Nouveau mot de passe
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="password" 
                                               id="password" 
                                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 md:py-2.5 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-sm sm:text-base @error('password') border-red-500 @enderror"
                                               placeholder="••••••••">
                                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-2 sm:right-3 top-1.5 sm:top-2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div>
                                    <label class="block text-[10px] sm:text-xs font-medium text-gray-700 mb-1">
                                        Confirmer le mot de passe
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="password_confirmation" 
                                               id="password_confirmation" 
                                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 md:py-2.5 border-2 border-gray-200 rounded-lg sm:rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all duration-300 text-sm sm:text-base"
                                               placeholder="••••••••">
                                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute right-2 sm:right-3 top-1.5 sm:top-2 text-gray-400 hover:text-gray-600">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="password-match-indicator" class="text-[9px] sm:text-xs mt-1 hidden"></div>
                                </div>
                            </div>
                            
                            @error('password')
                                <p class="text-red-500 text-[10px] sm:text-xs mt-2">{{ $message }}</p>
                            @enderror
                            
                            <!-- Indicateur de force du mot de passe -->
                            <div class="mt-2 sm:mt-3 p-2 sm:p-3 bg-white rounded-lg border border-gray-200">
                                <p class="text-[9px] sm:text-xs text-gray-600 mb-1.5">Force du mot de passe :</p>
                                <div class="flex gap-1 h-1">
                                    <div id="strength-1" class="flex-1 bg-gray-200 rounded-l-full"></div>
                                    <div id="strength-2" class="flex-1 bg-gray-200"></div>
                                    <div id="strength-3" class="flex-1 bg-gray-200"></div>
                                    <div id="strength-4" class="flex-1 bg-gray-200 rounded-r-full"></div>
                                </div>
                                <p id="strength-text" class="text-[9px] sm:text-xs text-gray-500 mt-1"></p>
                            </div>
                        </div>

                        <!-- Rôles (multiples) - Responsive -->
                        <div class="p-3 sm:p-4 md:p-5 bg-gray-50 rounded-lg sm:rounded-xl border-2 border-gray-200">
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2 sm:mb-3">
                                <span class="flex items-center gap-1.5 sm:gap-2">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 md:w-5 md:h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    Rôles et permissions <span class="text-red-500">*</span>
                                </span>
                                <span class="text-[9px] sm:text-xs text-gray-500 ml-1 sm:ml-2">Sélectionnez un ou plusieurs rôles</span>
                            </label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                                @foreach($roles as $role)
                                    @php
                                        $isChecked = in_array($role->id, old('roles', $userRoles ?? []));
                                    @endphp
                                    <label class="relative flex items-start p-2 sm:p-3 border-2 rounded-lg sm:rounded-xl cursor-pointer transition-all duration-300 group
                                        {{ $isChecked ? 'border-blue-500 bg-blue-50' : 'border-gray-200 bg-white hover:border-blue-300 hover:bg-blue-50/50' }}">
                                        <input type="checkbox" 
                                               name="roles[]" 
                                               value="{{ $role->id }}" 
                                               class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-0.5"
                                               {{ $isChecked ? 'checked' : '' }}>
                                        <div class="ml-2 sm:ml-3 flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center justify-between gap-1">
                                                <span class="text-[10px] sm:text-xs font-medium text-gray-700 group-hover:text-blue-600 transition-colors">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                                <span class="text-[8px] sm:text-[9px] px-1.5 py-0.5 rounded-full 
                                                    @if($role->name == 'administrateur') bg-purple-100 text-purple-800
                                                    @elseif($role->name == 'enseignant') bg-blue-100 text-blue-800
                                                    @elseif($role->name == 'eleve') bg-green-100 text-green-800
                                                    @elseif($role->name == 'parent') bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    @if($role->name == 'administrateur') Accès total
                                                    @elseif($role->name == 'enseignant') Gestion cours
                                                    @elseif($role->name == 'eleve') Consultation
                                                    @elseif($role->name == 'parent') Suivi
                                                    @endif
                                                </span>
                                            </div>
                                            <p class="text-[8px] sm:text-[9px] text-gray-500 mt-0.5 hidden sm:block">
                                                @if($role->name == 'administrateur')
                                                    Tous les droits d'administration
                                                @elseif($role->name == 'enseignant')
                                                    Gestion des cours, notes et présence
                                                @elseif($role->name == 'eleve')
                                                    Consultation des cours et notes
                                                @elseif($role->name == 'parent')
                                                    Suivi des élèves associés
                                                @endif
                                            </p>
                                        </div>
                                        
                                        <!-- Checkmark animé -->
                                        @if($isChecked)
                                            <div class="absolute -top-1 -right-1 w-4 h-4 sm:w-5 sm:h-5 bg-blue-500 rounded-full flex items-center justify-center text-white text-[8px] sm:text-[9px]">
                                                <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                            
                            @error('roles')
                                <p class="text-red-500 text-[10px] sm:text-xs mt-2 bg-red-50 p-1.5 sm:p-2 rounded-lg">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Options supplémentaires - Responsive -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Statut actif -->
                            <div class="flex items-start p-2.5 sm:p-3 border-2 border-gray-200 rounded-lg sm:rounded-xl hover:border-green-500 transition-all duration-300 cursor-pointer bg-white" onclick="document.getElementById('is_active').click()">
                                <input type="checkbox" 
                                       name="is_active" 
                                       id="is_active" 
                                       value="1" 
                                       {{ $user->is_active ? 'checked' : '' }}
                                       class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer mt-0.5">
                                <div class="ml-2 sm:ml-3">
                                    <label for="is_active" class="text-[10px] sm:text-xs font-medium text-gray-700 cursor-pointer">
                                        Compte actif
                                    </label>
                                    <p class="text-[8px] sm:text-[9px] text-gray-500">L'utilisateur peut se connecter</p>
                                </div>
                            </div>

                            <!-- Dernière connexion (info only) -->
                            <div class="flex items-center p-2.5 sm:p-3 bg-gray-50 border-2 border-gray-200 rounded-lg sm:rounded-xl">
                                <div class="p-1.5 sm:p-2 bg-blue-100 rounded-lg">
                                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3">
                                    <span class="text-[8px] sm:text-[9px] text-gray-500">Dernière connexion</span>
                                    <p class="text-[10px] sm:text-xs font-medium text-gray-900">
                                        {{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais connecté' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Dates d'audit - Responsive -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg sm:rounded-xl border border-blue-200">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="p-1.5 sm:p-2 bg-blue-200 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[8px] sm:text-[9px] text-blue-600">Créé le</p>
                                    <p class="text-[10px] sm:text-xs font-semibold text-blue-900">{{ $user->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="p-1.5 sm:p-2 bg-indigo-200 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[8px] sm:text-[9px] text-indigo-600">Dernière mise à jour</p>
                                    <p class="text-[10px] sm:text-xs font-semibold text-indigo-900">{{ $user->updated_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="p-1.5 sm:p-2 bg-purple-200 rounded-lg">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[8px] sm:text-[9px] text-purple-600">Créé par</p>
                                    <p class="text-[10px] sm:text-xs font-semibold text-purple-900">Administrateur</p>
                                </div>
                            </div>
                        </div>

                        <!-- Avertissements - Responsive -->
                        @if($user->isAdmin() && auth()->id() == $user->id)
                            <div class="p-2.5 sm:p-3 md:p-4 bg-yellow-50 border-2 border-yellow-200 rounded-lg sm:rounded-xl">
                                <div class="flex items-start gap-2 sm:gap-3">
                                    <div class="p-1 sm:p-1.5 bg-yellow-100 rounded-lg">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] sm:text-xs font-medium text-yellow-800">Vous modifiez votre propre compte</p>
                                        <p class="text-[8px] sm:text-[9px] text-yellow-700 mt-0.5">Attention : Si vous retirez votre rôle d'administrateur, vous pourriez perdre l'accès à certaines fonctionnalités.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($user->isAdmin() && $adminCount == 1 && auth()->id() == $user->id)
                            <div class="p-2.5 sm:p-3 md:p-4 bg-red-50 border-2 border-red-200 rounded-lg sm:rounded-xl">
                                <div class="flex items-start gap-2 sm:gap-3">
                                    <div class="p-1 sm:p-1.5 bg-red-100 rounded-lg">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] sm:text-xs font-medium text-red-800">Dernier administrateur</p>
                                        <p class="text-[8px] sm:text-[9px] text-red-700 mt-0.5">Vous êtes le dernier administrateur. Vous ne pouvez pas retirer votre rôle d'administrateur ni désactiver votre compte.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Boutons d'action - Responsive -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 sm:gap-3 pt-4 sm:pt-5 md:pt-6 border-t-2 border-gray-200">
                            <a href="{{ route('admin.users.index') }}" 
                               class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-1.5 sm:gap-2 order-2 sm:order-1 text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Annuler
                            </a>
                            
                            <button type="submit" 
                                    class="w-full sm:w-auto px-5 sm:px-6 md:px-8 py-2 sm:py-2.5 md:py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-1.5 sm:gap-2 order-1 sm:order-2 text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mettre à jour
                            </button>
                            
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-2 sm:py-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg sm:rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-1.5 sm:gap-2 order-3 text-xs sm:text-sm">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Voir
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Fonction pour prévisualiser l'image avant upload
    function previewImage(input) {
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" alt="Aperçu">`;
                
                // Ajouter une animation
                preview.classList.add('animate-pulse');
                setTimeout(() => {
                    preview.classList.remove('animate-pulse');
                }, 1000);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Fonction pour afficher/masquer le mot de passe
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
    }

    // Gestion de la suppression de photo
    document.addEventListener('DOMContentLoaded', function() {
        const removePhotoCheckbox = document.querySelector('input[name="remove_photo"]');
        const photoInput = document.getElementById('photo');
        
        if (removePhotoCheckbox) {
            const removeLabel = removePhotoCheckbox.closest('label');
            
            removeLabel.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')) {
                    removePhotoCheckbox.checked = true;
                    
                    // Afficher un indicateur visuel
                    const preview = document.getElementById('preview');
                    preview.innerHTML = `
                        <div class="h-full w-full bg-gradient-to-br from-red-200 to-red-300 flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                    `;
                    
                    // Désactiver le bouton
                    removeLabel.classList.add('opacity-50', 'cursor-not-allowed');
                    removeLabel.style.pointerEvents = 'none';
                }
            });
        }

        // Validation en temps réel du mot de passe
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        const matchIndicator = document.getElementById('password-match-indicator');
        
        if (password && passwordConfirm) {
            function checkPasswordMatch() {
                if (password.value || passwordConfirm.value) {
                    matchIndicator.classList.remove('hidden');
                    
                    if (password.value === passwordConfirm.value && password.value !== '') {
                        passwordConfirm.classList.remove('border-red-500');
                        passwordConfirm.classList.add('border-green-500');
                        matchIndicator.innerHTML = '<span class="text-green-600 flex items-center gap-0.5"><svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Les mots de passe correspondent</span>';
                    } else if (password.value !== passwordConfirm.value && passwordConfirm.value !== '') {
                        passwordConfirm.classList.remove('border-green-500');
                        passwordConfirm.classList.add('border-red-500');
                        matchIndicator.innerHTML = '<span class="text-red-600 flex items-center gap-0.5"><svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Les mots de passe ne correspondent pas</span>';
                    } else {
                        matchIndicator.innerHTML = '';
                    }
                } else {
                    matchIndicator.classList.add('hidden');
                }
            }
            
            password.addEventListener('keyup', checkPasswordMatch);
            passwordConfirm.addEventListener('keyup', checkPasswordMatch);
        }

        // Indicateur de force du mot de passe
        if (password) {
            password.addEventListener('keyup', function() {
                const value = this.value;
                const strengthBars = [
                    document.getElementById('strength-1'),
                    document.getElementById('strength-2'),
                    document.getElementById('strength-3'),
                    document.getElementById('strength-4')
                ];
                const strengthText = document.getElementById('strength-text');
                
                // Réinitialiser
                strengthBars.forEach(bar => {
                    bar.classList.remove('bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500');
                    bar.classList.add('bg-gray-200');
                });
                
                if (value.length === 0) {
                    strengthText.innerHTML = '';
                    return;
                }
                
                let strength = 0;
                
                // Critères de force
                if (value.length >= 8) strength++;
                if (value.match(/[a-z]+/)) strength++;
                if (value.match(/[A-Z]+/)) strength++;
                if (value.match(/[0-9]+/)) strength++;
                if (value.match(/[$@#&!]+/)) strength++;
                
                // Ajuster pour 4 barres
                strength = Math.min(4, Math.floor(strength * 0.8));
                
                // Couleurs et texte
                const colors = ['red-500', 'orange-500', 'yellow-500', 'green-500'];
                const texts = ['Très faible', 'Faible', 'Moyen', 'Fort', 'Très fort'];
                
                for (let i = 0; i < strength; i++) {
                    strengthBars[i].classList.remove('bg-gray-200');
                    strengthBars[i].classList.add(`bg-${colors[strength-1]}`);
                }
                
                strengthText.innerHTML = `<span class="text-${colors[strength-1]}">${texts[strength]}</span>`;
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    /* Styles pour éviter le débordement horizontal */
    * {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    body, html {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
    
    .overflow-x-hidden {
        overflow-x: hidden !important;
    }
    
    @keyframes fade-in {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    /* Animation pour les champs de formulaire */
    input, select, textarea, button, a {
        transition: all 0.3s ease;
    }

    /* Style pour l'aperçu de l'image */
    #preview {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    #preview img {
        transition: transform 0.5s ease;
    }

    #preview:hover img {
        transform: scale(1.1);
    }

    /* Animation pour les checkboxes */
    input[type="checkbox"] {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    input[type="checkbox"]:checked {
        transform: scale(1.1);
    }

    /* Animation pour les labels des rôles */
    .grid label {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .grid label:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .max-w-4xl {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        .py-12 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        .text-sm {
            font-size: 0.7rem;
        }
        
        .text-xs {
            font-size: 0.6rem;
        }
    }
</style>
@endpush