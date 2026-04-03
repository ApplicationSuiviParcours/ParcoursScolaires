@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-base md:text-xl text-gray-800 leading-tight">
        {{ __('Modifier un élève') }}
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

        @if(session('success'))
            <div class="mb-3 md:mb-4 p-3 md:p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow text-xs md:text-sm" role="alert">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- En-tête -->
        <div class="mb-4 md:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 mb-2">
                <h3 class="text-base md:text-lg font-medium text-gray-700">Modification élève</h3>
                <span class="text-[10px] md:text-sm text-gray-500">Formulaire de modification</span>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <h3 class="text-base md:text-lg font-bold text-white">Modifier l'élève</h3>
                        <p class="text-indigo-200 text-[10px] md:text-sm">{{ $eleve->nom }} {{ $eleve->prenom }} - <span class="font-mono">{{ $eleve->matricule }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Corps du formulaire -->
            <div class="p-4 md:p-6 lg:p-8">
                <form method="POST" action="{{ route('admin.eleves.update', $eleve) }}" enctype="multipart/form-data" class="space-y-6 md:space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Section Photo actuelle -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Photo</h4>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 md:gap-6">
                            <div class="flex items-center gap-4">
                                <!-- Photo actuelle -->
                                <div class="flex-shrink-0" id="photo-container">
                                    @if($eleve->photo)
                                        <img src="{{ Storage::url($eleve->photo) }}" alt="{{ $eleve->prenom }}" class="w-16 h-16 md:w-24 md:h-24 rounded-lg object-cover border-2 border-indigo-200 shadow" id="photo-preview">
                                    @else
                                        <div class="w-16 h-16 md:w-24 md:h-24 rounded-lg bg-gray-100 flex items-center justify-center border-2 border-indigo-100 shadow" id="photo-preview">
                                            <span class="text-xl md:text-3xl font-bold text-indigo-400">
                                                {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-xs md:text-sm font-medium text-gray-700">Photo actuelle</p>
                                    <p class="text-[10px] md:text-xs text-gray-500 mt-1 hidden sm:block">Laissez vide pour conserver</p>
                                </div>
                            </div>

                            <!-- Upload nouvelle photo -->
                            <div class="flex-1 w-full">
                                <label for="photo" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Nouvelle photo</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="mt-1 text-[10px] text-gray-500">Formats : JPEG, PNG (max. 2 Mo)</p>
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
                            <!-- Matricule -->
                            <div>
                                <label for="matricule" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Matricule</label>
                                <input type="text" name="matricule" id="matricule" value="{{ $eleve->matricule }}" required readonly
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 bg-gray-50 border text-gray-500 text-xs md:text-sm cursor-not-allowed rounded-lg">
                                <p class="mt-1 text-[10px] text-gray-500">Non modifiable</p>
                            </div>

                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Nom <span class="text-red-500">*</span></label>
                                <input type="text" name="nom" id="nom" required placeholder="DIOP"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('nom') border-red-500 @enderror" value="{{ old('nom', $eleve->nom) }}">
                                @error('nom')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Prénom <span class="text-red-500">*</span></label>
                                <input type="text" name="prenom" id="prenom" required placeholder="Mamadou"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('prenom') border-red-500 @enderror" value="{{ old('prenom', $eleve->prenom) }}">
                                @error('prenom')<p class="mt-1 text-[10px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Genre -->
                            <div>
                                <label for="genre" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Genre <span class="text-red-500">*</span></label>
                                <select name="genre" id="genre" required class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('genre') border-red-500 @enderror">
                                    <option value="m" {{ old('genre', $eleve->genre) === 'm' ? 'selected' : '' }}>Masculin</option>
                                    <option value="f" {{ old('genre', $eleve->genre) === 'f' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Naissance -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-400 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Naissance</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="date_naissance" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="date_naissance" id="date_naissance" required
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('date_naissance') border-red-500 @enderror" value="{{ old('date_naissance', $eleve->date_naissance->format('Y-m-d')) }}">
                            </div>

                            <div>
                                <label for="lieu_naissance" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Lieu <span class="text-red-500">*</span></label>
                                <input type="text" name="lieu_naissance" id="lieu_naissance" required placeholder="Dakar"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1 @error('lieu_naissance') border-red-500 @enderror" value="{{ old('lieu_naissance', $eleve->lieu_naissance) }}">
                            </div>
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
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1" value="{{ old('telephone', $eleve->telephone) }}">
                            </div>
                            <div>
                                <label for="email" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="email" placeholder="eleve@exemple.com"
                                       class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1" value="{{ old('email', $eleve->email) }}">
                            </div>
                        </div>
                    </div>

                    <!-- Section Inscriptions -->
                    <div>
                        <div class="flex items-center mb-3 pb-2 border-b border-gray-200">
                            <div class="bg-indigo-300 w-1 h-5 md:h-6 mr-2 md:mr-3 rounded-full"></div>
                            <h4 class="text-sm md:text-md font-semibold text-gray-800 uppercase tracking-wide">Inscriptions</h4>
                        </div>

                        @php
                            $inscriptionActive = $eleve->inscriptions()->where('statut', true)->first();
                            $classeActive = $inscriptionActive ? $inscriptionActive->classe : null;
                            $autresInscriptions = $eleve->inscriptions()->where('statut', false)->with('classe', 'anneeScolaire')->get();
                        @endphp

                        <!-- Classe actuelle -->
                        @if($classeActive)
                        <div class="mb-3 p-3 md:p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    <div class="bg-green-100 p-1.5 md:p-2 rounded-lg self-start sm:self-center">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs md:text-sm font-medium text-gray-900">Inscription active</p>
                                        <p class="text-[10px] md:text-sm text-gray-700 font-semibold">{{ $classeActive->nom }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] md:text-xs font-semibold rounded-full self-start sm:self-center">Active</span>
                            </div>
                        </div>
                        @else
                        <div class="mb-3 p-3 md:p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-xs">
                            <p class="font-medium text-gray-800">Aucune inscription active trouvée.</p>
                        </div>
                        @endif

                        <!-- Nouvelle inscription -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                            <div>
                                <label for="nouvelle_classe_id" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Nouvelle inscription</label>
                                <select name="nouvelle_classe_id" id="nouvelle_classe_id" class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1">
                                    <option value="">Inscrire dans une classe (optionnel)</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('nouvelle_classe_id') == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Statut -->
                            <div>
                                <label class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Statut <span class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-4 pt-2 md:pt-3">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="statut" value="1" class="form-radio text-indigo-600" {{ old('statut', $eleve->statut) ? 'checked' : '' }}>
                                        <span class="ml-2 text-xs md:text-sm text-gray-700">Actif</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="statut" value="0" class="form-radio text-red-600" {{ old('statut', $eleve->statut) ? '' : 'checked' }}>
                                        <span class="ml-2 text-xs md:text-sm text-gray-700">Inactif</span>
                                    </label>
                                </div>
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
                                      class="block w-full px-3 md:px-4 py-2.5 md:py-3 border rounded-lg text-xs md:text-sm focus:border-indigo-500 focus:ring-1">{{ old('adresse', $eleve->adresse) }}</textarea>
                        </div>
                    </div>

                    <!-- Section Compte utilisateur -->
                    @if($eleve->user)
                    <div class="p-3 md:p-4 bg-gray-50 border rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs md:text-sm font-medium text-gray-900">Compte utilisateur existant</p>
                                <p class="text-[10px] md:text-xs text-gray-500">Email: {{ $eleve->user->email }}</p>
                            </div>
                            <span class="px-2 py-0.5 bg-green-100 text-green-800 text-[10px] font-semibold rounded-full">Actif</span>
                        </div>
                        <div class="mt-3 flex items-center">
                            <input type="checkbox" name="update_user" id="update_user" value="1" {{ old('update_user') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                            <label for="update_user" class="ml-2 block text-xs md:text-sm text-gray-900">Mettre à jour le mot de passe</label>
                        </div>

                        <!-- Password Fields -->
                        <div id="password_fields" class="{{ old('update_user') ? '' : 'hidden' }} mt-3 space-y-3">
                            <div>
                                <label for="password" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Nouveau mot de passe <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password" class="block w-full px-3 md:px-4 py-2 md:py-2.5 border rounded-lg text-xs md:text-sm">
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-[10px] md:text-xs font-semibold text-gray-600 uppercase mb-1">Confirmer <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-3 md:px-4 py-2 md:py-2.5 border rounded-lg text-xs md:text-sm">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Boutons d'action -->
                    <div class="flex flex-col sm:flex-row justify-end gap-2 md:gap-3 pt-4 md:pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleves.show', $eleve) }}"
                           class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 bg-white border text-center text-gray-700 hover:bg-gray-50 text-xs md:text-sm font-medium rounded-lg transition-colors">
                            Annuler
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 md:px-6 py-2.5 md:py-3 bg-indigo-600 text-white hover:bg-indigo-700 text-xs md:text-sm font-medium rounded-lg shadow-sm">
                            Mettre à jour
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
    const photoContainer = document.getElementById('photo-container');
    const updateUserCheckbox = document.getElementById('update_user');
    const passwordFields = document.getElementById('password_fields');

    // Photo Preview
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
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.className = "w-16 h-16 md:w-24 md:h-24 rounded-lg object-cover border-2 border-indigo-200 shadow";
                        newImg.id = "photo-preview";
                        photoContainer.innerHTML = '';
                        photoContainer.appendChild(newImg);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Toggle Password Fields
    if (updateUserCheckbox && passwordFields) {
        updateUserCheckbox.addEventListener('change', function() {
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
