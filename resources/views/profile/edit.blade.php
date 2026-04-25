@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="min-h-screen py-10 bg-gradient-to-br from-indigo-50 via-white to-purple-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- En-tête -->
        <div class="mb-8 relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center">
                <span class="px-4 bg-transparent backdrop-blur-sm text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                    Paramètres de profil
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm mb-8 flex items-center animate-pulse-once">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm mb-8 flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Il y a eu des erreurs lors de la soumission :</h3>
                    <ul class="mt-1 list-disc list-inside text-sm text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/60 overflow-hidden">
            <!-- Header du formulaire -->
            <div class="px-8 py-8 border-b border-gray-100 bg-gradient-to-br from-indigo-600 to-purple-700 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-purple-400 opacity-20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-center space-x-5">
                    <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center p-1 border border-white/30 shadow-inner">
                        @if($user->photo_url ?? null)
                            <img src="{{ $user->photo_url }}" alt="Profile" class="h-14 w-14 rounded-full object-cover shadow-sm">
                        @else
                            <div class="h-14 w-14 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-xl">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-black tracking-tight">{{ $user->name }}</h2>
                        <p class="text-indigo-100 text-sm font-medium mt-1 opacity-90"><svg class="inline w-4 h-4 mr-1 pb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Body du formulaire -->
            <form method="POST" action="{{ route('profile.update') }}" class="p-8 sm:p-10 space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Nom -->
                    <div class="space-y-2 relative group">
                        <label for="name" class="text-sm font-bold text-gray-700 tracking-wide flex items-center">
                            <span class="bg-indigo-100 text-indigo-600 rounded-full p-1.5 mr-2 group-hover:scale-110 transition-transform"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></span>
                            Nom complet <span class="text-rose-500 ml-1">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Votre nom"
                               class="w-full px-5 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition-all shadow-sm group-hover:border-indigo-200"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2 relative group">
                        <label for="email" class="text-sm font-bold text-gray-700 tracking-wide flex items-center">
                            <span class="bg-purple-100 text-purple-600 rounded-full p-1.5 mr-2 group-hover:scale-110 transition-transform"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></span>
                            Adresse email <span class="text-rose-500 ml-1">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email) }}"
                               placeholder="vous@exemple.com"
                               class="w-full px-5 py-3.5 bg-gray-50/50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition-all shadow-sm group-hover:border-purple-200"
                               required>
                        
                        @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <div class="absolute -bottom-6 left-0 text-xs text-amber-600 flex items-center font-medium">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                Votre email n'est pas vérifié. 
                                <a href="{{ route('verification.notice') }}" class="ml-1 text-purple-600 hover:text-purple-800 underline font-bold transition-colors">Renvoyer le lien</a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center text-sm text-gray-500 bg-gray-50 py-2.5 px-4 rounded-xl border border-gray-100">
                        <svg class="w-5 h-5 text-indigo-400 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>La modification de l'email nécessitera une <strong class="text-gray-700">nouvelle vérification</strong>.</span>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('profile.show') }}" class="w-full justify-center sm:w-auto inline-flex items-center px-6 py-3 border-2 border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 hover:border-gray-300 hover:text-gray-900 transition-all focus:ring-4 focus:ring-gray-100">
                            Annuler
                        </a>
                        <button type="submit" class="w-full justify-center sm:w-auto inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-[1.02] transform transition-all focus:ring-4 focus:ring-indigo-200">
                            Sauvegarder
                        </button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection