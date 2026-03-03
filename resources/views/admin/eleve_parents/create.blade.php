{{-- resources/views/admin/eleve_parents/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Ajouter une relation Élève-Parent')

@section('header')
    <div class="relative bg-gradient-to-r from-green-600 to-green-800 py-6">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white bg-opacity-20 rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-plus-circle text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Nouvelle relation</h1>
                        <p class="text-green-100 text-sm mt-1">Créez une nouvelle relation entre un élève et un parent</p>
                    </div>
                </div>
                <nav class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-green-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-home mr-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="text-green-300">/</li>
                        <li>
                            <a href="{{ route('admin.eleve-parents.index') }}" class="text-green-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-handshake mr-1"></i>Relations
                            </a>
                        </li>
                        <li class="text-green-300">/</li>
                        <li class="text-white font-medium">Nouvelle relation</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- En-tête avec statistiques rapides -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total élèves -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Élèves disponibles</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Eleve::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-user-graduate text-indigo-500 mr-1"></i>
                            Inscrits
                        </p>
                    </div>
                    <div class="p-4 bg-indigo-100 rounded-2xl">
                        <i class="fas fa-child text-3xl text-indigo-600"></i>
                    </div>
                </div>
            </div>

            <!-- Total parents -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Parents disponibles</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\ParentEleve::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-user-tie text-green-500 mr-1"></i>
                            Inscrits
                        </p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-2xl">
                        <i class="fas fa-user-tie text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Relations existantes -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Relations existantes</p>
                        <p class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\EleveParent::count() }}</p>
                        <p class="text-xs text-gray-400 mt-1 flex items-center">
                            <i class="fas fa-link text-purple-500 mr-1"></i>
                            Total
                        </p>
                    </div>
                    <div class="p-4 bg-purple-100 rounded-2xl">
                        <i class="fas fa-handshake text-3xl text-purple-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message de bienvenue -->
        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 mb-8 border border-green-200">
            <div class="flex items-center">
                <div class="p-3 bg-green-200 rounded-full">
                    <i class="fas fa-info-circle text-green-700 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-green-800">Créer une nouvelle relation</h3>
                    <p class="text-green-700 text-sm mt-1">
                        Sélectionnez un élève et un parent, puis définissez le lien parental qui les unit.
                        Tous les champs marqués d'un astérisque (<span class="text-red-500">*</span>) sont obligatoires.
                    </p>
                </div>
            </div>
        </div>

        <!-- Formulaire de création -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- En-tête du formulaire -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-pen text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white ml-3">Informations de la relation</h3>
                </div>
                <p class="text-green-100 text-sm mt-2 ml-12">
                    Remplissez le formulaire ci-dessous pour créer une nouvelle relation
                </p>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.eleve-parents.store') }}" method="POST" class="space-y-8" id="createForm">
                    @csrf

                    <!-- Section Élève -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-indigo-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-child text-indigo-600 mr-2"></i>
                                Sélection de l'élève
                            </h4>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full ml-2">Obligatoire</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="eleve_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-search text-indigo-500 mr-2"></i>Choisir un élève
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-graduation-cap text-gray-400"></i>
                                    </span>
                                    <select name="eleve_id" 
                                            id="eleve_id" 
                                            class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 @error('eleve_id') border-red-500 @enderror"
                                            required>
                                        <option value="" disabled {{ old('eleve_id') ? '' : 'selected' }}>Sélectionnez un élève...</option>
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                                {{ $eleve->prenom }} {{ $eleve->nom }} ({{ $eleve->classe->nom ?? 'Classe N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('eleve_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Aperçu de l'élève sélectionné -->
                            <div id="elevePreview" class="bg-indigo-50 rounded-xl p-4 hidden">
                                <div class="flex items-center">
                                    <div class="p-3 bg-indigo-200 rounded-lg">
                                        <i class="fas fa-child text-indigo-700 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-indigo-900" id="elevePreviewName"></p>
                                        <p class="text-xs text-indigo-700" id="elevePreviewClass"></p>
                                        <p class="text-xs text-indigo-700 mt-1" id="elevePreviewId"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Parent -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-green-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-user-tie text-green-600 mr-2"></i>
                                Sélection du parent
                            </h4>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full ml-2">Obligatoire</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="parent_eleve_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-search text-green-500 mr-2"></i>Choisir un parent
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user-circle text-gray-400"></i>
                                    </span>
                                    <select name="parent_eleve_id" 
                                            id="parent_eleve_id" 
                                            class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-400 focus:ring-2 focus:ring-green-200 transition-all duration-200 @error('parent_eleve_id') border-red-500 @enderror"
                                            required>
                                        <option value="" disabled {{ old('parent_eleve_id') ? '' : 'selected' }}>Sélectionnez un parent...</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ old('parent_eleve_id') == $parent->id ? 'selected' : '' }}
                                                    data-email="{{ $parent->email }}"
                                                    data-phone="{{ $parent->telephone ?? 'Non renseigné' }}">
                                                {{ $parent->prenom }} {{ $parent->nom }} ({{ $parent->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('parent_eleve_id')
                                        <p class="mt-2 text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Aperçu du parent sélectionné -->
                            <div id="parentPreview" class="bg-green-50 rounded-xl p-4 hidden">
                                <div class="flex items-center">
                                    <div class="p-3 bg-green-200 rounded-lg">
                                        <i class="fas fa-user-tie text-green-700 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-900" id="parentPreviewName"></p>
                                        <p class="text-xs text-green-700" id="parentPreviewEmail"></p>
                                        <p class="text-xs text-green-700 mt-1" id="parentPreviewPhone"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Lien parental -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-purple-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-link text-purple-600 mr-2"></i>
                                Type de lien parental
                            </h4>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded-full ml-2">Obligatoire</span>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                                    @php
                                        $liens = [
                                            'Père' => ['bg-blue-600', 'fa-mars', 'blue'],
                                            'Mère' => ['bg-pink-600', 'fa-venus', 'pink'],
                                            'Tuteur' => ['bg-purple-600', 'fa-user-tie', 'purple'],
                                            'Grand-parent' => ['bg-amber-600', 'fa-users', 'amber'],
                                            'Autre' => ['bg-gray-600', 'fa-heart', 'gray']
                                        ];
                                    @endphp

                                    @foreach($liens as $lien => $config)
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" 
                                                   name="lien_parental" 
                                                   value="{{ $lien }}"
                                                   {{ old('lien_parental') == $lien ? 'checked' : '' }}
                                                   class="sr-only peer" 
                                                   required>
                                            <div class="w-full p-4 bg-gray-50 border-2 border-gray-200 rounded-xl peer-checked:border-{{ $config[2] }}-500 peer-checked:bg-{{ $config[2] }}-50 transition-all duration-200 hover:shadow-lg hover:border-{{ $config[2] }}-300 group-hover:scale-105">
                                                <div class="flex flex-col items-center">
                                                    <div class="p-3 {{ $config[0] }} rounded-xl text-white mb-2 shadow-md">
                                                        <i class="fas {{ $config[1] }} text-xl"></i>
                                                    </div>
                                                    <span class="text-sm font-medium text-gray-700">{{ $lien }}</span>
                                                </div>
                                            </div>
                                            <div class="absolute -top-2 -right-2 w-5 h-5 bg-green-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                                <i class="fas fa-check text-white text-xs"></i>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('lien_parental')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section Résumé -->
                    <div id="summarySection" class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 hidden">
                        <h5 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>
                            Résumé de la relation
                        </h5>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Élève</p>
                                <p class="text-sm font-semibold text-gray-800" id="summaryEleve">Non sélectionné</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Parent</p>
                                <p class="text-sm font-semibold text-gray-800" id="summaryParent">Non sélectionné</p>
                            </div>
                            <div class="bg-white rounded-lg p-3 shadow-sm">
                                <p class="text-xs text-gray-500">Lien parental</p>
                                <p class="text-sm font-semibold text-gray-800" id="summaryLien">Non sélectionné</p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleve-parents.index') }}" 
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 flex items-center group">
                            <i class="fas fa-times mr-2 group-hover:rotate-90 transition-transform duration-200"></i>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-medium rounded-xl hover:from-green-700 hover:to-green-800 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg shadow-green-200 group">
                            <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Créer la relation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Aide contextuelle -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <i class="fas fa-lightbulb text-indigo-600"></i>
                    </div>
                    <div class="ml-3">
                        <h6 class="text-sm font-semibold text-gray-800">Astuce #1</h6>
                        <p class="text-xs text-gray-600">Un élève peut avoir plusieurs parents</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-lightbulb text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <h6 class="text-sm font-semibold text-gray-800">Astuce #2</h6>
                        <p class="text-xs text-gray-600">Un parent peut être lié à plusieurs élèves</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-4 shadow-md">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-lightbulb text-purple-600"></i>
                    </div>
                    <div class="ml-3">
                        <h6 class="text-sm font-semibold text-gray-800">Astuce #3</h6>
                        <p class="text-xs text-gray-600">Le lien parental définit la relation exacte</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
<style>
    /* Animations personnalisées */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(-10px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
    
    .animate-slideIn {
        animation: slideIn 0.3s ease-out;
    }
    
    .animate-pulse-slow {
        animation: pulse 2s infinite;
    }
    
    /* Style pour les cartes */
    .transform {
        transition-property: transform, box-shadow;
    }
    
    /* Style pour les boutons radio personnalisés */
    input[type="radio"]:checked + div {
        transform: scale(1.02);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    input[type="radio"]:checked + div i {
        animation: bounce 0.3s ease;
    }
    
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }
    
    /* Style pour les tooltips */
    [data-tooltip] {
        position: relative;
        cursor: help;
    }
    
    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #1f2937;
        color: white;
        font-size: 12px;
        border-radius: 6px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
        margin-bottom: 5px;
        z-index: 50;
    }
    
    [data-tooltip]:hover:before {
        opacity: 1;
        visibility: visible;
    }
    
    /* Animation pour les messages d'erreur */
    .text-red-600 {
        animation: slideIn 0.3s ease-out;
    }
    
    /* Style pour les champs de formulaire */
    select, input {
        transition: all 0.2s ease;
    }
    
    select:hover, input:hover {
        border-color: #9ca3af;
    }
    
    /* Style pour les ombres */
    .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Animation de chargement */
    .loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }
    
    .loading:after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid #fff;
        border-top-color: transparent;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si Font Awesome est chargé
    if (typeof window.FontAwesome === 'undefined') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(link);
    }

    // Éléments du DOM
    const eleveSelect = document.getElementById('eleve_id');
    const parentSelect = document.getElementById('parent_eleve_id');
    const elevePreview = document.getElementById('elevePreview');
    const parentPreview = document.getElementById('parentPreview');
    const summarySection = document.getElementById('summarySection');
    const radioButtons = document.querySelectorAll('input[name="lien_parental"]');

    // Données (vous pouvez les passer depuis PHP si nécessaire)
    const eleves = @json($eleves->keyBy('id'));
    const parents = @json($parents->keyBy('id'));

    // Mettre à jour l'aperçu de l'élève
    function updateElevePreview() {
        const eleveId = eleveSelect.value;
        if (eleveId && eleves[eleveId]) {
            const eleve = eleves[eleveId];
            document.getElementById('elevePreviewName').textContent = `${eleve.prenom} ${eleve.nom}`;
            document.getElementById('elevePreviewClass').textContent = `Classe: ${eleve.classe?.nom || 'N/A'}`;
            document.getElementById('elevePreviewId').textContent = `ID: ${eleve.id}`;
            elevePreview.classList.remove('hidden');
            elevePreview.classList.add('animate-fadeIn');
            document.getElementById('summaryEleve').textContent = `${eleve.prenom} ${eleve.nom}`;
        } else {
            elevePreview.classList.add('hidden');
            document.getElementById('summaryEleve').textContent = 'Non sélectionné';
        }
        updateSummary();
    }

    // Mettre à jour l'aperçu du parent
    function updateParentPreview() {
        const parentId = parentSelect.value;
        if (parentId && parents[parentId]) {
            const parent = parents[parentId];
            document.getElementById('parentPreviewName').textContent = `${parent.prenom} ${parent.nom}`;
            document.getElementById('parentPreviewEmail').textContent = `Email: ${parent.email}`;
            document.getElementById('parentPreviewPhone').textContent = `Tél: ${parent.telephone || 'Non renseigné'}`;
            parentPreview.classList.remove('hidden');
            parentPreview.classList.add('animate-fadeIn');
            document.getElementById('summaryParent').textContent = `${parent.prenom} ${parent.nom}`;
        } else {
            parentPreview.classList.add('hidden');
            document.getElementById('summaryParent').textContent = 'Non sélectionné';
        }
        updateSummary();
    }

    // Mettre à jour le résumé
    function updateSummary() {
        const eleveSelected = eleveSelect.value && eleves[eleveSelect.value];
        const parentSelected = parentSelect.value && parents[parentSelect.value];
        const lienSelected = document.querySelector('input[name="lien_parental"]:checked');

        if (eleveSelected || parentSelected || lienSelected) {
            summarySection.classList.remove('hidden');
            summarySection.classList.add('animate-fadeIn');
        } else {
            summarySection.classList.add('hidden');
        }

        if (lienSelected) {
            document.getElementById('summaryLien').textContent = lienSelected.value;
        } else {
            document.getElementById('summaryLien').textContent = 'Non sélectionné';
        }
    }

    // Événements pour les sélecteurs
    if (eleveSelect) {
        eleveSelect.addEventListener('change', updateElevePreview);
        if (eleveSelect.value) {
            updateElevePreview();
        }
    }

    if (parentSelect) {
        parentSelect.addEventListener('change', updateParentPreview);
        if (parentSelect.value) {
            updateParentPreview();
        }
    }

    // Événements pour les boutons radio
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                updateSummary();
                this.parentElement.classList.add('animate-pulse-slow');
                setTimeout(() => {
                    this.parentElement.classList.remove('animate-pulse-slow');
                }, 500);
            }
        });
    });

    // Animation au focus des sélecteurs
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-indigo-200');
        });
        select.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-indigo-200');
        });
    });

    // Animation au survol des options de lien
    radioButtons.forEach(radio => {
        const container = radio.parentElement;
        container.addEventListener('mouseenter', function() {
            if (!radio.checked) {
                const div = this.querySelector('div');
                div.classList.add('border-indigo-300', 'shadow-lg');
            }
        });
        container.addEventListener('mouseleave', function() {
            if (!radio.checked) {
                const div = this.querySelector('div');
                div.classList.remove('border-indigo-300', 'shadow-lg');
            }
        });
    });

    // Animation des cartes statistiques
    const statCards = document.querySelectorAll('.transform');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-xl');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-xl');
        });
    });

    // Empêcher la soumission accidentelle avec la touche Entrée
    const form = document.getElementById('createForm');
    const inputs = form.querySelectorAll('input:not([type="radio"]), select');
    inputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    });

    // Validation du formulaire
    form.addEventListener('submit', function(e) {
        const eleveSelected = eleveSelect.value;
        const parentSelected = parentSelect.value;
        const lienSelected = document.querySelector('input[name="lien_parental"]:checked');

        if (!eleveSelected || !parentSelected || !lienSelected) {
            e.preventDefault();
            
            let message = 'Veuillez remplir tous les champs obligatoires :\n';
            if (!eleveSelected) message += '- Sélectionnez un élève\n';
            if (!parentSelected) message += '- Sélectionnez un parent\n';
            if (!lienSelected) message += '- Sélectionnez un lien parental\n';
            
            alert(message);
            
            // Mettre en évidence les champs manquants
            if (!eleveSelected) {
                eleveSelect.classList.add('border-red-500', 'animate-pulse');
                setTimeout(() => eleveSelect.classList.remove('animate-pulse'), 1000);
            }
            if (!parentSelected) {
                parentSelect.classList.add('border-red-500', 'animate-pulse');
                setTimeout(() => parentSelect.classList.remove('animate-pulse'), 1000);
            }
        } else {
            // Ajouter un état de chargement
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
        }
    });

    // Effacer les messages d'erreur lors de la modification
    eleveSelect.addEventListener('change', function() {
        this.classList.remove('border-red-500');
    });
    parentSelect.addEventListener('change', function() {
        this.classList.remove('border-red-500');
    });
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('input[name="lien_parental"]').forEach(r => {
                r.classList.remove('border-red-500');
            });
        });
    });
});
</script>
@endpush