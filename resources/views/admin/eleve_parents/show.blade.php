{{-- resources/views/admin/eleve_parents/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Détails de la relation Élève-Parent')

@section('header')
    {{-- Header avec animation de fond subtile --}}
    <div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 py-4 md:py-6 overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        {{-- Effet de lumière animé en arrière-plan (subtil) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-5 transform -skew-x-12 translate-x-full animate-shimmer"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div class="flex items-center space-x-3 md:space-x-4 group">
                    <div class="p-2 md:p-3 bg-white bg-opacity-20 rounded-xl md:rounded-2xl backdrop-filter backdrop-blur-lg transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-handshake text-lg md:text-2xl text-white transition-transform duration-300 group-hover:rotate-12"></i>
                    </div>
                    <div>
                        <h1 class="text-lg md:text-2xl font-bold text-white transition-colors duration-300">
                            Relation #{{ $eleveParent->id }}
                        </h1>
                        <p class="text-indigo-100 text-[10px] md:text-sm mt-0.5">Détails de la relation</p>
                    </div>
                </div>
                <nav class="mt-2 md:mt-0">
                    <ol class="flex items-center space-x-1 md:space-x-2 text-[10px] md:text-sm">
                        <li><a href="{{ route('dashboard') }}" class="text-indigo-200 hover:text-white transition-colors duration-200 flex items-center"><i class="fas fa-home mr-1"></i>Dashboard</a></li>
                        <li class="text-indigo-300">/</li>
                        <li><a href="{{ route('admin.eleve-parents.index') }}" class="text-indigo-200 hover:text-white transition-colors duration-200">Relations</a></li>
                        <li class="text-indigo-300">/</li>
                        <li class="text-white font-medium">Détails</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mx-auto px-4 md:px-6 py-6 md:py-8">
        
        <!-- En-tête avec actions -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 mb-6 md:mb-8 transition-shadow duration-300 hover:shadow-xl">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <div class="p-2 md:p-4 bg-indigo-100 rounded-xl md:rounded-2xl transition-transform duration-300 hover:rotate-6">
                        <i class="fas fa-handshake text-xl md:text-3xl text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-base md:text-xl font-bold text-gray-800">Relation Parent-Élève</h2>
                        <p class="text-gray-500 text-[10px] md:text-sm mt-0.5">
                            Créée le {{ $eleveParent->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch gap-2 w-full md:w-auto">
                    <a href="{{ route('admin.eleve-parents.edit', $eleveParent) }}" 
                       class="flex-1 text-center px-4 py-2.5 bg-amber-600 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl hover:bg-amber-700 transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-edit transition-transform duration-300 group-hover:rotate-12"></i>
                        <span>Modifier</span>
                    </a>
                    <a href="{{ route('admin.eleve-parents.index') }}" 
                       class="flex-1 text-center px-4 py-2.5 bg-gray-600 text-white text-xs md:text-sm font-medium rounded-lg md:rounded-xl hover:bg-gray-700 transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left transition-transform duration-300 group-hover:-translate-x-1"></i>
                        <span>Retour</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
            <!-- Lien parental -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-indigo-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] md:text-sm font-medium text-gray-500 uppercase">Lien parental</p>
                        <div class="mt-1 md:mt-2">
                            @php
                                $lienInfo = [
                                    'Père' => ['bg-blue-600', 'fa-mars', 'text-blue-600', 'bg-blue-100'],
                                    'Mère' => ['bg-pink-600', 'fa-venus', 'text-pink-600', 'bg-pink-100'],
                                    'Tuteur' => ['bg-purple-600', 'fa-user-tie', 'text-purple-600', 'bg-purple-100'],
                                    'Grand-parent' => ['bg-amber-600', 'fa-users', 'text-amber-600', 'bg-amber-100'],
                                    'Autre' => ['bg-gray-600', 'fa-heart', 'text-gray-600', 'bg-gray-100']
                                ];
                                $info = $lienInfo[$eleveParent->lien_parental] ?? $lienInfo['Autre'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] md:text-sm font-medium {{ $info[0] }} text-white shadow-sm transition-transform duration-300 group-hover:scale-105">
                                <i class="fas {{ $info[1] }} mr-1.5 text-[10px]"></i>
                                {{ $eleveParent->lien_parental }}
                            </span>
                        </div>
                    </div>
                    <div class="p-2 md:p-4 {{ $info[3] }} rounded-xl md:rounded-2xl transition-transform duration-300 group-hover:rotate-12">
                        <i class="fas {{ $info[1] }} text-xl md:text-3xl {{ $info[2] }}"></i>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-green-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] md:text-sm font-medium text-gray-500 uppercase">Statut</p>
                        <div class="mt-1 md:mt-2">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] md:text-sm font-medium bg-green-600 text-white shadow-sm">
                                <i class="fas fa-check-circle mr-1.5 animate-pulse"></i>
                                Active
                            </span>
                        </div>
                    </div>
                    <div class="p-2 md:p-4 bg-green-100 rounded-xl md:rounded-2xl transition-transform duration-300 group-hover:scale-110">
                        <i class="fas fa-check-circle text-xl md:text-3xl text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Ancienneté -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg p-4 md:p-6 border-l-4 border-blue-500 transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] md:text-sm font-medium text-gray-500 uppercase">Ancienneté</p>
                        <div class="mt-1 md:mt-2">
                            @php
                                $days = now()->diffInDays($eleveParent->created_at);
                                if ($days < 30) $anciennete = $days . ' j';
                                elseif ($days < 365) $anciennete = floor($days / 30) . ' mois';
                                else $anciennete = floor($days / 365) . ' an' . (floor($days / 365) > 1 ? 's' : '');
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] md:text-sm font-medium bg-blue-600 text-white shadow-sm">
                                <i class="fas fa-clock mr-1.5"></i>
                                {{ $anciennete }}
                            </span>
                        </div>
                    </div>
                    <div class="p-2 md:p-4 bg-blue-100 rounded-xl md:rounded-2xl transition-transform duration-300 group-hover:rotate-12">
                        <i class="fas fa-calendar-alt text-xl md:text-3xl text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille principale -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
            <!-- Carte Élève -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg overflow-hidden group transition-all duration-500 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-4 py-3 transition-all duration-300 group-hover:from-indigo-700 group-hover:to-indigo-800">
                    <div class="flex items-center">
                        <div class="p-1.5 md:p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-child text-white text-sm md:text-xl transition-transform duration-300 group-hover:animate-bounce"></i>
                        </div>
                        <h3 class="text-sm md:text-lg font-semibold text-white ml-2 md:ml-3">Informations de l'élève</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6">
                    <div class="flex items-center mb-4 md:mb-6">
                        <div class="h-14 w-14 md:h-20 md:w-20 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl md:rounded-2xl flex items-center justify-center shadow-inner transition-transform duration-300 group-hover:scale-110">
                            <span class="text-indigo-700 font-bold text-lg md:text-2xl">
                                {{ strtoupper(substr($eleveParent->eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleveParent->eleve->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-3 md:ml-4 overflow-hidden">
                            <h4 class="text-base md:text-xl font-bold text-gray-900 truncate transition-colors duration-300 group-hover:text-indigo-700">{{ $eleveParent->eleve->prenom }} {{ $eleveParent->eleve->nom }}</h4>
                            <p class="text-[10px] md:text-sm text-gray-500 mt-0.5">ID: #{{ $eleveParent->eleve->id }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl transition-all duration-200 hover:bg-indigo-50 hover:shadow-sm cursor-default">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-white shadow-sm rounded-lg flex items-center justify-center transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-calendar text-indigo-600 text-xs md:text-sm"></i>
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <p class="text-[10px] text-gray-500">Date de naissance</p>
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $eleveParent->eleve->date_naissance->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-3 bg-gray-50 rounded-xl transition-all duration-200 hover:bg-indigo-50 hover:shadow-sm cursor-default">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-white shadow-sm rounded-lg flex items-center justify-center transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-graduation-cap text-green-600 text-xs md:text-sm"></i>
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <p class="text-[10px] text-gray-500">Classe</p>
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $eleveParent->eleve->classe->nom ?? 'Non assigné' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl transition-all duration-200 hover:bg-indigo-50 hover:shadow-sm cursor-default">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-white shadow-sm rounded-lg flex items-center justify-center transition-transform duration-300 hover:rotate-12">
                                <i class="fas fa-id-card text-purple-600 text-xs md:text-sm"></i>
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <p class="text-[10px] text-gray-500">Matricule</p>
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate font-mono">{{ $eleveParent->eleve->matricule ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Parent -->
            <div class="bg-white rounded-xl md:rounded-2xl shadow-lg overflow-hidden group transition-all duration-500 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-4 py-3 transition-all duration-300 group-hover:from-green-700 group-hover:to-green-800">
                    <div class="flex items-center">
                        <div class="p-1.5 md:p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                            <i class="fas fa-user-tie text-white text-sm md:text-xl transition-transform duration-300 group-hover:animate-bounce"></i>
                        </div>
                        <h3 class="text-sm md:text-lg font-semibold text-white ml-2 md:ml-3">Informations du parent</h3>
                    </div>
                </div>
                <div class="p-4 md:p-6">
                    <div class="flex items-center mb-4 md:mb-6">
                        <div class="h-14 w-14 md:h-20 md:w-20 bg-gradient-to-br from-green-100 to-green-200 rounded-xl md:rounded-2xl flex items-center justify-center shadow-inner transition-transform duration-300 group-hover:scale-110">
                            <span class="text-green-700 font-bold text-lg md:text-2xl">
                                {{ strtoupper(substr($eleveParent->parentEleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleveParent->parentEleve->nom, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-3 md:ml-4 overflow-hidden">
                            <h4 class="text-base md:text-xl font-bold text-gray-900 truncate transition-colors duration-300 group-hover:text-green-700">{{ $eleveParent->parentEleve->prenom }} {{ $eleveParent->parentEleve->nom }}</h4>
                            <p class="text-[10px] md:text-sm text-gray-500 mt-0.5">ID: #{{ $eleveParent->parentEleve->id }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl transition-all duration-200 hover:bg-green-50 hover:shadow-sm cursor-default group/item">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-white shadow-sm rounded-lg flex items-center justify-center transition-transform duration-300 group-hover/item:rotate-12">
                                <i class="fas fa-envelope text-blue-600 text-xs md:text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1 overflow-hidden">
                                <p class="text-[10px] text-gray-500">Email</p>
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $eleveParent->parentEleve->email }}</p>
                            </div>
                            <button onclick="copyToClipboard('{{ $eleveParent->parentEleve->email }}')" class="ml-2 p-1.5 text-gray-400 hover:text-blue-600 transition-all duration-200 hover:scale-125 active:scale-95">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        @if($eleveParent->parentEleve->telephone)
                        <div class="flex items-center p-3 bg-gray-50 rounded-xl transition-all duration-200 hover:bg-green-50 hover:shadow-sm cursor-default group/item">
                            <div class="w-9 h-9 md:w-10 md:h-10 bg-white shadow-sm rounded-lg flex items-center justify-center transition-transform duration-300 group-hover/item:rotate-12">
                                <i class="fas fa-phone-alt text-green-600 text-xs md:text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1 overflow-hidden">
                                <p class="text-[10px] text-gray-500">Téléphone</p>
                                <p class="text-xs md:text-sm font-semibold text-gray-800 truncate">{{ $eleveParent->parentEleve->telephone }}</p>
                            </div>
                            <a href="tel:{{ $eleveParent->parentEleve->telephone }}" class="ml-2 p-1.5 text-gray-400 hover:text-green-600 transition-all duration-200 hover:scale-125 active:scale-95">
                                <i class="fas fa-phone"></i>
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="mt-4 md:mt-6 pt-3 md:pt-4 border-t border-gray-100 flex flex-col sm:flex-row gap-2">
                        <a href="mailto:{{ $eleveParent->parentEleve->email }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95">
                            <i class="fas fa-envelope mr-2"></i>
                            Envoyer Email
                        </a>
                        @if($eleveParent->parentEleve->telephone)
                        <a href="tel:{{ $eleveParent->parentEleve->telephone }}" 
                           class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white text-xs font-medium rounded-lg hover:bg-green-700 transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95">
                            <i class="fas fa-phone mr-2"></i>
                            Appeler
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg mt-6 md:mt-8 overflow-hidden transition-shadow duration-300 hover:shadow-xl">
            <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-4 py-3">
                <div class="flex items-center">
                    <div class="p-1.5 md:p-2 bg-white/20 rounded-lg"><i class="fas fa-history text-white text-sm md:text-xl"></i></div>
                    <h3 class="text-sm md:text-lg font-semibold text-white ml-2 md:ml-3">Historique</h3>
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div class="relative">
                    <!-- Ligne -->
                    <div class="absolute left-4 md:left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-400 to-green-400 rounded-full"></div>
                    
                    <div class="relative pl-10 md:pl-20 space-y-6 md:space-y-8">
                        <!-- Création -->
                        <div class="relative group">
                            <div class="absolute left-0 w-8 md:w-16 flex items-center justify-center -ml-5 md:-ml-10 transition-transform duration-300 group-hover:scale-125">
                                <div class="w-3 h-3 md:w-4 md:h-4 bg-indigo-600 rounded-full ring-4 ring-white shadow"></div>
                            </div>
                            <div class="bg-indigo-50 rounded-lg p-3 md:p-4 border border-indigo-100 transition-all duration-300 group-hover:shadow-md group-hover:border-indigo-200">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                    <h4 class="text-xs md:text-sm font-semibold text-indigo-800">Création</h4>
                                    <span class="text-[10px] text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded-full whitespace-nowrap">{{ $eleveParent->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-[10px] md:text-sm text-gray-600">Relation créée dans le système.</p>
                            </div>
                        </div>

                        <!-- Modification -->
                        @if($eleveParent->created_at != $eleveParent->updated_at)
                        <div class="relative group">
                            <div class="absolute left-0 w-8 md:w-16 flex items-center justify-center -ml-5 md:-ml-10 transition-transform duration-300 group-hover:scale-125">
                                <div class="w-3 h-3 md:w-4 md:h-4 bg-amber-500 rounded-full ring-4 ring-white shadow"></div>
                            </div>
                            <div class="bg-amber-50 rounded-lg p-3 md:p-4 border border-amber-100 transition-all duration-300 group-hover:shadow-md group-hover:border-amber-200">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                    <h4 class="text-xs md:text-sm font-semibold text-amber-800">Modification</h4>
                                    <span class="text-[10px] text-amber-600 bg-amber-100 px-2 py-0.5 rounded-full whitespace-nowrap">{{ $eleveParent->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <p class="text-[10px] md:text-sm text-gray-600">Dernière mise à jour des informations.</p>
                            </div>
                        </div>
                        @endif

                        <!-- État actuel -->
                        <div class="relative group">
                            <div class="absolute left-0 w-8 md:w-16 flex items-center justify-center -ml-5 md:-ml-10 transition-transform duration-300 group-hover:scale-125">
                                <div class="w-3 h-3 md:w-4 md:h-4 bg-green-500 rounded-full ring-4 ring-white shadow animate-pulse"></div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-3 md:p-4 border border-green-100 transition-all duration-300 group-hover:shadow-md group-hover:border-green-200">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 mb-1">
                                    <h4 class="text-xs md:text-sm font-semibold text-green-800">Actif</h4>
                                    <span class="text-[10px] text-green-600 bg-green-100 px-2 py-0.5 rounded-full whitespace-nowrap">En cours</span>
                                </div>
                                <p class="text-[10px] md:text-sm text-gray-600">La relation est actuellement valide.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de danger -->
        <div class="bg-white rounded-xl md:rounded-2xl shadow-lg mt-6 md:mt-8 overflow-hidden border-2 border-red-100 hover:border-red-200 transition-colors duration-300">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3">
                <div class="flex items-center">
                    <div class="p-1.5 md:p-2 bg-white/20 rounded-lg"><i class="fas fa-exclamation-triangle text-white text-sm md:text-xl"></i></div>
                    <h3 class="text-sm md:text-lg font-semibold text-white ml-2 md:ml-3">Zone de danger</h3>
                </div>
            </div>
            <div class="p-4 md:p-6">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full mr-4 flex-shrink-0 animate-pulse">
                            <i class="fas fa-trash-alt text-red-600 text-lg md:text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xs md:text-sm font-semibold text-gray-800">Supprimer cette relation</h4>
                            <p class="text-[10px] md:text-sm text-gray-500">Cette action est irréversible.</p>
                        </div>
                    </div>
                    <form action="{{ route('admin.eleve-parents.destroy', $eleveParent) }}" method="POST" class="delete-form w-full md:w-auto">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-red-600 text-white text-xs md:text-sm font-medium rounded-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105 hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                            <i class="fas fa-trash"></i>
                            Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 left-4 sm:left-auto bg-gray-900 text-white px-4 py-2.5 rounded-lg shadow-2xl transform translate-y-20 opacity-0 transition-all duration-500 ease-out z-50 flex items-center text-sm">
        <i class="fas fa-check-circle text-green-400 mr-2"></i>
        <span>Copié dans le presse-papier !</span>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection

@push('styles')
<style>
    /* Animation de fond pour le header */
    @keyframes shimmer {
        0% { transform: translateX(-100%) skewX(-12deg); }
        100% { transform: translateX(200%) skewX(-12deg); }
    }
    .animate-shimmer {
        animation: shimmer 3s infinite;
    }

    /* Animation de pulse doux pour les icônes actives */
    @keyframes soft-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    
    /* Effet de survol des lignes d'infos */
    .group\/item:hover .fa-spin-hover {
        animation: fa-spin 1s infinite linear;
    }

    /* Gestion du Toast */
    #toast.show {
        transform: translateY(0);
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete Confirm
    const deleteForm = document.querySelector('.delete-form');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Supprimer ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Oui, supprimer',
                showClass: { popup: 'animate__animated animate__fadeInDown' },
                hideClass: { popup: 'animate__animated animate__fadeOutUp' }
            }).then((result) => { if (result.isConfirmed) this.submit(); });
        });
    }
});

// Copy with Toast
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const toast = document.getElementById('toast');
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2500);
    });
}
</script>
@endpush