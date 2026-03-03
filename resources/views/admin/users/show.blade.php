{{-- resources/views/admin/users/show.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Détails de l\'utilisateur') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Fil d'Ariane -->
            <div class="mb-4 flex items-center gap-2 text-sm text-gray-500 animate-fade-in">
                <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors">Utilisateurs</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-700">{{ $user->name }}</span>
            </div>

            <!-- Carte principale -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <!-- En-tête avec photo et informations principales -->
                <div class="px-6 py-6 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Photo de profil avec options -->
                        <div class="relative group">
                            <div class="h-28 w-28 rounded-full overflow-hidden ring-4 ring-white shadow-xl transform group-hover:scale-105 transition-all duration-300">
                                @if($user->photo)
                                    <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold text-4xl">
                                        {{ $user->initials }}
                                    </div>
                                @endif
                            </div>
                            <!-- Badge de statut avec animation -->
                            <div class="absolute -bottom-2 -right-2 h-7 w-7 rounded-full border-4 border-white 
                                {{ $user->is_active ? 'bg-green-400' : 'bg-red-400' }} group-hover:animate-pulse">
                            </div>
                            
                            <!-- Menu d'actions pour la photo (admin seulement) -->
                            @if(auth()->user()->isAdmin() && $user->photo)
                                <div class="absolute -top-2 -right-2" x-data="{ open: false }">
                                    <button @click="open = !open" class="bg-white text-gray-700 rounded-full p-1 shadow-lg hover:bg-gray-100 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50 text-gray-700">
                                        <a href="{{ $user->photo_url }}" target="_blank" class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Voir en grand
                                        </a>
                                        <a href="{{ route('admin.users.download-photo', $user) }}" class="block px-4 py-2 text-sm hover:bg-gray-100 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Télécharger
                                        </a>
                                        <form action="{{ route('admin.users.delete-photo', $user) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Informations principales -->
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-2xl font-bold">{{ $user->name }}</h3>
                                @if($user->hasMultipleRoles())
                                    <span class="text-xs bg-white text-blue-600 px-2 py-1 rounded-full flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                        </svg>
                                        Multi-rôles ({{ $user->roles->count() }})
                                    </span>
                                @endif
                                @if($user->created_at->isToday())
                                    <span class="text-xs bg-green-400 text-white px-2 py-1 rounded-full animate-pulse">
                                        Nouveau aujourd'hui
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-blue-100 flex items-center gap-2 mt-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Vérifié
                                    </span>
                                @else
                                    <span class="text-xs bg-yellow-500 text-white px-2 py-0.5 rounded-full flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Non vérifié
                                    </span>
                                @endif
                            </p>
                            
                            <!-- Badges des rôles -->
                            <div class="flex flex-wrap gap-2 mt-3">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium
                                        {{ $role->name == 'administrateur' ? 'ring-2 ring-purple-300' : '' }}">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Badge ID utilisateur -->
                        <div class="hidden md:block text-right">
                            <span class="text-xs text-blue-200">ID Utilisateur</span>
                            <p class="text-2xl font-mono font-bold">#{{ $user->id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contenu principal -->
                <div class="p-6">
                    <!-- Statistiques rapides avec plus d'infos -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 text-center border border-gray-100 hover:shadow-md transition-shadow">
                            <p class="text-2xl font-bold text-gray-800">{{ $user->roles->count() }}</p>
                            <p class="text-xs text-gray-500">Rôle(s)</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 text-center border border-gray-100 hover:shadow-md transition-shadow">
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $user->eleve ? 'Élève' : ($user->enseignant ? 'Enseignant' : ($user->parentEleve ? 'Parent' : 'Aucun')) }}
                            </p>
                            <p class="text-xs text-gray-500">Profil principal</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 text-center border border-gray-100 hover:shadow-md transition-shadow">
                            <p class="text-2xl font-bold text-{{ $user->is_active ? 'green' : 'red' }}-600">
                                {{ $user->is_active ? 'Actif' : 'Inactif' }}
                            </p>
                            <p class="text-xs text-gray-500">Statut</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 text-center border border-gray-100 hover:shadow-md transition-shadow">
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $user->enseignant ?: ($user->eleve ?: ($user->parentEleve ? '1' : '0')) }}
                            </p>
                            <p class="text-xs text-gray-500">Profils liés</p>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 text-center border border-gray-100 hover:shadow-md transition-shadow">
                            <p class="text-sm font-bold text-gray-800">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}
                            </p>
                            <p class="text-xs text-gray-500">Dernière connexion</p>
                        </div>
                    </div>

                    <!-- Grille d'informations détaillées -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Colonne gauche - Informations personnelles -->
                        <div class="lg:col-span-1 space-y-4">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Informations personnelles
                                </h4>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Nom complet
                                        </p>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            Email
                                        </p>
                                        <p class="font-medium text-gray-900">{{ $user->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Email vérifié
                                        </p>
                                        <p class="font-medium">
                                            @if($user->email_verified_at)
                                                <span class="text-green-600 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Oui ({{ $user->email_verified_at->format('d/m/Y H:i') }})
                                                </span>
                                            @else
                                                <span class="text-yellow-600 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    En attente de vérification
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                            </svg>
                                            Type de compte
                                        </p>
                                        <p class="font-medium text-gray-900">
                                            @if($user->isAdmin()) Administrateur
                                            @elseif($user->isEnseignant()) Enseignant
                                            @elseif($user->isEleve()) Élève
                                            @elseif($user->isParent()) Parent
                                            @else Utilisateur standard
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                    Rôles et permissions
                                </h4>
                                <div class="space-y-3">
                                    @forelse($user->roles as $role)
                                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 hover:border-purple-200 transition-colors">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full 
                                                    @if($role->name == 'administrateur') bg-purple-500
                                                    @elseif($role->name == 'enseignant') bg-blue-500
                                                    @elseif($role->name == 'eleve') bg-green-500
                                                    @elseif($role->name == 'parent') bg-yellow-500
                                                    @endif">
                                                </span>
                                                <span class="font-medium">{{ ucfirst($role->name) }}</span>
                                            </div>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                @if($role->name == 'administrateur') bg-purple-100 text-purple-800
                                                @elseif($role->name == 'enseignant') bg-blue-100 text-blue-800
                                                @elseif($role->name == 'eleve') bg-green-100 text-green-800
                                                @elseif($role->name == 'parent') bg-yellow-100 text-yellow-800
                                                @endif">
                                                @if($role->name == 'administrateur') Accès total
                                                @elseif($role->name == 'enseignant') Gestion pédagogique
                                                @elseif($role->name == 'eleve') Consultation
                                                @elseif($role->name == 'parent') Suivi scolaire
                                                @endif
                                            </span>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 text-sm text-center py-4">Aucun rôle assigné à cet utilisateur</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Colonne du milieu - Dates et activité -->
                        <div class="lg:col-span-1 space-y-4">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Chronologie du compte
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Création du compte</p>
                                            <p class="text-xs text-gray-500">{{ $user->created_at->format('d/m/Y à H:i:s') }}</p>
                                            <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Dernière mise à jour</p>
                                            <p class="text-xs text-gray-500">{{ $user->updated_at->format('d/m/Y à H:i:s') }}</p>
                                            <p class="text-xs text-gray-400">{{ $user->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>

                                    @if($user->last_login_at)
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Dernière connexion</p>
                                                <p class="text-xs text-gray-500">{{ $user->last_login_at->format('d/m/Y à H:i:s') }}</p>
                                                <p class="text-xs text-gray-400">{{ $user->last_login_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Statistiques d'activité -->
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Activité récente
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Ancienneté</span>
                                        <span class="text-sm font-medium">{{ $user->created_at->diffInDays(now()) }} jours</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Dernière action</span>
                                        <span class="text-sm font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Fréquence de connexion</span>
                                        <span class="text-sm font-medium">
                                            @if($user->last_login_at)
                                                {{ $user->last_login_at->diffInDays(now()) == 0 ? 'Aujourd\'hui' : $user->last_login_at->diffInDays(now()) . ' jours' }}
                                            @else
                                                Jamais
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne droite - Profils associés -->
                        <div class="lg:col-span-1 space-y-4">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2 border-b border-gray-200 pb-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Profils associés
                                </h4>
                                
                                @if($user->enseignant)
                                    <div class="bg-gradient-to-r from-blue-50 to-white rounded-lg p-4 border border-blue-200 mb-3 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="p-2 bg-blue-100 rounded-lg">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-blue-700">Enseignant</p>
                                        </div>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="text-xs text-gray-500">Nom :</span> <span class="font-medium">{{ $user->enseignant->prenom }} {{ $user->enseignant->nom }}</span></p>
                                            <p><span class="text-xs text-gray-500">Spécialité :</span> {{ $user->enseignant->specialite ?? 'Non spécifiée' }}</p>
                                            <p><span class="text-xs text-gray-500">Téléphone :</span> {{ $user->enseignant->telephone ?? 'Non renseigné' }}</p>
                                            <p><span class="text-xs text-gray-500">Email :</span> {{ $user->enseignant->email ?? $user->email }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($user->eleve)
                                    <div class="bg-gradient-to-r from-green-50 to-white rounded-lg p-4 border border-green-200 mb-3 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="p-2 bg-green-100 rounded-lg">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-green-700">Élève</p>
                                        </div>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="text-xs text-gray-500">Nom :</span> <span class="font-medium">{{ $user->eleve->prenom }} {{ $user->eleve->nom }}</span></p>
                                            <p><span class="text-xs text-gray-500">Classe :</span> {{ $user->eleve->classe->nom ?? 'Non assigné' }}</p>
                                            <p><span class="text-xs text-gray-500">Date naissance :</span> {{ $user->eleve->date_naissance ? $user->eleve->date_naissance->format('d/m/Y') : 'Non renseignée' }}</p>
                                            <p><span class="text-xs text-gray-500">Matricule :</span> {{ $user->eleve->matricule ?? 'Non généré' }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($user->parentEleve)
                                    <div class="bg-gradient-to-r from-yellow-50 to-white rounded-lg p-4 border border-yellow-200 mb-3 hover:shadow-md transition-shadow">
                                        <div class="flex items-center gap-2 mb-3">
                                            <div class="p-2 bg-yellow-100 rounded-lg">
                                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-sm font-semibold text-yellow-700">Parent</p>
                                        </div>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="text-xs text-gray-500">Nom :</span> <span class="font-medium">{{ $user->parentEleve->prenom }} {{ $user->parentEleve->nom }}</span></p>
                                            <p><span class="text-xs text-gray-500">Téléphone :</span> {{ $user->parentEleve->telephone ?? 'Non renseigné' }}</p>
                                            <p><span class="text-xs text-gray-500">Profession :</span> {{ $user->parentEleve->profession ?? 'Non renseignée' }}</p>
                                            <p><span class="text-xs text-gray-500">Adresse :</span> {{ $user->parentEleve->adresse ?? 'Non renseignée' }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if(!$user->enseignant && !$user->eleve && !$user->parentEleve)
                                    <div class="bg-gray-100 rounded-lg p-8 text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Aucun profil spécifique associé</p>
                                        <p class="text-xs text-gray-400 mt-1">Cet utilisateur n'a pas de profil enseignant, élève ou parent</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Métadonnées système -->
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Métadonnées
                                </h4>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">ID Utilisateur</span>
                                        <span class="font-mono font-medium">{{ $user->id }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Modèle</span>
                                        <span>User</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Table</span>
                                        <span>users</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Créé par</span>
                                        <span>Système</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions et navigation -->
                    <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-2">
                            <!-- Activer/Désactiver -->
                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-5 py-2.5 {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} text-white rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($user->is_active)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        @endif
                                    </svg>
                                    {{ $user->is_active ? 'Désactiver' : 'Activer' }} le compte
                                </button>
                            </form>

                            <!-- Renvoyer l'email de vérification (si non vérifié) -->
                            @if(!$user->email_verified_at && auth()->user()->isAdmin())
                                <form action="{{ route('verification.resend', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="px-5 py-2.5 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-sm hover:shadow">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        Renvoyer la vérification
                                    </button>
                                </form>
                            @endif

                            <!-- Supprimer (admin seulement) -->
                            @if(auth()->user()->isAdmin() && auth()->id() != $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-5 py-2.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-sm hover:shadow"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet utilisateur ? Cette action est irréversible.')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Supprimer
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-sm hover:shadow">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Retour à la liste
                            </a>
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Modifier
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }

    /* Animation pour les cartes */
    .bg-gradient-to-r {
        transition: all 0.3s ease;
    }

    /* Style pour les badges */
    .badge {
        transition: all 0.2s ease;
    }

    .badge:hover {
        transform: scale(1.05);
    }

    /* Style pour les tooltips personnalisés */
    [x-tooltip] {
        position: relative;
        cursor: help;
    }

    [x-tooltip]:before {
        content: attr(x-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #1f2937;
        color: white;
        font-size: 12px;
        border-radius: 4px;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    [x-tooltip]:hover:before {
        opacity: 1;
    }

    /* Animation de pulsation pour les éléments nouveaux */
    @keyframes pulse-new {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .animate-pulse-new {
        animation: pulse-new 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    // Animation supplémentaire pour les tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipButtons = document.querySelectorAll('[title]');
        tooltipButtons.forEach(button => {
            button.addEventListener('mouseenter', function(e) {
                const tooltip = this.querySelector('span');
                if (tooltip) {
                    tooltip.style.opacity = '1';
                }
            });
            button.addEventListener('mouseleave', function(e) {
                const tooltip = this.querySelector('span');
                if (tooltip) {
                    tooltip.style.opacity = '0';
                }
            });
        });
    });
</script>
@endpush