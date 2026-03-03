@extends('layouts.app')

@section('title', 'Détails du parent')

@section('header')
<div class="relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 py-12">
    <!-- Éléments décoratifs animés -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-300 rounded-full mix-blend-overlay filter blur-3xl animate-pulse delay-1000"></div>
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
                            <a href="{{ route('admin.parents.index') }}" class="inline-flex items-center text-sm font-medium text-blue-200 hover:text-white transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Parents
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-white md:ml-2">{{ $parent->full_name }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-2 animate-fade-in-up">
                    {{ $parent->full_name }}
                </h1>
                <p class="text-blue-200 text-base md:text-lg animate-fade-in-up animation-delay-200">
                    {{ $parent->profession ?? 'Parent d\'élève' }}
                </p>
            </div>
            <div class="mt-6 md:mt-0 flex justify-center md:justify-end space-x-3 animate-fade-in-right">
                <a href="{{ route('admin.parents.edit', $parent) }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl overflow-hidden">
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.parents.index') }}" 
                   class="group relative inline-flex items-center px-5 py-2.5 bg-white/10 backdrop-blur-lg hover:bg-white/20 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 border border-white/20">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour à la liste
                </a>
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
    <!-- Badges de statut flottants -->
    <div class="relative mb-8">
        <div class="absolute -top-12 right-0 flex space-x-2">
            <!-- Statut du compte -->
            <div class="bg-white rounded-full shadow-xl px-6 py-3 flex items-center space-x-3 animate-bounce-slow">
                <span class="text-sm font-medium text-gray-600">Compte :</span>
                @if($parent->hasUserAccount())
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Actif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Sans compte
                    </span>
                @endif
            </div>
            
            <!-- Statut du parent -->
            @if($parent->statut !== null)
            <div class="bg-white rounded-full shadow-xl px-6 py-3 flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">Statut :</span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $parent->statut ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $parent->statut ? 'Actif' : 'Inactif' }}
                </span>
            </div>
            @endif
        </div>
    </div>

    <!-- Cartes d'information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Carte Photo/Identité -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Identité</h3>
            </div>
            <div class="p-6">
                <div class="relative inline-block mb-6">
                    @if($parent->photo)
                        <img src="{{ Storage::url($parent->photo) }}" alt="{{ $parent->full_name }}" 
                             class="w-32 h-32 rounded-2xl object-cover shadow-lg mx-auto transform hover:scale-110 transition-transform duration-300">
                    @else
                        <div class="w-32 h-32 {{ $parent->avatar_color }} rounded-2xl flex items-center justify-center text-white font-bold text-4xl shadow-lg mx-auto transform hover:scale-110 transition-transform duration-300">
                            {{ $parent->initiales }}
                        </div>
                    @endif
                    @if($parent->hasUserAccount())
                        <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-green-400 border-4 border-white rounded-full animate-pulse"></div>
                    @endif
                </div>
                
                <h2 class="text-2xl font-bold text-gray-800 text-center">{{ $parent->full_name }}</h2>
                <p class="text-gray-500 text-center">{{ $parent->profession ?? 'Profession non renseignée' }}</p>
                
                <div class="mt-4 flex justify-center space-x-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium rounded-full">
                        {{ $parent->genre_text }}
                    </span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-sm font-medium rounded-full">
                        ID: #{{ $parent->id }}
                    </span>
                </div>

                <!-- Informations supplémentaires -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        @if($parent->date_naissance)
                        <div>
                            <p class="text-gray-500">Date naissance</p>
                            <p class="font-medium">{{ $parent->date_naissance->format('d/m/Y') }} ({{ $parent->date_naissance->age }} ans)</p>
                        </div>
                        @endif
                        @if($parent->lieu_naissance)
                        <div>
                            <p class="text-gray-500">Lieu naissance</p>
                            <p class="font-medium">{{ $parent->lieu_naissance }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Coordonnées -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Coordonnées</h3>
            </div>
            <div class="p-6 space-y-4">
                @if($parent->telephone)
                    <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                        <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Téléphone</p>
                            <p class="font-medium text-gray-800">{{ $parent->telephone }}</p>
                            @if($parent->telephone_secondary)
                                <p class="text-sm text-gray-600 mt-1">{{ $parent->telephone_secondary }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($parent->email)
                    <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Email</p>
                            <p class="font-medium text-gray-800">{{ $parent->email }}</p>
                        </div>
                    </div>
                @endif

                @if($parent->adresse)
                    <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-300">
                        <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Adresse</p>
                            <p class="font-medium text-gray-800">{{ $parent->adresse }}</p>
                        </div>
                    </div>
                @endif

                <!-- Réseaux sociaux (si présents) -->
                <div class="flex space-x-2 mt-4">
                    @if($parent->facebook)
                        <a href="{{ $parent->facebook }}" target="_blank" class="p-2 bg-blue-100 text-blue-600 rounded-xl hover:bg-blue-600 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12z"></path>
                            </svg>
                        </a>
                    @endif
                    @if($parent->whatsapp)
                        <a href="https://wa.me/{{ $parent->whatsapp }}" target="_blank" class="p-2 bg-green-100 text-green-600 rounded-xl hover:bg-green-600 hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.45-1.272.61-1.447c.159-.175.347-.219.462-.219.115 0 .231 0 .332.012.106.012.25-.04.39.298.144.405.49 1.393.535 1.493.044.1.072.216.014.349-.058.133-.087.216-.173.332-.086.116-.18.259-.259.347-.087.086-.176.179-.075.352.101.173.447.738.959 1.196.66.59 1.218.774 1.394.86s.274.072.375-.043c.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086.159.058 1.007.475 1.18.562.173.086.289.13.332.202.043.072.043.418-.101.823z"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Carte Compte Utilisateur -->
        <div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white">Compte utilisateur</h3>
            </div>
            <div class="p-6">
                @if($parent->user)
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nom d'utilisateur</p>
                            <p class="text-lg font-bold text-gray-800">{{ $parent->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $parent->user->email }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-200 pt-4 mt-2 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Créé le</span>
                            <span class="font-medium">{{ $parent->user->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Dernière connexion</span>
                            <span class="font-medium">{{ $parent->user->last_login_at ? $parent->user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Rôle</span>
                            <span class="font-medium">{{ $parent->user->roles->pluck('name')->join(', ') ?: 'Parent' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                            <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 mb-2">Aucun compte utilisateur associé</p>
                        <p class="text-sm text-gray-400 mb-4">Ce parent n'a pas encore de compte pour se connecter</p>
                        <a href="{{ route('admin.users.create', ['parent_id' => $parent->id]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer un compte
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistiques du parent -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-lg p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Enfants inscrits</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $parent->enfants_count }}</p>
                </div>
                <div class="bg-blue-100 rounded-xl p-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Notes totales</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $parent->eleves->sum(fn($e) => $e->notes->count()) }}</p>
                </div>
                <div class="bg-green-100 rounded-xl p-2">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Absences</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $parent->eleves->sum(fn($e) => $e->absences->count()) }}</p>
                </div>
                <div class="bg-yellow-100 rounded-xl p-2">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-lg p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Bulletins</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $parent->eleves->sum(fn($e) => $e->bulletins->count()) }}</p>
                </div>
                <div class="bg-purple-100 rounded-xl p-2">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des enfants avec plus de détails -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-white">Enfants associés</h2>
                </div>
                <span class="px-4 py-2 bg-white/20 backdrop-blur-lg text-white rounded-xl text-sm font-medium">
                    {{ $parent->enfants_count }} enfant(s)
                </span>
            </div>
        </div>

        <div class="p-6">
            @if($parent->eleves->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($parent->eleves as $eleve)
                        <div class="group relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 hover:shadow-xl transition-all duration-300">
                            <div class="flex items-start">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                                        <a href="{{ route('admin.eleves.show', $eleve) }}" 
                                           class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-100 rounded-lg transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    
                                    <div class="mt-2 space-y-1">
                                        @if($eleve->classe)
                                            <p class="text-sm text-gray-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"></path>
                                                </svg>
                                                {{ $eleve->classe->nom }}
                                            </p>
                                        @endif
                                        
                                        @if($eleve->pivot && $eleve->pivot->lien_parental)
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
                                                {{ ucfirst($eleve->pivot->lien_parental) }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Dernières notes -->
                                    @if($eleve->notes->count() > 0)
                                        <div class="mt-3 pt-3 border-t border-gray-200">
                                            <p class="text-xs text-gray-500 mb-2">Dernières notes :</p>
                                            <div class="flex space-x-2">
                                                @foreach($eleve->notes->take(3) as $note)
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-lg">
                                                        {{ $note->note }}/20
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-lg mb-2">Aucun enfant associé à ce parent</p>
                    <p class="text-sm text-gray-400 mb-4">Ce parent n'a pas encore d'enfants inscrits dans l'établissement</p>
                    <a href="{{ route('admin.parents.edit', $parent) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter des enfants
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Notes et informations système -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @if($parent->notes)
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Notes internes</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $parent->notes }}</p>
                </div>
                <p class="text-xs text-gray-500 mt-3 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Dernière modification : {{ $parent->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden {{ !$parent->notes ? 'md:col-span-2' : '' }} hover:shadow-2xl transition-all duration-300">
            <div class="bg-gradient-to-r from-gray-800 to-gray-900 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Informations système</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Créé le</span>
                        <span class="font-medium text-gray-800">{{ $parent->created_at->format('d/m/Y à H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">Dernière mise à jour</span>
                        <span class="font-medium text-gray-800">{{ $parent->updated_at->format('d/m/Y à H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-gray-600">ID unique</span>
                        <span class="font-mono text-sm bg-gray-100 px-3 py-1 rounded-lg text-gray-800">#{{ $parent->id }}</span>
                    </div>
                    @if($parent->created_by)
                    <div class="flex justify-between items-center py-3">
                        <span class="text-gray-600">Créé par</span>
                        <span class="font-medium text-gray-800">{{ $parent->creator->name ?? 'Système' }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions supplémentaires -->
    <div class="mt-8 flex justify-end space-x-4">
        <button onclick="window.print()" 
                class="group px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-medium rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center">
            <svg class="w-5 h-5 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer la fiche
        </button>
        
        <a href="{{ route('admin.parents.index') }}" 
           class="px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
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
    
    .animate-bounce-slow {
        animation: bounce 3s infinite;
    }
    
    /* Style pour l'impression */
    @media print {
        .no-print {
            display: none !important;
        }
        body {
            background-color: white;
        }
        .shadow-xl {
            box-shadow: none !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Animation au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.bg-white').forEach(el => {
        observer.observe(el);
    });
</script>
@endpush