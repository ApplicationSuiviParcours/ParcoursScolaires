{{-- resources/views/admin/eleve_parents/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ajouter une relation Élève-Parent')

@section('header')
    {{-- Header Responsive --}}
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 py-3 sm:py-4 md:py-6 overflow-x-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-3 sm:px-4 md:px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-1.5 sm:gap-2">
                <div class="flex items-center space-x-2 sm:space-x-3 md:space-x-4">
                    <div class="p-1.5 sm:p-2 md:p-3 bg-white bg-opacity-20 rounded-lg sm:rounded-xl md:rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-plus-circle text-sm sm:text-base md:text-lg lg:text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white">Nouvelle relation</h1>
                        <p class="text-green-100 text-[9px] sm:text-[10px] md:text-xs lg:text-sm mt-0.5">Créez une relation entre un élève et un parent</p>
                    </div>
                </div>
                <nav class="mt-1 md:mt-0">
                    <ol class="flex items-center space-x-1 sm:space-x-1.5 md:space-x-2 text-[8px] sm:text-[9px] md:text-xs lg:text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-green-200 hover:text-white transition-colors">
                                <i class="fas fa-home mr-0.5 sm:mr-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="text-green-300">/</li>
                        <li>
                            <a href="{{ route('admin.eleve-parents.index') }}" class="text-green-200 hover:text-white transition-colors">
                                Relations
                            </a>
                        </li>
                        <li class="text-green-300">/</li>
                        <li class="text-white font-medium">Nouvelle</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 md:px-6 py-3 sm:py-4 md:py-6 lg:py-8 overflow-x-hidden">
        
        <!-- Statistiques rapides - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 md:gap-4 lg:gap-6 mb-3 sm:mb-4 md:mb-6 lg:mb-8">
            <!-- Total élèves -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-2.5 sm:p-3 md:p-4 lg:p-6 border-l-4 border-indigo-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Élèves</p>
                        <p class="text-sm sm:text-base md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5">{{ \App\Models\Eleve::count() }}</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-indigo-100 rounded-lg md:rounded-xl flex-shrink-0 ml-2">
                        <i class="fas fa-child text-sm sm:text-base md:text-lg lg:text-3xl text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total parents -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-2.5 sm:p-3 md:p-4 lg:p-6 border-l-4 border-green-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Parents</p>
                        <p class="text-sm sm:text-base md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5">{{ \App\Models\ParentEleve::count() }}</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-green-100 rounded-lg md:rounded-xl flex-shrink-0 ml-2">
                        <i class="fas fa-user-tie text-sm sm:text-base md:text-lg lg:text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Relations existantes -->
            <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow p-2.5 sm:p-3 md:p-4 lg:p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-500 uppercase">Relations</p>
                        <p class="text-sm sm:text-base md:text-xl lg:text-3xl font-bold text-gray-800 mt-0.5">{{ \App\Models\EleveParent::count() }}</p>
                    </div>
                    <div class="p-1.5 sm:p-2 md:p-3 lg:p-4 bg-purple-100 rounded-lg md:rounded-xl flex-shrink-0 ml-2">
                        <i class="fas fa-handshake text-sm sm:text-base md:text-lg lg:text-3xl text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message d'information - Responsive -->
        <div class="bg-green-50 border border-green-200 rounded-lg sm:rounded-xl md:rounded-2xl p-2.5 sm:p-3 md:p-4 lg:p-6 mb-3 sm:mb-4 md:mb-6 lg:mb-8">
            <div class="flex items-start gap-2 sm:gap-3">
                <div class="p-1.5 sm:p-2 bg-green-100 rounded-full flex-shrink-0">
                    <i class="fas fa-info-circle text-green-700 text-[10px] sm:text-xs md:text-sm lg:text-xl"></i>
                </div>
                <div>
                    <h3 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-green-800">Créer une relation</h3>
                    <p class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm text-green-700 mt-0.5">
                        Sélectionnez un élève et un parent. Champs <span class="text-red-600 font-bold">*</span> obligatoires.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulaire - Responsive -->
        <div class="bg-white rounded-lg sm:rounded-xl md:rounded-2xl shadow-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-3 sm:px-4 md:px-5 lg:px-6 py-2 sm:py-2.5 md:py-3 lg:py-4">
                <div class="flex items-center">
                    <div class="p-1 sm:p-1.5 md:p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-pen text-white text-[10px] sm:text-xs md:text-sm lg:text-xl"></i>
                    </div>
                    <h3 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-white ml-2 sm:ml-2.5 md:ml-3">Informations de la relation</h3>
                </div>
            </div>

            <div class="p-3 sm:p-4 md:p-5 lg:p-6 xl:p-8">
                <form action="{{ route('admin.eleve-parents.store') }}" method="POST" class="space-y-4 sm:space-y-5 md:space-y-6 lg:space-y-8" id="createForm">
                    @csrf

                    <!-- Section Élève -->
                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <div class="w-0.5 h-5 sm:h-6 md:h-7 lg:h-8 bg-indigo-600 rounded-full"></div>
                            <h4 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800">Sélection de l'élève <span class="text-[8px] sm:text-[9px] text-red-500">*</span></h4>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
                            <div>
                                <label for="eleve_id" class="block text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-700 mb-0.5 sm:mb-1">Choisir un élève</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-graduation-cap text-gray-400 text-[8px] sm:text-[9px] md:text-xs lg:text-sm"></i>
                                    </span>
                                    <select name="eleve_id" id="eleve_id" required
                                            class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl text-[9px] sm:text-[10px] md:text-xs focus:border-indigo-400 focus:ring-1 @error('eleve_id') border-red-500 @enderror">
                                        <option value="" disabled selected>Sélectionnez...</option>
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                                {{ $eleve->prenom }} {{ $eleve->nom }} ({{ $eleve->classe->nom ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('eleve_id')<p class="mt-0.5 text-[8px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Aperçu Élève -->
                            <div id="elevePreview" class="bg-indigo-50 rounded-lg p-2 sm:p-2.5 md:p-3 hidden">
                                <div class="flex items-center">
                                    <div class="p-1 sm:p-1.5 md:p-2 bg-indigo-200 rounded-lg">
                                        <i class="fas fa-child text-indigo-700 text-[10px] sm:text-xs md:text-sm"></i>
                                    </div>
                                    <div class="ml-2 sm:ml-2.5 md:ml-3">
                                        <p class="text-[8px] sm:text-[9px] md:text-xs font-medium text-indigo-900" id="elevePreviewName"></p>
                                        <p class="text-[7px] sm:text-[8px] md:text-[9px] text-indigo-700" id="elevePreviewClass"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Parent -->
                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <div class="w-0.5 h-5 sm:h-6 md:h-7 lg:h-8 bg-green-600 rounded-full"></div>
                            <h4 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800">Sélection du parent <span class="text-[8px] sm:text-[9px] text-red-500">*</span></h4>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4 md:gap-5 lg:gap-6">
                            <div>
                                <label for="parent_eleve_id" class="block text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-medium text-gray-700 mb-0.5 sm:mb-1">Choisir un parent</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-2 sm:pl-2.5 md:pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-circle text-gray-400 text-[8px] sm:text-[9px] md:text-xs lg:text-sm"></i>
                                    </span>
                                    <select name="parent_eleve_id" id="parent_eleve_id" required
                                            class="w-full pl-7 sm:pl-8 md:pl-9 lg:pl-11 pr-2 sm:pr-3 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border-2 border-gray-200 rounded-lg md:rounded-xl text-[9px] sm:text-[10px] md:text-xs focus:border-green-400 focus:ring-1 @error('parent_eleve_id') border-red-500 @enderror">
                                        <option value="" disabled selected>Sélectionnez...</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_eleve_id') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->prenom }} {{ $parent->nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_eleve_id')<p class="mt-0.5 text-[8px] text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <!-- Aperçu Parent -->
                            <div id="parentPreview" class="bg-green-50 rounded-lg p-2 sm:p-2.5 md:p-3 hidden">
                                <div class="flex items-center">
                                    <div class="p-1 sm:p-1.5 md:p-2 bg-green-200 rounded-lg">
                                        <i class="fas fa-user-tie text-green-700 text-[10px] sm:text-xs md:text-sm"></i>
                                    </div>
                                    <div class="ml-2 sm:ml-2.5 md:ml-3">
                                        <p class="text-[8px] sm:text-[9px] md:text-xs font-medium text-green-900" id="parentPreviewName"></p>
                                        <p class="text-[7px] sm:text-[8px] md:text-[9px] text-green-700" id="parentPreviewEmail"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Lien parental -->
                    <div class="space-y-2 sm:space-y-3 md:space-y-4">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <div class="w-0.5 h-5 sm:h-6 md:h-7 lg:h-8 bg-purple-600 rounded-full"></div>
                            <h4 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800">Type de lien <span class="text-[8px] sm:text-[9px] text-red-500">*</span></h4>
                        </div>

                        <div>
                            {{-- Grille responsive : 2 colonnes sur mobile, 3 sur tablette, 5 sur desktop --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1.5 sm:gap-2 md:gap-3 lg:gap-4">
                                @php
                                    $liens = [
                                        'Père' => ['blue', 'fa-mars'],
                                        'Mère' => ['pink', 'fa-venus'],
                                        'Tuteur' => ['purple', 'fa-user-tie'],
                                        'Grand-parent' => ['amber', 'fa-users'],
                                        'Autre' => ['gray', 'fa-heart']
                                    ];
                                @endphp

                                @foreach($liens as $lien => $config)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="lien_parental" value="{{ $lien }}" {{ old('lien_parental') == $lien ? 'checked' : '' }} class="sr-only peer" required>
                                        <div class="p-1.5 sm:p-2 md:p-2.5 lg:p-4 bg-gray-50 border-2 border-gray-200 rounded-lg md:rounded-xl text-center peer-checked:border-{{ $config[0] }}-500 peer-checked:bg-{{ $config[0] }}-50 hover:border-{{ $config[0] }}-300 transition-all duration-200">
                                            <div class="p-1 sm:p-1.5 md:p-2 lg:p-3 bg-{{ $config[0] }}-100 rounded-lg inline-block mb-0.5 sm:mb-1 md:mb-2">
                                                <i class="fas {{ $config[1] }} text-{{ $config[0] }}-600 text-[10px] sm:text-xs md:text-sm lg:text-xl"></i>
                                            </div>
                                            <span class="block text-[7px] sm:text-[8px] md:text-[9px] lg:text-sm font-medium text-gray-700">{{ $lien }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('lien_parental')<p class="mt-1.5 text-[8px] text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Section Résumé - Responsive -->
                    <div id="summarySection" class="bg-gray-50 rounded-lg p-2.5 sm:p-3 md:p-4 lg:p-6 hidden">
                        <h5 class="text-xs sm:text-sm md:text-base lg:text-lg font-semibold text-gray-800 mb-2 sm:mb-3 flex items-center">
                            <i class="fas fa-clipboard-list text-indigo-600 mr-1.5 sm:mr-2 text-[10px] sm:text-xs"></i>
                            Résumé
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1.5 sm:gap-2 md:gap-3 lg:gap-4">
                            <div class="bg-white rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 shadow-sm">
                                <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-500">Élève</p>
                                <p class="text-[8px] sm:text-[9px] md:text-[10px] lg:text-sm font-semibold text-gray-800 truncate" id="summaryEleve">-</p>
                            </div>
                            <div class="bg-white rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 shadow-sm">
                                <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-500">Parent</p>
                                <p class="text-[8px] sm:text-[9px] md:text-[10px] lg:text-sm font-semibold text-gray-800 truncate" id="summaryParent">-</p>
                            </div>
                            <div class="bg-white rounded-lg p-1.5 sm:p-2 md:p-2.5 lg:p-3 shadow-sm">
                                <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-500">Lien</p>
                                <p class="text-[8px] sm:text-[9px] md:text-[10px] lg:text-sm font-semibold text-gray-800" id="summaryLien">-</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action - Responsive -->
                    <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 md:gap-4 pt-3 sm:pt-4 md:pt-5 lg:pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleve-parents.index') }}" 
                           class="w-full sm:w-auto text-center px-3 sm:px-4 md:px-5 lg:px-6 py-1.5 sm:py-2 md:py-2.5 lg:py-3 border-2 border-gray-300 text-gray-700 text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-medium rounded-lg md:rounded-xl hover:bg-gray-50 transition-colors">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto px-3 sm:px-4 md:px-6 lg:px-8 py-1.5 sm:py-2 md:py-2.5 lg:py-3 bg-green-600 text-white text-[9px] sm:text-[10px] md:text-xs lg:text-sm font-medium rounded-lg md:rounded-xl hover:bg-green-700 shadow">
                            <i class="fas fa-plus-circle mr-1 sm:mr-1.5 md:mr-2 text-[8px] sm:text-[9px]"></i>
                            Créer la relation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Aide contextuelle - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-3 md:gap-4 mt-3 sm:mt-4 md:mt-6 lg:mt-8">
            <div class="bg-white rounded-lg md:rounded-xl p-2 sm:p-2.5 md:p-3 lg:p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-1 sm:p-1.5 md:p-2 bg-indigo-100 rounded-lg flex-shrink-0">
                        <i class="fas fa-lightbulb text-indigo-600 text-[8px] sm:text-[9px] md:text-xs lg:text-base"></i>
                    </div>
                    <div class="ml-2 sm:ml-2.5 md:ml-3">
                        <h6 class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-800">Astuce #1</h6>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-600">Un élève peut avoir plusieurs parents.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg md:rounded-xl p-2 sm:p-2.5 md:p-3 lg:p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-1 sm:p-1.5 md:p-2 bg-green-100 rounded-lg flex-shrink-0">
                        <i class="fas fa-lightbulb text-green-600 text-[8px] sm:text-[9px] md:text-xs lg:text-base"></i>
                    </div>
                    <div class="ml-2 sm:ml-2.5 md:ml-3">
                        <h6 class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-800">Astuce #2</h6>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-600">Un parent peut être lié à plusieurs élèves.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg md:rounded-xl p-2 sm:p-2.5 md:p-3 lg:p-4 shadow-sm">
                <div class="flex items-center">
                    <div class="p-1 sm:p-1.5 md:p-2 bg-purple-100 rounded-lg flex-shrink-0">
                        <i class="fas fa-lightbulb text-purple-600 text-[8px] sm:text-[9px] md:text-xs lg:text-base"></i>
                    </div>
                    <div class="ml-2 sm:ml-2.5 md:ml-3">
                        <h6 class="text-[8px] sm:text-[9px] md:text-xs lg:text-sm font-semibold text-gray-800">Astuce #3</h6>
                        <p class="text-[7px] sm:text-[8px] md:text-[9px] lg:text-xs text-gray-600">Le lien parental définit la relation exacte.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

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
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        .py-8 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }
        
        .text-sm {
            font-size: 0.65rem;
        }
        
        .text-xs {
            font-size: 0.55rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const eleveSelect = document.getElementById('eleve_id');
    const parentSelect = document.getElementById('parent_eleve_id');
    const elevePreview = document.getElementById('elevePreview');
    const parentPreview = document.getElementById('parentPreview');
    const summarySection = document.getElementById('summarySection');
    const radioButtons = document.querySelectorAll('input[name="lien_parental"]');

    // Data from PHP
    const eleves = @json($eleves->keyBy('id'));
    const parents = @json($parents->keyBy('id'));

    // Update Previews
    function updateElevePreview() {
        const id = eleveSelect.value;
        if (id && eleves[id]) {
            const e = eleves[id];
            document.getElementById('elevePreviewName').textContent = `${e.prenom} ${e.nom}`;
            document.getElementById('elevePreviewClass').textContent = `Classe: ${e.classe?.nom || 'N/A'}`;
            elevePreview.classList.remove('hidden');
            document.getElementById('summaryEleve').textContent = `${e.prenom} ${e.nom}`;
        } else {
            elevePreview.classList.add('hidden');
            document.getElementById('summaryEleve').textContent = 'Non sélectionné';
        }
        updateSummary();
    }

    function updateParentPreview() {
        const id = parentSelect.value;
        if (id && parents[id]) {
            const p = parents[id];
            document.getElementById('parentPreviewName').textContent = `${p.prenom} ${p.nom}`;
            document.getElementById('parentPreviewEmail').textContent = `Email: ${p.email}`;
            parentPreview.classList.remove('hidden');
            document.getElementById('summaryParent').textContent = `${p.prenom} ${p.nom}`;
        } else {
            parentPreview.classList.add('hidden');
            document.getElementById('summaryParent').textContent = 'Non sélectionné';
        }
        updateSummary();
    }

    function updateSummary() {
        const lien = document.querySelector('input[name="lien_parental"]:checked');
        document.getElementById('summaryLien').textContent = lien ? lien.value : 'Non sélectionné';
        
        if (eleveSelect.value || parentSelect.value || lien) {
            summarySection.classList.remove('hidden');
        } else {
            summarySection.classList.add('hidden');
        }
    }

    // Event Listeners
    if (eleveSelect) eleveSelect.addEventListener('change', updateElevePreview);
    if (parentSelect) parentSelect.addEventListener('change', updateParentPreview);
    radioButtons.forEach(r => r.addEventListener('change', updateSummary));

    // Initial Load
    if (eleveSelect.value) updateElevePreview();
    if (parentSelect.value) updateParentPreview();
});
</script>
@endpush