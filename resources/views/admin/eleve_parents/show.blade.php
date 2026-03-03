{{-- resources/views/admin/eleve_parents/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails de la relation Élève-Parent')

@section('header')
    <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 py-6">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white bg-opacity-20 rounded-2xl backdrop-filter backdrop-blur-lg">
                        <i class="fas fa-handshake text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Détails de la relation #{{ $eleveParent->id }}</h1>
                        <p class="text-indigo-100 text-sm mt-1">Consultez les informations détaillées de la relation</p>
                    </div>
                </div>
                <nav class="mt-4 md:mt-0">
                    <ol class="flex items-center space-x-2 text-sm">
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-indigo-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-home mr-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="text-indigo-300">/</li>
                        <li>
                            <a href="{{ route('admin.eleve-parents.index') }}" class="text-indigo-200 hover:text-white transition-colors duration-200">
                                <i class="fas fa-handshake mr-1"></i>Relations
                            </a>
                        </li>
                        <li class="text-indigo-300">/</li>
                        <li class="text-white font-medium">Détails #{{ $eleveParent->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- En-tête avec actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-indigo-100 rounded-2xl">
                        <i class="fas fa-handshake text-3xl text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Relation parent-élève</h2>
                        <p class="text-gray-500 text-sm mt-1">Créée le {{ $eleveParent->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.eleve-parents.edit', $eleveParent) }}" 
                       class="inline-flex items-center px-6 py-3 bg-amber-600 text-white text-sm font-medium rounded-xl hover:bg-amber-700 focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200 shadow-lg shadow-amber-200 group">
                        <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                        Modifier
                    </a>
                    <a href="{{ route('admin.eleve-parents.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gray-600 text-white text-sm font-medium rounded-xl hover:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-lg shadow-gray-200 group">
                        <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-200"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides de la relation -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Lien parental -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Lien parental</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">
                            @php
                                $lienInfo = [
                                    'Père' => ['bg-blue-600', 'fa-mars'],
                                    'Mère' => ['bg-pink-600', 'fa-venus'],
                                    'Tuteur' => ['bg-purple-600', 'fa-user-tie'],
                                    'Grand-parent' => ['bg-amber-600', 'fa-users'],
                                    'Autre' => ['bg-gray-600', 'fa-heart']
                                ];
                                $info = $lienInfo[$eleveParent->lien_parental] ?? $lienInfo['Autre'];
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium {{ $info[0] }} text-white shadow-md">
                                <i class="fas {{ $info[1] }} mr-2"></i>
                                {{ $eleveParent->lien_parental }}
                            </span>
                        </p>
                    </div>
                    <div class="p-4 {{ $info[0] }} rounded-2xl shadow-lg bg-opacity-20">
                        <i class="fas {{ $info[1] }} text-3xl {{ str_replace('bg-', 'text-', $info[0]) }}"></i>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Statut</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-green-600 text-white shadow-md">
                                <i class="fas fa-check-circle mr-2"></i>
                                Active
                            </span>
                        </p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-2xl">
                        <i class="fas fa-check-circle text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Ancienneté -->
            <div class="bg-white rounded-2xl shadow-lg p-6 transform hover:scale-105 transition-transform duration-300 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Ancienneté</p>
                        <p class="text-2xl font-bold text-gray-800 mt-2">
                            @php
                                $days = now()->diffInDays($eleveParent->created_at);
                                if ($days < 30) {
                                    $anciennete = $days . ' jour' . ($days > 1 ? 's' : '');
                                } elseif ($days < 365) {
                                    $mois = floor($days / 30);
                                    $anciennete = $mois . ' mois';
                                } else {
                                    $ans = floor($days / 365);
                                    $anciennete = $ans . ' an' . ($ans > 1 ? 's' : '');
                                }
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white shadow-md">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $anciennete }}
                            </span>
                        </p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-2xl">
                        <i class="fas fa-calendar-alt text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Informations de l'élève -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                            <i class="fas fa-child text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white ml-3">Informations de l'élève</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-20 w-20 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl flex items-center justify-center">
                            <span class="text-indigo-700 font-bold text-2xl">
                                {{ strtoupper(substr($eleveParent->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleveParent->eleve->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">{{ $eleveParent->eleve->prenom }} {{ $eleveParent->eleve->nom }}</h4>
                            <p class="text-gray-500 text-sm mt-1">ID: #{{ $eleveParent->eleve->id }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-indigo-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Date de naissance</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->eleve->date_naissance->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-green-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Classe</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->eleve->classe->nom ?? 'Non assigné' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-id-card text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Matricule</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->eleve->matricule ?? 'N/A' }}</p>
                            </div>
                        </div>

                        @if($eleveParent->eleve->adresse)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-amber-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Adresse</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->eleve->adresse }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100">
                        <a href="#" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors duration-200">
                            <i class="fas fa-external-link-alt mr-1"></i>
                            Voir la fiche complète de l'élève
                        </a>
                    </div>
                </div>
            </div>

            <!-- Informations du parent -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex items-center">
                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                            <i class="fas fa-user-tie text-white text-xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-white ml-3">Informations du parent</h3>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-20 w-20 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl flex items-center justify-center">
                            <span class="text-green-700 font-bold text-2xl">
                                {{ strtoupper(substr($eleveParent->parentEleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleveParent->parentEleve->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-bold text-gray-800">{{ $eleveParent->parentEleve->prenom }} {{ $eleveParent->parentEleve->nom }}</h4>
                            <p class="text-gray-500 text-sm mt-1">ID: #{{ $eleveParent->parentEleve->id }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-blue-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-semibold text-gray-800 break-all">{{ $eleveParent->parentEleve->email }}</p>
                            </div>
                            <button onclick="copyToClipboard('{{ $eleveParent->parentEleve->email }}')" class="ml-2 p-2 text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        @if($eleveParent->parentEleve->telephone)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone-alt text-green-600"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-xs text-gray-500">Téléphone</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->parentEleve->telephone }}</p>
                            </div>
                            <a href="tel:{{ $eleveParent->parentEleve->telephone }}" class="ml-2 p-2 text-gray-400 hover:text-green-600 transition-colors duration-200">
                                <i class="fas fa-phone"></i>
                            </a>
                        </div>
                        @endif

                        @if($eleveParent->parentEleve->adresse)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-amber-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Adresse</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->parentEleve->adresse }}</p>
                            </div>
                        </div>
                        @endif

                        @if($eleveParent->parentEleve->profession)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-briefcase text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500">Profession</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $eleveParent->parentEleve->profession }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 flex space-x-2">
                        <a href="mailto:{{ $eleveParent->parentEleve->email }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-envelope mr-2"></i>
                            Envoyer un email
                        </a>
                        @if($eleveParent->parentEleve->telephone)
                        <a href="tel:{{ $eleveParent->parentEleve->telephone }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-phone mr-2"></i>
                            Appeler
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline de la relation -->
        <div class="bg-white rounded-2xl shadow-lg mt-8 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white ml-3">Historique de la relation</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="relative">
                    <!-- Ligne verticale -->
                    <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                    
                    <!-- Événements -->
                    <div class="relative pl-20">
                        <!-- Création -->
                        <div class="mb-8 relative">
                            <div class="absolute left-0 w-16 flex items-center justify-center">
                                <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-plus text-white"></i>
                                </div>
                            </div>
                            <div class="bg-indigo-50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-indigo-800">Création de la relation</h4>
                                    <span class="text-xs text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">
                                        {{ $eleveParent->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    La relation a été créée par l'administrateur
                                </p>
                            </div>
                        </div>

                        <!-- Dernière modification -->
                        @if($eleveParent->created_at != $eleveParent->updated_at)
                        <div class="mb-8 relative">
                            <div class="absolute left-0 w-16 flex items-center justify-center">
                                <div class="w-10 h-10 bg-amber-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                            </div>
                            <div class="bg-amber-50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-amber-800">Dernière modification</h4>
                                    <span class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded-full">
                                        {{ $eleveParent->updated_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    La relation a été modifiée pour la dernière fois
                                </p>
                            </div>
                        </div>
                        @endif

                        <!-- État actuel -->
                        <div class="relative">
                            <div class="absolute left-0 w-16 flex items-center justify-center">
                                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white"></i>
                                </div>
                            </div>
                            <div class="bg-green-50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-green-800">État actuel</h4>
                                    <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                        Actif
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    La relation est actuellement active et fonctionnelle
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Actions de suppression -->
        <div class="bg-white rounded-2xl shadow-lg mt-8 overflow-hidden border-2 border-red-100">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-white ml-3">Zone de danger</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-red-100 rounded-full">
                            <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Supprimer cette relation</h4>
                            <p class="text-sm text-gray-500 mt-1">
                                Cette action est irréversible. Toutes les données associées seront définitivement perdues.
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('admin.eleve-parents.destroy', $eleveParent) }}" 
                          method="POST" 
                          class="delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg shadow-red-200 group">
                            <i class="fas fa-trash mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast de notification pour copie -->
    <div id="toast" class="fixed bottom-4 right-4 bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg transform transition-transform duration-300 translate-y-20">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-400 mr-2"></i>
            <span>Copié dans le presse-papier !</span>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
<style>
    /* Animation pour le toast */
    #toast {
        transition: transform 0.3s ease-in-out;
    }
    
    #toast.show {
        transform: translateY(0);
    }
    
    /* Animation pour les cartes */
    .transform {
        transition-property: transform, box-shadow;
    }
    
    /* Style pour la timeline */
    .timeline-line {
        position: absolute;
        left: 2rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #e2e8f0, #94a3b8);
    }
    
    /* Animation de hover pour les boutons */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }
    
    .group:hover .group-hover\:-translate-x-1 {
        transform: translateX(-0.25rem);
    }
    
    /* Style pour les tooltips personnalisés */
    [data-tooltip] {
        position: relative;
        cursor: pointer;
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
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier si Font Awesome est chargé
    if (typeof window.FontAwesome === 'undefined') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css';
        document.head.appendChild(link);
    }

    // Gestion de la suppression avec SweetAlert2
    const deleteForm = document.querySelector('.delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Êtes-vous absolument sûr ?',
                text: "Cette action est irréversible ! Toutes les données associées seront définitivement perdues.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer définitivement',
                cancelButtonText: 'Annuler',
                background: '#ffffff',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve();
                        }, 500);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    }

    // Animation au survol des cartes
    const cards = document.querySelectorAll('.transform');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow-xl');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow-xl');
        });
    });
});

// Fonction pour copier dans le presse-papier
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        const toast = document.getElementById('toast');
        toast.classList.add('show');
        
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    }).catch(function(err) {
        console.error('Erreur lors de la copie: ', err);
        alert('Erreur lors de la copie dans le presse-papier');
    });
}
</script>
@endpush