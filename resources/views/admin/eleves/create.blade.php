@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ajouter un élève') }}
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

        <!-- En-tête avec progression -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-lg font-medium text-gray-700">Nouvel élève</h3>
                <span class="text-sm text-gray-500">Formulaire d'inscription</span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-bold text-white">Inscription d'un nouvel élève</h3>
                        <p class="text-indigo-200 text-sm">Tous les champs marqués d'un * sont obligatoires</p>
                    </div>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-8">
                <form method="POST" action="{{ route('admin.eleves.store') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <!-- Matricule (généré automatiquement) - NOUVEAU FORMAT -->
                    <div class="bg-indigo-50 border border-indigo-200 p-4 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-indigo-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <label class="block text-xs font-semibold text-indigo-800 uppercase tracking-wider mb-1">
                                    Matricule
                                </label>
                                <div class="flex items-center">
                                    <input type="text" 
                                           name="matricule" 
                                           id="matricule" 
                                           value="{{ old('matricule', $matricule_genere) }}" 
                                           readonly
                                           class="block w-full px-3 py-2 bg-white border border-indigo-300 text-indigo-900 font-mono text-sm cursor-not-allowed rounded-lg">
                                    <span class="ml-2 text-xs text-indigo-600 whitespace-nowrap">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Généré automatiquement
                                    </span>
                                </div>
                                <p class="mt-1 text-xs text-indigo-600">Format: <span class="font-mono bg-indigo-100 px-1 py-0.5 rounded">{{ date('Y') }}[Lettre][Numéro]</span> (ex: 2025D0001) - Unique et non modifiable</p>
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
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Nom <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" required
                                       placeholder="DIOP"
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('nom') border-red-500 @enderror"
                                       value="{{ old('nom') }}">
                                <p class="mt-1 text-xs text-gray-500">Nom de famille (en majuscules)</p>
                                @error('nom')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Prénom <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" name="prenom" id="prenom" required
                                       placeholder="Mamadou"
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('prenom') border-red-500 @enderror"
                                       value="{{ old('prenom') }}">
                                <p class="mt-1 text-xs text-gray-500">Prénom usuel</p>
                                @error('prenom')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Genre <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select name="genre" id="genre" required
                                        class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('genre') border-red-500 @enderror">
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="m" {{ old('genre') == 'm' ? 'selected' : '' }}>Masculin</option>
                                    <option value="f" {{ old('genre') == 'f' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Sexe de l'élève</p>
                                @error('genre')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date de naissance -->
                            <div>
                                <label for="date_naissance" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Date de naissance <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="date" name="date_naissance" id="date_naissance" required
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('date_naissance') border-red-500 @enderror"
                                       value="{{ old('date_naissance') }}">
                                <p class="mt-1 text-xs text-gray-500">Format: JJ/MM/AAAA</p>
                                @error('date_naissance')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Naissance (suite) -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-400 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Origine</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Lieu de naissance -->
                            <div class="md:col-span-2">
                                <label for="lieu_naissance" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Lieu de naissance <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" name="lieu_naissance" id="lieu_naissance" required
                                       placeholder="Dakar, Sénégal"
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('lieu_naissance') border-red-500 @enderror"
                                       value="{{ old('lieu_naissance') }}">
                                <p class="mt-1 text-xs text-gray-500">Ville et pays de naissance</p>
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
                                <input type="tel" name="telephone" id="telephone"
                                       placeholder="77 123 45 67"
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('telephone') border-red-500 @enderror"
                                       value="{{ old('telephone') }}">
                                <p class="mt-1 text-xs text-gray-500">Portable ou fixe</p>
                                @error('telephone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Email
                                </label>
                                <input type="email" name="email" id="email"
                                       placeholder="eleve@exemple.com"
                                       class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('email') border-red-500 @enderror"
                                       value="{{ old('email') }}">
                                <p class="mt-1 text-xs text-gray-500">Adresse email valide</p>
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Inscription (MODIFIÉE) -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Inscription</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Classe pour l'inscription -->
                            <div>
                                <label for="classe_inscription_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Classe d'inscription
                                </label>
                                <select name="classe_inscription_id" id="classe_inscription_id"
                                        class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('classe_inscription_id') border-red-500 @enderror">
                                    <option value="">Sélectionner une classe (optionnel)</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_inscription_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom_complet ?? $classe->nom }} - {{ $classe->niveau }} @if($classe->serie)({{ $classe->serie }})@endif
                                        </option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Classe dans laquelle inscrire l'élève (une inscription sera créée)</p>
                                @error('classe_inscription_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Année scolaire (info) -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Année scolaire
                                </label>
                                <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-700">
                                    {{ $anneeScolaireActive->nom ?? 'Non définie' }}
                                    @if(!$anneeScolaireActive)
                                        <span class="text-xs text-red-500 block">Aucune année scolaire active trouvée</span>
                                    @endif
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Année scolaire pour l'inscription</p>
                            </div>
                        </div>

                        <!-- Message d'information sur l'inscription -->
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs text-blue-700">
                                    <span class="font-semibold">Note :</span> Si vous sélectionnez une classe, une inscription sera automatiquement créée pour l'élève dans l'année scolaire en cours. 
                                    L'élève pourra être réinscrit dans d'autres classes ultérieurement.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Photo -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Photo</h4>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Photo -->
                            <div>
                                <label for="photo" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                    Photo d'identité
                                </label>
                                <div class="mt-1 flex items-center space-x-4">
                                    <div class="flex items-center justify-center w-20 h-20 bg-gray-100 border border-gray-300 rounded-lg overflow-hidden" id="photo-preview">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="photo" id="photo" accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('photo') border-red-500 @enderror">
                                        <p class="mt-1 text-xs text-gray-500">Formats acceptés : JPEG, PNG, JPG, GIF (max. 2 Mo)</p>
                                    </div>
                                </div>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
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
                            <textarea name="adresse" id="adresse" rows="3" required
                                      placeholder="123 Rue Liberté, Dakar"
                                      class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('adresse') border-red-500 @enderror">{{ old('adresse') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Adresse complète avec ville et quartier</p>
                            @error('adresse')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section Compte utilisateur -->
                    <div>
                        <div class="flex items-center mb-4 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-6 mr-3 rounded-full"></div>
                            <h4 class="text-md font-semibold text-gray-800 uppercase tracking-wide">Compte utilisateur</h4>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Créer un compte -->
                            <div class="flex items-center">
                                <input type="checkbox" name="create_user" id="create_user" value="1" {{ old('create_user') ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="create_user" class="ml-2 block text-sm text-gray-900">
                                    Créer un compte utilisateur pour cet élève
                                </label>
                            </div>

                            <!-- Mot de passe (affiché conditionnellement) -->
                            <div id="password_fields" class="{{ old('create_user') ? '' : 'hidden' }} space-y-4">
                                <div>
                                    <label for="password" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                        Mot de passe <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="password" name="password" id="password"
                                           class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg @error('password') border-red-500 @enderror">
                                    <p class="mt-1 text-xs text-gray-500">Minimum 6 caractères</p>
                                    @error('password')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1">
                                        Confirmer le mot de passe <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="block w-full px-4 py-3 border border-gray-300 bg-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm rounded-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleves.index') }}" 
                           class="px-6 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 text-sm font-medium rounded-lg transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-6 py-3 bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-sm font-medium rounded-lg transition-colors shadow-lg shadow-indigo-200">
                            Enregistrer l'élève
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
                        <span class="font-semibold">Information :</span> Le matricule est généré automatiquement au format <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ date('Y') }}[Lettre][Numéro]</span> (ex: 2025D0001). 
                        Les champs marqués d'un <span class="text-red-500 font-bold">*</span> sont obligatoires. La photo est optionnelle.
                        @if($anneeScolaireActive)
                            <br>Si vous sélectionnez une classe, l'élève sera inscrit dans l'année scolaire <span class="font-semibold">{{ $anneeScolaireActive->nom }}</span>.
                        @endif
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
    const photoPreview = document.getElementById('photo-preview');
    const createUserCheckbox = document.getElementById('create_user');
    const passwordFields = document.getElementById('password_fields');
    
    // Aperçu photo
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            } else {
                photoPreview.innerHTML = `<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>`;
            }
        });
    }
    
    // Affichage conditionnel des champs de mot de passe
    if (createUserCheckbox && passwordFields) {
        createUserCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.classList.remove('hidden');
                document.getElementById('password').setAttribute('required', 'required');
                document.getElementById('password_confirmation').setAttribute('required', 'required');
            } else {
                passwordFields.classList.add('hidden');
                document.getElementById('password').removeAttribute('required');
                document.getElementById('password_confirmation').removeAttribute('required');
            }
        });
    }
});
</script>
@endpush
@endsection