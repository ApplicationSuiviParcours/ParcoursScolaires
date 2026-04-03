@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-base md:text-xl text-gray-800 leading-tight">
        {{ __('Ajouter un élève') }}
    </h2>
@endsection

@section('content')
<div class="py-4 md:py-8 lg:py-12">
    <div class="max-w-4xl mx-auto px-2 sm:px-4 lg:px-8">

        <!-- Messages flash -->
        @if(session('error'))
            <div class="mb-3 md:mb-4 p-3 md:p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-lg shadow text-xs md:text-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- En-tête avec progression -->
        <div class="mb-4 md:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 mb-2">
                <h3 class="text-base md:text-lg font-medium text-gray-700">Nouvel élève</h3>
                <span class="text-[10px] md:text-sm text-gray-500">Formulaire d'inscription</span>
            </div>
            <div class="w-full bg-gray-200 h-0.5">
                <div class="bg-indigo-600 h-0.5 w-full"></div>
            </div>
        </div>

        <!-- Formulaire principal -->
        <div class="bg-white shadow-lg overflow-hidden border border-gray-200 rounded-lg md:rounded-xl">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 md:px-6 py-3 md:py-4">
                <div class="flex items-center">
                    <div class="bg-indigo-500 p-1.5 md:p-2 rounded-lg">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h3 class="text-base md:text-lg font-bold text-white">Inscription</h3>
                        <p class="text-indigo-200 text-[10px] md:text-sm">Champs * obligatoires</p>
                    </div>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-4 md:p-6 lg:p-8">
                <form method="POST" action="{{ route('admin.eleves.store') }}" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
                    @csrf

                    <!-- Matricule -->
                    <div class="bg-indigo-50 border border-indigo-200 p-3 md:p-4 rounded-lg">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg self-start sm:self-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <div class="flex-1 w-full">
                                <label class="block text-[10px] md:text-xs font-semibold text-indigo-800 uppercase tracking-wider mb-1">Matricule</label>
                                <input type="text" name="matricule" id="matricule" value="{{ old('matricule', $matricule_genere) }}" readonly
                                       class="block w-full px-3 py-2 bg-white border border-indigo-300 text-indigo-900 font-mono text-xs md:text-sm cursor-not-allowed rounded-lg">
                                <p class="mt-1 text-[10px] text-indigo-600 hidden sm:block">Format: {{ date('Y') }}[Lettre][Numéro] (ex: 2025D0001)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Identité -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-600 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Identité</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Nom <span class="text-red-500">*</span></label>
                                <input type="text" name="nom" id="nom" required placeholder="DIOP"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('nom') border-red-500 @enderror" value="{{ old('nom') }}">
                                @error('nom')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Prénom <span class="text-red-500">*</span></label>
                                <input type="text" name="prenom" id="prenom" required placeholder="Mamadou"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('prenom') border-red-500 @enderror" value="{{ old('prenom') }}">
                                @error('prenom')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Genre <span class="text-red-500">*</span></label>
                                <select name="genre" id="genre" required class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('genre') border-red-500 @enderror">
                                    <option value="" disabled selected>Sélectionner</option>
                                    <option value="m" {{ old('genre') == 'm' ? 'selected' : '' }}>Masculin</option>
                                    <option value="f" {{ old('genre') == 'f' ? 'selected' : '' }}>Féminin</option>
                                </select>
                                @error('genre')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Date de naissance -->
                            <div>
                                <label for="date_naissance" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Date naiss. <span class="text-red-500">*</span></label>
                                <input type="date" name="date_naissance" id="date_naissance" required
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('date_naissance') border-red-500 @enderror" value="{{ old('date_naissance') }}">
                                @error('date_naissance')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Origine -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-400 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Origine</h4>
                        </div>
                        <div>
                            <label for="lieu_naissance" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Lieu de naissance <span class="text-red-500">*</span></label>
                            <input type="text" name="lieu_naissance" id="lieu_naissance" required placeholder="Dakar"
                                   class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('lieu_naissance') border-red-500 @enderror" value="{{ old('lieu_naissance') }}">
                            @error('lieu_naissance')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Section Contact -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-500 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Coordonnées</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="telephone" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Téléphone</label>
                                <input type="tel" name="telephone" id="telephone" placeholder="77 123 45 67"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1" value="{{ old('telephone') }}">
                            </div>
                            <div>
                                <label for="email" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="email" placeholder="eleve@exemple.com"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1" value="{{ old('email') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section Inscription -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Inscription</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="classe_inscription_id" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Classe</label>
                                <select name="classe_inscription_id" id="classe_inscription_id" class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1">
                                    <option value="">Sélectionner (optionnel)</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_inscription_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Année scolaire</label>
                                <div class="px-3 md:px-4 py-2.5 md:py-3 bg-gray-50 border rounded-lg text-xs md:text-sm text-gray-700">
                                    {{ $anneeScolaireActive->nom ?? 'Non définie' }}
                                </div>
                            </div>
                        </div>
                        <!-- Info Note -->
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg text-[10px] md:text-xs text-blue-700">
                            <span class="font-semibold">Note :</span> Si vous sélectionnez une classe, une inscription sera créée automatiquement.
                        </div>
                    </div>

                    <!-- Section Photo -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Photo</h4>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start gap-4">
                            <div class="flex items-center justify-center w-16 h-16 md:w-20 md:h-20 bg-gray-100 border rounded-lg overflow-hidden flex-shrink-0" id="photo-preview">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1 w-full">
                                <input type="file" name="photo" id="photo" accept="image/*" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-[10px] text-gray-500">Formats : JPEG, PNG (max. 2 Mo)</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section Adresse -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Résidence</h4>
                        </div>
                        <div>
                            <label for="adresse" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Adresse <span class="text-red-500">*</span></label>
                            <textarea name="adresse" id="adresse" rows="2" required placeholder="123 Rue Liberté, Dakar"
                                      class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1">{{ old('adresse') }}</textarea>
                            @error('adresse')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Section Compte utilisateur -->
                    <div class="p-3 md:p-4 bg-gray-50 border rounded-lg">
                        <div class="flex items-start">
                            <input type="checkbox" name="create_user" id="create_user" value="1" {{ old('create_user') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded mt-0.5">
                            <label for="create_user" class="ml-2 block text-xs md:text-sm text-gray-900">
                                Créer un compte utilisateur pour cet élève
                            </label>
                        </div>

                        <!-- Password Fields -->
                        <div id="password_fields" class="{{ old('create_user') ? '' : 'hidden' }} mt-4 space-y-3">
                            <div>
                                <label for="password" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Mot de passe <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password" class="block w-full px-3 md:px-4 py-2 md:py-2.5 border rounded-lg text-xs md:text-sm">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Confirmer <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-3 md:px-4 py-2 md:py-2.5 border rounded-lg text-xs md:text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row justify-end gap-2 md:gap-3 pt-4 md:pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleves.index') }}"
                           class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 bg-white border text-center text-gray-700 hover:bg-gray-50 text-xs md:text-sm font-medium rounded-lg transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 bg-indigo-600 text-white hover:bg-indigo-700 text-xs md:text-sm font-medium rounded-lg shadow-sm">
                            Enregistrer l'élève
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const createUserCheckbox = document.getElementById('create_user');
    const passwordFields = document.getElementById('password_fields');

    // Photo Preview
    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Toggle Password Fields
    if (createUserCheckbox && passwordFields) {
        createUserCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.classList.remove('hidden');
            } else {
                passwordFields.classList.add('hidden');
            }
        });
    }
});
</script>
@endpush
@endsection
