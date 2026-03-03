@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Modifier l\'absence') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header avec bouton retour -->
            <div class="p-6 mb-8 shadow-lg bg-gradient-to-r from-yellow-600 to-yellow-400 rounded-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="{{ route('enseignant.absences.index') }}" class="mr-4 text-white hover:text-yellow-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Modifier l'absence</h3>
                            <p class="mt-1 text-yellow-100">Mettre à jour les informations</p>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="p-3 rounded-full bg-white/20">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'édition -->
            <div class="overflow-hidden bg-white shadow-md rounded-xl">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="text-lg font-semibold text-gray-900">Modifier l'absence</h4>
                    <p class="mt-1 text-sm text-gray-500">Modifiez les informations ci-dessous</p>
                </div>

                <form action="{{ route('enseignant.absences.update', $absence->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Sélection de la classe (lecture seule) -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Classe
                            </label>
                            <input type="text" value="{{ $absence->eleve->classe->nom ?? 'N/A' }}"
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly disabled>
                        </div>

                        <!-- Élève (lecture seule) -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Élève
                            </label>
                            <input type="text" value="{{ $absence->eleve->nom ?? '' }} {{ $absence->eleve->prenom ?? '' }}"
                                class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg" readonly disabled>
                            <input type="hidden" name="eleve_id" value="{{ $absence->eleve_id }}">
                        </div>

                        <!-- Matière -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Matière <span class="text-red-500">*</span>
                            </label>
                            <select name="matiere_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('matiere_id') border-red-500 @enderror">
                                @foreach($matieres as $matiere)
                                    <option value="{{ $matiere->id }}" {{ $absence->matiere_id == $matiere->id ? 'selected' : '' }}>
                                        {{ $matiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('matiere_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date de l'absence -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Date de l'absence <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_absence"
                                value="{{ old('date_absence', $absence->date_absence->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('date_absence') border-red-500 @enderror"
                                required>
                            @error('date_absence')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Heures d'absence -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Heure de début <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="heure_debut"
                                    value="{{ old('heure_debut', substr($absence->heure_debut, 0, 5)) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('heure_debut') border-red-500 @enderror"
                                    required>
                                @error('heure_debut')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Heure de fin <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="heure_fin"
                                    value="{{ old('heure_fin', substr($absence->heure_fin, 0, 5)) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 @error('heure_fin') border-red-500 @enderror"
                                    required>
                                @error('heure_fin')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Durée (calculée automatiquement) -->
                        <div class="p-4 rounded-lg bg-gray-50">
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Durée de l'absence
                            </label>
                            <div class="flex items-center">
                                <span id="duree_display" class="text-2xl font-bold text-gray-900">
                                    @php
                                        $debut = \Carbon\Carbon::parse($absence->heure_debut);
                                        $fin = \Carbon\Carbon::parse($absence->heure_fin);
                                        echo $debut->diffInHours($fin);
                                    @endphp
                                </span>
                                <span class="ml-2 text-gray-600">heure(s)</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Calculée automatiquement</p>
                        </div>

                        <!-- Motif -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Motif
                            </label>
                            <textarea name="motif" rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                                placeholder="Raison de l'absence...">{{ old('motif', $absence->motif) }}</textarea>
                        </div>

                        <!-- Justification -->
                        <div class="flex items-center">
                            <input type="checkbox" name="justifie" id="justifie" value="1" {{ $absence->justifiee ? 'checked' : '' }}
                                class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                            <label for="justifie" class="block ml-2 text-sm text-gray-900">
                                Absence justifiée
                            </label>
                        </div>

                        <!-- Message d'avertissement -->
                        <div class="p-4 border-l-4 border-yellow-400 bg-yellow-50">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Attention :</strong> La modification de cette absence sera visible par
                                        l'administration et les parents.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end pt-6 space-x-3 border-t">
                            <a href="{{ route('enseignant.absences.index') }}"
                                class="px-6 py-2 text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                                Annuler
                            </a>
                            <button type="submit"
                                class="flex items-center px-6 py-2 text-white transition-colors bg-yellow-600 rounded-lg hover:bg-yellow-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const heureDebut = document.querySelector('input[name="heure_debut"]');
            const heureFin = document.querySelector('input[name="heure_fin"]');
            const dureeDisplay = document.getElementById('duree_display');

            // Calculer automatiquement la durée
            function calculerDuree() {
                if (heureDebut.value && heureFin.value) {
                    const debut = heureDebut.value.split(':');
                    const fin = heureFin.value.split(':');

                    const debutMinutes = parseInt(debut[0]) * 60 + parseInt(debut[1]);
                    const finMinutes = parseInt(fin[0]) * 60 + parseInt(fin[1]);

                    let diffHeures = (finMinutes - debutMinutes) / 60;

                    if (diffHeures > 0) {
                        dureeDisplay.textContent = diffHeures.toFixed(1);
                    } else {
                        dureeDisplay.textContent = '0';
                    }
                }
            }

            heureDebut.addEventListener('change', calculerDuree);
            heureFin.addEventListener('change', calculerDuree);
        });
    </script>
@endsection