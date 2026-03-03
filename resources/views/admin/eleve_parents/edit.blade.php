{{-- resources/views/admin/eleve_parents/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier la relation Élève-Parent')

@section('header')
    <div class="relative bg-gradient-to-r from-amber-600 to-amber-800 py-6">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white bg-opacity-20 rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-edit text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Modifier la relation #{{ $eleveParent->id }}</h1>
                        <p class="text-amber-100 text-sm mt-1">Modifiez les informations de la relation élève-parent</p>
                    </div>
                </div>
                <nav class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-amber-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-home mr-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="text-amber-300">/</li>
                        <li>
                            <a href="{{ route('admin.eleve-parents.index') }}" class="text-amber-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-handshake mr-1"></i>Relations
                            </a>
                        </li>
                        <li class="text-amber-300">/</li>
                        <li class="text-white font-medium">Modifier #{{ $eleveParent->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- En-tête avec aperçu de la relation -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-amber-100 rounded-2xl">
                        <i class="fas fa-pen text-3xl text-amber-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Formulaire de modification</h2>
                        <p class="text-gray-500 text-sm mt-1">Modifiez les informations ci-dessous</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.eleve-parents.show', $eleveParent) }}" 
                       class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg shadow-indigo-200 group">
                        <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        Voir les détails
                    </a>
                    <a href="{{ route('admin.eleve-parents.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white text-sm font-medium rounded-xl hover:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-lg shadow-gray-200 group">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <!-- Aperçu rapide de la relation actuelle -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Élève -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-xl">
                        <i class="fas fa-child text-2xl text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Élève</p>
                        <p class="text-lg font-bold text-gray-800">{{ $eleveParent->eleve->prenom }} {{ $eleveParent->eleve->nom }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $eleveParent->eleve->classe->nom ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Parent -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-user-tie text-2xl text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Parent</p>
                        <p class="text-lg font-bold text-gray-800">{{ $eleveParent->parentEleve->prenom }} {{ $eleveParent->parentEleve->nom }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $eleveParent->parentEleve->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Lien actuel -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-xl">
                        <i class="fas fa-link text-2xl text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Lien actuel</p>
                        @php
                            $badgeConfig = [
                                'Père' => ['bg-blue-100', 'text-blue-800', 'fa-mars'],
                                'Mère' => ['bg-pink-100', 'text-pink-800', 'fa-venus'],
                                'Tuteur' => ['bg-purple-100', 'text-purple-800', 'fa-user-tie'],
                                'Grand-parent' => ['bg-amber-100', 'text-amber-800', 'fa-users'],
                                'Autre' => ['bg-gray-100', 'text-gray-800', 'fa-heart']
                            ];
                            $config = $badgeConfig[$eleveParent->lien_parental] ?? $badgeConfig['Autre'];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium {{ $config[0] }} {{ $config[1] }} mt-1">
                            <i class="fas {{ $config[2] }} mr-2"></i>
                            {{ $eleveParent->lien_parental }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de modification -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-amber-600 to-amber-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-pen text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white ml-3">Modifier les informations</h3>
                </div>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.eleve-parents.update', $eleveParent) }}" method="POST" class="space-y-8">
                    @method('PUT')
                    @csrf

                    <!-- Sélection de l'élève -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-indigo-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800">Informations de l'élève</h4>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="eleve_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-child text-indigo-500 mr-2"></i>Sélectionner l'élève
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <select name="eleve_id" 
                                            id="eleve_id" 
                                            class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-400 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 @error('eleve_id') border-red-500 @enderror"
                                            required>
                                        <option value="">Choisir un élève...</option>
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}" 
                                                {{ old('eleve_id', $eleveParent->eleve_id) == $eleve->id ? 'selected' : '' }}>
                                                {{ $eleve->prenom }} {{ $eleve->nom }} ({{ $eleve->classe->nom ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('eleve_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Affichage des infos rapides de l'élève sélectionné -->
                            <div id="eleveInfo" class="bg-indigo-50 rounded-xl p-4 hidden">
                                <div class="flex items-center">
                                    <div class="p-2 bg-indigo-200 rounded-lg">
                                        <i class="fas fa-info-circle text-indigo-700"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-indigo-900" id="eleveName"></p>
                                        <p class="text-xs text-indigo-700" id="eleveDetails"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sélection du parent -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-green-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800">Informations du parent</h4>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="parent_eleve_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user-tie text-green-500 mr-2"></i>Sélectionner le parent
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </span>
                                    <select name="parent_eleve_id" 
                                            id="parent_eleve_id" 
                                            class="w-full pl-11 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-green-400 focus:ring-2 focus:ring-green-200 transition-all duration-200 @error('parent_eleve_id') border-red-500 @enderror"
                                            required>
                                        <option value="">Choisir un parent...</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" 
                                                {{ old('parent_eleve_id', $eleveParent->parent_eleve_id) == $parent->id ? 'selected' : '' }}
                                                data-email="{{ $parent->email }}"
                                                data-phone="{{ $parent->telephone ?? 'Non renseigné' }}">
                                                {{ $parent->prenom }} {{ $parent->nom }} ({{ $parent->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_eleve_id')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Affichage des infos rapides du parent sélectionné -->
                            <div id="parentInfo" class="bg-green-50 rounded-xl p-4 hidden">
                                <div class="flex items-center">
                                    <div class="p-2 bg-green-200 rounded-lg">
                                        <i class="fas fa-info-circle text-green-700"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-900" id="parentName"></p>
                                        <p class="text-xs text-green-700" id="parentEmail"></p>
                                        <p class="text-xs text-green-700" id="parentPhone"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lien parental -->
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-1 h-8 bg-purple-600 rounded-full"></div>
                            <h4 class="text-lg font-semibold text-gray-800">Lien parental</h4>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="lien_parental" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-link text-purple-500 mr-2"></i>Type de lien
                                </label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @php
                                        $liens = [
                                            'Père' => ['bg-blue-600', 'fa-mars'],
                                            'Mère' => ['bg-pink-600', 'fa-venus'],
                                            'Tuteur' => ['bg-purple-600', 'fa-user-tie'],
                                            'Grand-parent' => ['bg-amber-600', 'fa-users'],
                                            'Autre' => ['bg-gray-600', 'fa-heart']
                                        ];
                                    @endphp

                                    @foreach($liens as $lien => $config)
                                        <label class="relative">
                                            <input type="radio" 
                                                   name="lien_parental" 
                                                   value="{{ $lien }}"
                                                   {{ old('lien_parental', $eleveParent->lien_parental) == $lien ? 'checked' : '' }}
                                                   class="sr-only peer" 
                                                   required>
                                            <div class="w-full p-4 bg-gray-50 border-2 border-gray-200 rounded-xl cursor-pointer peer-checked:border-{{ explode('-', $config[0])[1] }}-500 peer-checked:bg-{{ explode('-', $config[0])[1] }}-50 transition-all duration-200 hover:shadow-md">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas {{ $config[1] }} text-2xl {{ $config[0] }} text-white p-2 rounded-lg mb-2"></i>
                                                    <span class="text-sm font-medium text-gray-700">{{ $lien }}</span>
                                                </div>
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

                            <!-- Aperçu du lien sélectionné -->
                            <div id="lienPreview" class="bg-purple-50 rounded-xl p-4 hidden">
                                <div class="flex items-center">
                                    <div class="p-2 bg-purple-200 rounded-lg">
                                        <i class="fas fa-eye text-purple-700"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-purple-900">Aperçu du lien</p>
                                        <p class="text-xs text-purple-700" id="previewText">Sélectionnez un lien parental</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.eleve-parents.index') }}" 
                           class="px-6 py-3 border-2 border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-600 to-amber-700 text-white text-sm font-medium rounded-xl hover:from-amber-700 hover:to-amber-800 focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 shadow-lg shadow-amber-200 group">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Mettre à jour la relation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations complémentaires -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Dernière modification -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-indigo-100 rounded-xl">
                        <i class="fas fa-clock text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Dernière modification</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $eleveParent->updated_at->format('d/m/Y à H:i') }}</p>
                        <p class="text-xs text-gray-500 mt-1">Il y a {{ $eleveParent->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Création -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-xl">
                        <i class="fas fa-calendar-check text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Créée le</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $eleveParent->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
<style>
    /* Animation pour les cartes */
    .transform {
        transition-property: transform, box-shadow;
    }
    
    /* Style pour les boutons radio personnalisés */
    input[type="radio"]:checked + div {
        transform: scale(1.02);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    /* Animation de survol pour les options de lien */
    .peer-checked + div i {
        animation: bounce 0.3s ease;
    }
    
    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
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
    
    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    /* Style pour les bordures de focus */
    .focus\:border-indigo-400:focus {
        border-color: #818cf8;
    }
    
    .focus\:ring-2:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
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
    const eleveInfo = document.getElementById('eleveInfo');
    const parentInfo = document.getElementById('parentInfo');
    const lienPreview = document.getElementById('lienPreview');
    const previewText = document.getElementById('previewText');
    const radioButtons = document.querySelectorAll('input[name="lien_parental"]');

    // Données des élèves (vous pouvez les passer depuis PHP si nécessaire)
    const eleves = @json($eleves->keyBy('id'));
    const parents = @json($parents->keyBy('id'));

    // Afficher les infos de l'élève sélectionné
    if (eleveSelect) {
        eleveSelect.addEventListener('change', function() {
            const eleveId = this.value;
            if (eleveId && eleves[eleveId]) {
                const eleve = eleves[eleveId];
                document.getElementById('eleveName').textContent = `${eleve.prenom} ${eleve.nom}`;
                document.getElementById('eleveDetails').textContent = `Classe: ${eleve.classe?.nom || 'N/A'}`;
                eleveInfo.classList.remove('hidden');
                eleveInfo.classList.add('animate-fadeIn');
            } else {
                eleveInfo.classList.add('hidden');
            }
        });

        // Déclencher au chargement si une valeur est sélectionnée
        if (eleveSelect.value) {
            eleveSelect.dispatchEvent(new Event('change'));
        }
    }

    // Afficher les infos du parent sélectionné
    if (parentSelect) {
        parentSelect.addEventListener('change', function() {
            const parentId = this.value;
            if (parentId && parents[parentId]) {
                const parent = parents[parentId];
                document.getElementById('parentName').textContent = `${parent.prenom} ${parent.nom}`;
                document.getElementById('parentEmail').textContent = `Email: ${parent.email}`;
                document.getElementById('parentPhone').textContent = `Tél: ${parent.telephone || 'Non renseigné'}`;
                parentInfo.classList.remove('hidden');
                parentInfo.classList.add('animate-fadeIn');
            } else {
                parentInfo.classList.add('hidden');
            }
        });

        // Déclencher au chargement si une valeur est sélectionnée
        if (parentSelect.value) {
            parentSelect.dispatchEvent(new Event('change'));
        }
    }

    // Gestionnaire pour l'aperçu du lien parental
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                const lienValue = this.value;
                const config = {
                    'Père': '👨 Père',
                    'Mère': '👩 Mère',
                    'Tuteur': '👤 Tuteur',
                    'Grand-parent': '👴 Grand-parent',
                    'Autre': '🤝 Autre'
                };
                previewText.textContent = `Lien sélectionné : ${config[lienValue] || lienValue}`;
                lienPreview.classList.remove('hidden');
                lienPreview.classList.add('animate-fadeIn');
            }
        });
    });

    // Vérifier si un lien est déjà sélectionné
    radioButtons.forEach(radio => {
        if (radio.checked) {
            radio.dispatchEvent(new Event('change'));
        }
    });

    // Animation de confirmation avant soumission
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Vous pouvez ajouter une confirmation ici si nécessaire
            console.log('Formulaire soumis');
        });
    }

    // Animation pour les sélecteurs
    const selects = document.querySelectorAll('select');
    selects.forEach(select => {
        select.addEventListener('focus', function() {
            this.parentElement.classList.add('ring-2', 'ring-indigo-200');
        });
        select.addEventListener('blur', function() {
            this.parentElement.classList.remove('ring-2', 'ring-indigo-200');
        });
    });

    // Animation pour les boutons radio au survol
    radioButtons.forEach(radio => {
        radio.addEventListener('mouseenter', function() {
            if (!this.checked) {
                this.nextElementSibling.classList.add('border-indigo-300', 'shadow-md');
            }
        });
        radio.addEventListener('mouseleave', function() {
            if (!this.checked) {
                this.nextElementSibling.classList.remove('border-indigo-300', 'shadow-md');
            }
        });
    });

    // Animation pour les cartes d'information
    const infoCards = document.querySelectorAll('.bg-gradient-to-br');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-lg', 'scale-105');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-lg', 'scale-105');
        });
    });

    // Empêcher la soumission accidentelle avec la touche Entrée
    const inputs = document.querySelectorAll('input:not([type="radio"]), select');
    inputs.forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    });

    // Confirmation avant de quitter si des modifications ont été faites
    let formChanged = false;
    const formInputs = document.querySelectorAll('input, select, textarea');
    formInputs.forEach(input => {
        input.addEventListener('change', function() {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Animation de fadeIn
    const style = document.createElement('style');
    style.textContent = `
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
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush