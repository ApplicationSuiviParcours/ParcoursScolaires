@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-sm text-gray-800 leading-tight">
        <a href="{{ route('enseignant.evaluations.index') }}" class="text-gray-500 hover:text-indigo-600 transition-colors mr-2">Évaluations</a> 
        <span class="text-gray-300">/</span> 
        <span class="text-indigo-600 ml-2">Modifier l'Évaluation</span>
    </h2>
@endsection

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="px-8 py-6 bg-gradient-to-r from-indigo-700 to-indigo-600">
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modification : {{ $evaluation->nom }}
                </h3>
                <p class="mt-2 text-indigo-100 text-sm">Veuillez modifier les champs ci-dessous pour mettre à jour cette évaluation.</p>
            </div>

            <!-- Formulary -->
            <div class="p-8">
                <form action="{{ route('enseignant.evaluations.update', $evaluation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 pb-8">
                        
                        <!-- Nom de l'évaluation -->
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nom de l'évaluation <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" required value="{{ old('nom', $evaluation->nom) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors"
                                   placeholder="Ex: Devoir de contrôle n°1">
                            @error('nom') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Classe -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Classe <span class="text-red-500">*</span></label>
                            <select name="classe_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                                <option value="">Sélectionner une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ old('classe_id', $evaluation->classe_id) == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('classe_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Matière -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Matière <span class="text-red-500">*</span></label>
                            <select name="matiere_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                                <option value="">Sélectionner une matière</option>
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ old('matiere_id', $evaluation->matiere_id) == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Type d'évaluation -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                            <select name="type" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                                <option value="devoir" {{ old('type', $evaluation->type) == 'devoir' ? 'selected' : '' }}>Devoir</option>
                                <option value="examen" {{ old('type', $evaluation->type) == 'examen' ? 'selected' : '' }}>Examen</option>
                                <option value="interrogation" {{ old('type', $evaluation->type) == 'interrogation' ? 'selected' : '' }}>Interrogation</option>
                                <option value="projet" {{ old('type', $evaluation->type) == 'projet' ? 'selected' : '' }}>Projet</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Période -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Période <span class="text-red-500">*</span></label>
                            <select name="periode" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('periode', $evaluation->periode) == $i ? 'selected' : '' }}>Période {{ $i }}</option>
                                @endfor
                            </select>
                            @error('periode') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date de l'évaluation <span class="text-red-500">*</span></label>
                            <input type="date" name="date_evaluation" required 
                                   value="{{ old('date_evaluation', \Carbon\Carbon::parse($evaluation->date_evaluation)->format('Y-m-d')) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('date_evaluation') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Coefficient -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Coefficient <span class="text-red-500">*</span></label>
                            <input type="number" name="coefficient" step="0.5" min="0.5" max="10" required 
                                   value="{{ old('coefficient', $evaluation->coefficient) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('coefficient') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Barème -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Barème <span class="text-red-500">*</span></label>
                            <input type="number" name="bareme" step="0.5" min="0" max="40" required 
                                   value="{{ old('bareme', $evaluation->bareme) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                            @error('bareme') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Année scolaire -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Année scolaire <span class="text-red-500">*</span></label>
                            <select name="annee_scolaire_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors">
                                @foreach($anneesScolaires as $annee)
                                    <option value="{{ $annee->id }}" {{ old('annee_scolaire_id', $evaluation->annee_scolaire_id) == $annee->id ? 'selected' : '' }}>
                                        {{ $annee->nom ?? $annee->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('annee_scolaire_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-1 md:col-span-2 mt-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Description (optionnelle)</label>
                            <textarea name="description" rows="3" 
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-colors"
                                      placeholder="Commentaires supplémentaires concernant cette l'évaluation">{{ old('description', $evaluation->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <a href="{{ route('enseignant.evaluations.index') }}" 
                           class="px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-xl font-bold transition-all shadow-sm">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-indigo-600/30 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
