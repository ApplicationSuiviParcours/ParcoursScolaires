@extends('layouts.app')

@section('header')
    <h2 class="text-sm font-semibold leading-tight text-gray-800">
        {{ __('Mon Profil') }}
    </h2>
@endsection

@section('content')
<div class="py-6 sm:py-12">
    <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">

        {{-- Notifications --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- En-tête profil --}}
        <div class="relative overflow-hidden mb-8 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute w-64 h-64 bg-white rounded-full -top-24 -right-24 blur-3xl animate-pulse"></div>
            </div>
            <div class="relative p-8">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="flex items-center justify-center w-24 h-24 shadow-2xl bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl text-4xl font-bold text-white">
                        {{ strtoupper(substr($enseignant->prenom ?? 'E', 0, 1)) }}{{ strtoupper(substr($enseignant->nom ?? 'N', 0, 1)) }}
                    </div>
                    <div class="text-center sm:text-left">
                        <h1 class="text-3xl font-bold text-white">{{ $enseignant->prenom }} {{ $enseignant->nom }}</h1>
                        <p class="text-indigo-200 mt-1">{{ $enseignant->specialite ?? 'Enseignant' }}</p>
                        <span class="inline-flex items-center px-3 py-1 mt-2 text-sm text-white bg-white/20 backdrop-blur-sm rounded-xl border border-white/30">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            Matricule : {{ $enseignant->matricule ?? 'N/A' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Informations personnelles --}}
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden mb-6">
            <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-600">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informations personnelles
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nom complet</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->prenom }} {{ $enseignant->nom }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->email ?? $enseignant->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Téléphone</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->telephone ?? 'Non renseigné' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Spécialité</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->specialite ?? 'Non renseignée' }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Genre</label>
                        <p class="mt-1 text-gray-900 font-medium">
                            {{ $enseignant->genre === 'm' ? 'Masculin' : ($enseignant->genre === 'f' ? 'Féminin' : 'Non renseigné') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Date d'embauche</label>
                        <p class="mt-1 text-gray-900 font-medium">
                            {{ $enseignant->date_embauche ? \Carbon\Carbon::parse($enseignant->date_embauche)->format('d/m/Y') : 'Non renseignée' }}
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Adresse</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->adresse ?? 'Non renseignée' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Compte utilisateur --}}
        @if($enseignant->user)
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-purple-600 to-pink-600">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                    Compte utilisateur
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nom d'utilisateur</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email de connexion</label>
                        <p class="mt-1 text-gray-900 font-medium">{{ $enseignant->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Rôle</label>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                            {{ $enseignant->user->role ?? 'enseignant' }}
                        </span>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Statut</label>
                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold {{ $enseignant->user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                            {{ $enseignant->user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Modifier mon profil
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection
