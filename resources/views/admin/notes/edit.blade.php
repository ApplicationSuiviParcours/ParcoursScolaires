@extends('layouts.app')

@section('title', 'Modifier la note')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 py-8 md:py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-orange-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
    </div>
    
    <!-- Particules flottantes (masquées sur mobile) -->
    <div class="absolute inset-0 overflow-hidden hidden sm:block">
        @for($i = 1; $i <= 4; $i++)
            <div class="absolute w-1 h-1 bg-white rounded-full opacity-30 animate-float-{{ $i }}"
                 style="left: {{ rand(0, 100) }}%; top: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 5) }}s;"></div>
        @endfor
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="text-center md:text-left mb-6 md:mb-0">
                <nav class="flex mb-4 justify-center md:justify-start" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.notes.index') }}" class="inline-flex items-center text-sm font-medium text-amber-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span class="hidden sm:inline">Notes</span>
                                <span class="sm:hidden">Liste</span>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('admin.notes.show', $note) }}" class="ml-1 text-sm font-medium text-amber-200 hover:text-white md:ml-2 transition-colors duration-300">
                                    #{{ $note->id }}
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Modif.</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Modifier la note
                </h1>
                <p class="text-amber-200 text-sm md:text-base animate-fade-in-up animation-delay-200 truncate px-4 md:px-0">
                    {{ $note->eleve->nom }} {{ $note->eleve->prenom }}
                </p>
            </div>
            <div class="flex flex-col sm:flex-row justify-center md:justify-end space-y-3 sm:space-y-0 sm:space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.notes.show', $note) }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden text-sm">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="hidden sm:inline">Voir détails</span>
                </a>
                <a href="{{ route('admin.notes.index') }}" 
                   class="group relative inline-flex items-center justify-center px-4 py-2.5 md:px-5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20 text-sm">
                    <svg class="w-5 h-5 sm:mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Retour</span>
                    <span class="sm:hidden">Liste</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Vague décorative -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg class="fill-current text-gray-50" viewBox="0 0 1440 120" preserveAspectRatio="none">
            <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</div>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6 md:py-10 bg-gray-50">
    <div class="max-w-3xl mx-auto">
        <!-- Formulaire -->
        <div class="bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-lg rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold text-white mb-1">Modifier la note</h2>
                        <p class="text-amber-100 text-xs md:text-sm">Modifiez les informations ci-dessous</p>
                    </div>
                </div>
            </div>

            <div class="p-4 md:p-8">
                <!-- Aperçu rapide -->
                <div class="mb-6 md:mb-8 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl md:rounded-2xl border border-amber-200">
                    <div class="flex flex-col sm:flex-row items-center text-center sm:text-left">
                        <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl md:rounded-2xl flex items-center justify-center text-white font-bold text-xl md:text-2xl mb-3 sm:mb-0 sm:mr-4 flex-shrink-0">
                            {{ number_format($note->note, 1) }}
                        </div>
                        <div>
                            <p class="text-xs md:text-sm text-amber-700">Modification pour</p>
                            <p class="text-base md:text-lg font-bold text-gray-800">{{ $note->eleve->nom }} {{ $note->eleve->prenom }}</p>
                            <p class="text-xs md:text-sm text-gray-600 truncate">{{ $note->evaluation->matiere->nom ?? 'N/A' }} - {{ $note->evaluation->nom }}</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.notes.update', $note) }}" method="POST" id="editForm">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5 md:space-y-6">
                        <!-- Note -->
                        <div class="group">
                            <label for="note" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Note <span class="text-red-500">*</span>
                                <span class="text-xs text-gray-500 ml-1">(0 à 20)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <input type="number" 
                                       name="note" 
                                       id="note" 
                                       value="{{ old('note', $note->note) }}"
                                       step="0.5"
                                       min="0"
                                       max="20"
                                       class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('note') border-red-500 @enderror text-sm md:text-base"
                                       required>
                            </div>
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <span class="text-xs text-gray-500">Rapide :</span>
                                <button type="button" onclick="setNote(20)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">20</button>
                                <button type="button" onclick="setNote(16)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">16</button>
                                <button type="button" onclick="setNote(14)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">14</button>
                                <button type="button" onclick="setNote(12)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">12</button>
                                <button type="button" onclick="setNote(10)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">10</button>
                                <button type="button" onclick="setNote(8)" class="px-2.5 py-1 bg-gray-100 rounded-lg text-xs hover:bg-gray-200">8</button>
                            </div>
                            @error('note')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Observation -->
                        <div class="group">
                            <label for="observation" class="block text-xs md:text-sm font-semibold text-gray-700 mb-2 group-hover:text-amber-600 transition-colors duration-300">
                                Observation <span class="text-xs text-gray-500">(optionnel)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 md:top-4 left-4 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-amber-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <textarea name="observation" 
                                          id="observation" 
                                          rows="3"
                                          placeholder="Observation..."
                                          class="w-full pl-12 pr-4 py-2.5 md:py-3 rounded-xl border-2 border-gray-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('observation') border-red-500 @enderror text-sm md:text-base">{{ old('observation', $note->observation) }}</textarea>
                            </div>
                            @error('observation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informations lecture seule -->
                        <div class="mt-6 md:mt-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
                            <h4 class="text-xs md:text-sm font-medium text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Non modifiables
                            </h4>
                            <div class="grid grid-cols-2 gap-3 text-xs md:text-sm">
                                <div>
                                    <span class="text-gray-500">Élève</span>
                                    <p class="font-medium text-gray-800 truncate">{{ $note->eleve->nom }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Matière</span>
                                    <p class="font-medium text-gray-800 truncate">{{ $note->evaluation->matiere->nom ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Évaluation</span>
                                    <p class="font-medium text-gray-800 truncate">{{ $note->evaluation->nom }}</p>
                                </div>
                                <div>
                                    <span class="text-gray-500">Date</span>
                                    <p class="font-medium text-gray-800">{{ $note->evaluation->date_evaluation->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Aperçu appréciation -->
                        <div class="p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl md:rounded-2xl border border-amber-200">
                            <h4 class="text-xs md:text-sm font-medium text-amber-800 mb-2 text-center">
                                Aperçu
                            </h4>
                            <div id="appreciationPreview" class="text-base md:text-lg font-medium text-center">
                                @php
                                    $appreciation = $note->appreciation_auto;
                                    $colorClass = $note->note >= 16 ? 'text-green-600' : ($note->note >= 14 ? 'text-blue-600' : ($note->note >= 10 ? 'text-yellow-600' : 'text-red-600'));
                                @endphp
                                <span class="{{ $colorClass }} font-bold">{{ $appreciation }}</span>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 sm:gap-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.notes.show', $note) }}" 
                               class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 text-center text-sm md:text-base">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-6 py-2.5 md:py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Zone de danger -->
        <div class="mt-6 md:mt-8 bg-white rounded-2xl md:rounded-3xl shadow-xl overflow-hidden border-l-4 md:border-l-8 border-red-500">
            <div class="bg-gradient-to-r from-red-50 to-red-100 px-4 md:px-8 py-4 md:py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-red-500 rounded-xl md:rounded-2xl flex items-center justify-center mr-4 md:mr-5 flex-shrink-0">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-red-800 mb-1">Zone de danger</h3>
                        <p class="text-red-600 text-xs md:text-sm">Actions irréversibles</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="flex-1">
                        <h4 class="text-base md:text-lg font-semibold text-gray-800 mb-2">Supprimer cette note</h4>
                        <p class="text-gray-600 text-xs md:text-sm leading-relaxed">
                            Action irréversible.
                        </p>
                        <div class="mt-3 flex items-center text-xs text-gray-500">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            ID : <span class="font-mono ml-1">#{{ $note->id }}</span>
                        </div>
                    </div>
                    
                    <div class="w-full md:w-auto">
                        <form action="{{ route('admin.notes.destroy', $note) }}" 
                              method="POST" 
                              onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full md:w-auto px-6 py-2.5 md:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl text-sm md:text-base">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Supprimer
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
    /* Prévention du zoom sur les inputs iOS */
    input[type="number"], textarea {
        font-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
    function setNote(valeur) {
        const noteInput = document.getElementById('note');
        if (noteInput) {
            noteInput.value = valeur;
            updateAppreciationPreview();
        }
    }

    function updateAppreciationPreview() {
        const noteInput = document.getElementById('note');
        const preview = document.getElementById('appreciationPreview');
        
        if (!noteInput || !preview) return;

        const note = parseFloat(noteInput.value) || 0;
        
        let appreciation = '';
        let colorClass = '';
        
        if (note >= 18) {
            appreciation = 'Excellent';
            colorClass = 'text-green-600';
        } else if (note >= 16) {
            appreciation = 'Très bien';
            colorClass = 'text-green-500';
        } else if (note >= 14) {
            appreciation = 'Bien';
            colorClass = 'text-blue-600';
        } else if (note >= 12) {
            appreciation = 'Assez bien';
            colorClass = 'text-indigo-600';
        } else if (note >= 10) {
            appreciation = 'Passable';
            colorClass = 'text-yellow-600';
        } else if (note >= 8) {
            appreciation = 'Insuffisant';
            colorClass = 'text-orange-600';
        } else if (note > 0) {
            appreciation = 'Faible';
            colorClass = 'text-red-500';
        } else {
            appreciation = '-';
            colorClass = 'text-gray-400';
        }
        
        preview.innerHTML = `<span class="${colorClass} font-bold">${appreciation}</span>`;
    }

    const noteInput = document.getElementById('note');
    if (noteInput) {
        noteInput.addEventListener('input', updateAppreciationPreview);
    }

    // Confirmation avant de quitter
    let formModified = false;
    const editForm = document.getElementById('editForm');
    
    if (editForm) {
        editForm.querySelectorAll('input, textarea').forEach(element => {
            element.addEventListener('change', () => formModified = true);
            element.addEventListener('keyup', () => formModified = true);
        });
        
        editForm.addEventListener('submit', () => formModified = false);
    }
    
    window.addEventListener('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();
            e.returnValue = 'Modifications non enregistrées. Quitter ?';
        }
    });
</script>
@endpush