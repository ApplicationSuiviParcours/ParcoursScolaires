@extends('layouts.app')

@section('title', 'Modifier le cours')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 space-y-4 sm:space-y-0 animate__animated animate__fadeInDown">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-xl shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Modifier le cours</h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.emploi_du_temps.show', $emploiDuTemps) }}" 
                   class="inline-flex items-center px-4 py-3 bg-blue-100 text-blue-700 font-medium rounded-xl hover:bg-blue-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Voir
                </a>
                <a href="{{ route('admin.emploi_du_temps.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 hover:shadow-md transform hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
            <div class="mb-6 animate__animated animate__fadeInDown">
                <div class="flex items-start p-4 bg-red-100 border-l-4 border-red-500 rounded-lg shadow-md" role="alert">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8" onclick="this.parentElement.remove()">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Formulaire -->
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-white/20 animate__animated animate__fadeInUp">
            <div class="bg-gradient-to-r from-yellow-600 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier le cours #{{ $emploiDuTemps->id }}
                </h2>
            </div>
            <div class="p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.emploi_du_temps.update', $emploiDuTemps) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Ligne 1: Classe et Matière -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Classe -->
                        <div class="space-y-2">
                            <label for="classe_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Classe <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select name="classe_id" id="classe_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('classe_id') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id', $emploiDuTemps->classe_id) == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Matière -->
                        <div class="space-y-2">
                            <label for="matiere_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>Matière <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select name="matiere_id" id="matiere_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('matiere_id') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id', $emploiDuTemps->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Ligne 2: Enseignant et Année scolaire -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Enseignant -->
                        <div class="space-y-2">
                            <label for="enseignant_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Enseignant <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select name="enseignant_id" id="enseignant_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('enseignant_id') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Sélectionner un enseignant</option>
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}" {{ old('enseignant_id', $emploiDuTemps->enseignant_id) == $enseignant->id ? 'selected' : '' }}>
                                        {{ $enseignant->nom }} {{ $enseignant->prenom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('enseignant_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Année scolaire -->
                        <div class="space-y-2">
                            <label for="annee_scolaire_id" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Année scolaire <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select name="annee_scolaire_id" id="annee_scolaire_id" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('annee_scolaire_id') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Sélectionner une année</option>
                                @foreach($anneeScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ old('annee_scolaire_id', $emploiDuTemps->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->nom }} {{ $annee->active ? '(En cours)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Ligne 3: Jour et Salle -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jour -->
                        <div class="space-y-2">
                            <label for="jour" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Jour <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <select name="jour" id="jour" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('jour') border-red-500 ring-2 ring-red-200 @enderror">
                                <option value="">Sélectionner un jour</option>
                                <option value="1" {{ old('jour', $emploiDuTemps->jour) == '1' ? 'selected' : '' }}>Lundi</option>
                                <option value="2" {{ old('jour', $emploiDuTemps->jour) == '2' ? 'selected' : '' }}>Mardi</option>
                                <option value="3" {{ old('jour', $emploiDuTemps->jour) == '3' ? 'selected' : '' }}>Mercredi</option>
                                <option value="4" {{ old('jour', $emploiDuTemps->jour) == '4' ? 'selected' : '' }}>Jeudi</option>
                                <option value="5" {{ old('jour', $emploiDuTemps->jour) == '5' ? 'selected' : '' }}>Vendredi</option>
                                <option value="6" {{ old('jour', $emploiDuTemps->jour) == '6' ? 'selected' : '' }}>Samedi</option>
                                <option value="7" {{ old('jour', $emploiDuTemps->jour) == '7' ? 'selected' : '' }}>Dimanche</option>
                            </select>
                            @error('jour')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salle -->
                        <div class="space-y-2">
                            <label for="salle" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span>Salle</span>
                                </span>
                            </label>
                            <input type="text" name="salle" id="salle" value="{{ old('salle', $emploiDuTemps->salle) }}"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('salle') border-red-500 ring-2 ring-red-200 @enderror"
                                   placeholder="Ex: Salle 101, Laboratoire, etc.">
                            @error('salle')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Ligne 4: Heure de début et Heure de fin -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Heure de début -->
                        <div class="space-y-2">
                            <label for="heure_debut" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Heure de début <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <input type="time" name="heure_debut" id="heure_debut" 
                                   value="{{ old('heure_debut', substr($emploiDuTemps->heure_debut, 0, 5)) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('heure_debut') border-red-500 ring-2 ring-red-200 @enderror">
                            @error('heure_debut')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heure de fin -->
                        <div class="space-y-2">
                            <label for="heure_fin" class="block text-sm font-medium text-gray-700">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Heure de fin <span class="text-red-500">*</span></span>
                                </span>
                            </label>
                            <input type="time" name="heure_fin" id="heure_fin" 
                                   value="{{ old('heure_fin', substr($emploiDuTemps->heure_fin, 0, 5)) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 @error('heure_fin') border-red-500 ring-2 ring-red-200 @enderror">
                            @error('heure_fin')
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-wrap justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.emploi_du_temps.show', $emploiDuTemps) }}" 
                           class="inline-flex items-center px-6 py-3 bg-blue-100 text-blue-700 font-medium rounded-xl hover:bg-blue-200 hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Voir les détails
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-yellow-600 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script de validation -->
@push('scripts')
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const debut = document.getElementById('heure_debut').value;
        const fin = document.getElementById('heure_fin').value;
        
        if (debut && fin && debut >= fin) {
            e.preventDefault();
            alert('L\'heure de fin doit être postérieure à l\'heure de début.');
        }
    });
</script>
@endpush

<!-- Styles pour les animations -->
@push('styles')
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate__animated {
        animation-duration: 0.6s;
        animation-fill-mode: both;
    }
    .animate__fadeInDown { animation-name: fadeInDown; }
    .animate__fadeInUp { animation-name: fadeInUp; }
</style>
@endpush
@endsection