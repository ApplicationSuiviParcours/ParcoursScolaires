@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
        {{ __('Paramètres de l\'application') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="relative overflow-hidden mb-8 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-xl group">
            <div class="absolute inset-0 opacity-20">
                <div class="absolute w-96 h-96 bg-white rounded-full -top-48 -right-48 blur-3xl animate-pulse-slow"></div>
            </div>
            
            <div class="relative p-6 sm:p-8">
                <div class="flex items-center space-x-4 sm:space-x-6">
                    <div class="flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-white/20 border-2 border-white/30 rounded-2xl backdrop-blur-sm shadow-xl transition-transform group-hover:scale-105">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-white drop-shadow-lg">Gérer vos paramètres</h3>
                        <p class="text-blue-100 mt-1 text-sm sm:text-base">Configurez votre compte, vos préférences et la sécurité</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Carte Profil -->
            <a href="{{ route('profile.edit') }}" class="group block p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 flex flex-shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Informations du Profil</h4>
                        <p class="text-sm text-gray-500 line-clamp-1">Vos informations personnelles</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Mettez à jour votre nom, votre adresse email et d'autres informations publiques.</p>
                <div class="flex items-center text-blue-600 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                    Gérer le profil 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </div>
            </a>

            <!-- Carte Sécurité -->
            @if(Route::has('profile.password'))
            <a href="{{ route('profile.password') }}" class="group block p-6 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:border-red-100 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-12 h-12 flex flex-shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Sécurité</h4>
                        <p class="text-sm text-gray-500 line-clamp-1">Mot de passe et authentification</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4">Assurez-vous que votre compte utilise un long mot de passe sécurisé.</p>
                <div class="flex items-center text-red-600 text-sm font-semibold group-hover:translate-x-1 transition-transform">
                    Modifier le mot de passe 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </div>
            </a>
            @endif

            <!-- Carte Notifications -->
            <div class="group block p-6 bg-white border border-gray-100 rounded-2xl shadow-sm opacity-80 relative cursor-not-allowed">
                <div class="absolute top-4 right-4 bg-gray-100 text-gray-500 text-[10px] uppercase font-bold px-2 py-1 rounded-full">Bientôt</div>
                <div class="flex items-center space-x-4 mb-4 opacity-50">
                    <div class="w-12 h-12 flex flex-shrink-0 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 group-hover:bg-yellow-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Notifications</h4>
                        <p class="text-sm text-gray-500 line-clamp-1">Emails et alertes en direct</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4 opacity-50">Choisissez ce dont vous voulez être notifié par le système.</p>
                <div class="flex items-center text-gray-400 text-sm font-semibold">
                    Non disponible
                </div>
            </div>

            <!-- Carte Langue et Apparence -->
            <div class="group block p-6 bg-white border border-gray-100 rounded-2xl shadow-sm opacity-80 relative cursor-not-allowed">
                <div class="absolute top-4 right-4 bg-gray-100 text-gray-500 text-[10px] uppercase font-bold px-2 py-1 rounded-full">Bientôt</div>
                <div class="flex items-center space-x-4 mb-4 opacity-50">
                    <div class="w-12 h-12 flex flex-shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900">Apparence de l'interface</h4>
                        <p class="text-sm text-gray-500 line-clamp-1">Mode sombre, thème et langue</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-4 opacity-50">Personnalisez l'esthétique et la langue du portail scolaire.</p>
                <div class="flex items-center text-gray-400 text-sm font-semibold">
                    Non disponible
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
