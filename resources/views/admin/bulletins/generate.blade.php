@extends('layouts.app')

@section('title', 'Générer des bulletins')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-green-600 via-green-700 to-teal-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                            <a href="{{ route('admin.bulletins.index') }}" class="inline-flex items-center text-sm font-medium text-green-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Bulletins
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">Générer des bulletins</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    Générer des bulletins
                </h1>
                <p class="text-green-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    Créez des bulletins pour une classe et une période spécifiques
                </p>
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
    <div class="max-w-3xl mx-auto">
        <!-- Formulaire de génération -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-teal-600 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center mr-5">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Paramètres de génération</h2>
                        <p class="text-green-100 text-sm">Sélectionnez la classe, la période et la date du bulletin</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.bulletins.generateStore') }}" method="POST" id="generateForm">
                    @csrf

                    <div class="space-y-6">
                        <!-- Classe -->
                        <div class="group">
                            <label for="classe_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">
                                Classe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                    </svg>
                                </div>
                                <select name="classe_id" 
                                        id="classe_id" 
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300 @error('classe_id') border-red-500 @enderror appearance-none bg-white"
                                        required>
                                    <option value="">Sélectionnez une classe</option>
                                    @foreach($classes as $classe)
                                        <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                            {{ $classe->nom }} ({{ $classe->inscriptions_count ?? $classe->inscriptions->count() }} élèves)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('classe_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Année scolaire -->
                        <div class="group">
                            <label for="annee_scolaire_id" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">
                                Année scolaire <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <select name="annee_scolaire_id" 
                                        id="annee_scolaire_id" 
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300 @error('annee_scolaire_id') border-red-500 @enderror appearance-none bg-white"
                                        required>
                                    <option value="">Sélectionnez une année scolaire</option>
                                    @foreach($anneeScolaires as $annee)
                                        <option value="{{ $annee->id }}" {{ old('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                                            {{ $annee->nom }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('annee_scolaire_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Période -->
                        <div class="group">
                            <label for="periode" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">
                                Période <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <select name="periode" 
                                        id="periode" 
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300 @error('periode') border-red-500 @enderror appearance-none bg-white"
                                        required>
                                    <option value="">Sélectionnez une période</option>
                                    <option value="Trimestre 1" {{ old('periode') == 'Trimestre 1' ? 'selected' : '' }}>Trimestre 1</option>
                                    <option value="Trimestre 2" {{ old('periode') == 'Trimestre 2' ? 'selected' : '' }}>Trimestre 2</option>
                                    <option value="Trimestre 3" {{ old('periode') == 'Trimestre 3' ? 'selected' : '' }}>Trimestre 3</option>
                                    <option value="Semestre 1" {{ old('periode') == 'Semestre 1' ? 'selected' : '' }}>Semestre 1</option>
                                    <option value="Semestre 2" {{ old('periode') == 'Semestre 2' ? 'selected' : '' }}>Semestre 2</option>
                                    <option value="Annuel" {{ old('periode') == 'Annuel' ? 'selected' : '' }}>Annuel</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('periode')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date du bulletin -->
                        <div class="group">
                            <label for="date_bulletin" class="block text-sm font-semibold text-gray-700 mb-2 group-hover:text-green-600 transition-colors duration-300">
                                Date du bulletin <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 group-hover:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <input type="date" 
                                       name="date_bulletin" 
                                       id="date_bulletin" 
                                       value="{{ old('date_bulletin', date('Y-m-d')) }}"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-300 @error('date_bulletin') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('date_bulletin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Récapitulatif -->
                        <div class="mt-8 p-4 bg-gradient-to-r from-green-50 to-teal-50 rounded-2xl border border-green-200" id="recapSection" style="display: none;">
                            <h4 class="text-sm font-medium text-green-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Récapitulatif
                            </h4>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Classe:</span> <span id="recapClasse">-</span></p>
                                <p><span class="font-medium">Année scolaire:</span> <span id="recapAnnee">-</span></p>
                                <p><span class="font-medium">Période:</span> <span id="recapPeriode">-</span></p>
                                <p><span class="font-medium">Date du bulletin:</span> <span id="recapDate">-</span></p>
                                <p><span class="font-medium">Nombre d'élèves:</span> <span id="recapEleves">-</span></p>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-4 pt-6 border-t-2 border-gray-100">
                            <a href="{{ route('admin.bulletins.index') }}" 
                               class="px-8 py-3 bg-white border-2 border-gray-300 rounded-xl text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Générer les bulletins
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations -->
        <div class="mt-8 bg-blue-50 rounded-2xl p-6 border border-blue-200">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">Comment ça fonctionne ?</h3>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Les bulletins sont générés à partir des notes existantes
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Les moyennes sont calculées avec les coefficients des matières
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Les rangs sont automatiquement calculés
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Les bulletins existants seront mis à jour
                        </li>
                    </ul>
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
</style>
@endpush

@push('scripts')
<script>
    // Mise à jour du récapitulatif
    function updateRecap() {
        const classeSelect = document.getElementById('classe_id');
        const anneeSelect = document.getElementById('annee_scolaire_id');
        const periodeSelect = document.getElementById('periode');
        const dateInput = document.getElementById('date_bulletin');
        const recapSection = document.getElementById('recapSection');

        if (classeSelect.value && anneeSelect.value && periodeSelect.value && dateInput.value) {
            // Récupérer les libellés
            const classeText = classeSelect.options[classeSelect.selectedIndex]?.text.split(' (')[0] || '-';
            const anneeText = anneeSelect.options[anneeSelect.selectedIndex]?.text || '-';
            const periodeText = periodeSelect.options[periodeSelect.selectedIndex]?.text || '-';
            
            // Formater la date
            const date = new Date(dateInput.value);
            const dateFormatee = date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            // Récupérer le nombre d'élèves
            const match = classeSelect.options[classeSelect.selectedIndex]?.text.match(/\((\d+)/);
            const nbEleves = match ? match[1] : '?';

            // Mettre à jour le récapitulatif
            document.getElementById('recapClasse').textContent = classeText;
            document.getElementById('recapAnnee').textContent = anneeText;
            document.getElementById('recapPeriode').textContent = periodeText;
            document.getElementById('recapDate').textContent = dateFormatee;
            document.getElementById('recapEleves').textContent = nbEleves;

            recapSection.style.display = 'block';
        } else {
            recapSection.style.display = 'none';
        }
    }

    // Ajouter les écouteurs d'événements
    document.getElementById('classe_id').addEventListener('change', updateRecap);
    document.getElementById('annee_scolaire_id').addEventListener('change', updateRecap);
    document.getElementById('periode').addEventListener('change', updateRecap);
    document.getElementById('date_bulletin').addEventListener('change', updateRecap);

    // Initialiser le récapitulatif si des valeurs sont déjà sélectionnées
    updateRecap();
</script>
@endpush