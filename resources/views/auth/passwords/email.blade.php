@extends('layouts.app')

@section('content')
    <!-- Container plein écran avec fond gris léger pour centrer la carte -->
    <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="w-full max-w-md space-y-8">
            
            <!-- Carte moderne : fond blanc, ombre portée, coins arrondis -->
            <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">

                <!-- En-tête -->
                <div class="pt-8 text-center">
                    <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                        {{ __('Réinitialisation du mot de passe') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 px-6">
                        {{ __('Entrez votre adresse e-mail et nous vous enverrons un lien.') }}
                    </p>
                </div>

                <!-- Corps du formulaire -->
                <div class="px-8 py-8">
                    
                    @if (session('status'))
                        <!-- Alerte succès style Tailwind -->
                        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded-md flex justify-between items-start" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                        @csrf

                        <!-- Champ Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-2">
                                {{ __('Adresse Email') }}
                            </label>

                            <!-- Wrapper relatif pour positionner l'icône DANS l'input -->
                            <div class="relative">
                                <!-- Icône positionnée à gauche -->
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>

                                <!-- Input : padding-left ajouté pour ne pas écrire sur l'icône -->
                                <input id="email" type="email" 
                                    class="w-full pl-10 pr-4 py-3 border @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-blue-500 focus:border-blue-500 @enderror rounded-lg bg-gray-50 focus:bg-white transition duration-200 outline-none"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                    placeholder="nom@exemple.com">
                            </div>

                            @error('email')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Bouton d'action -->
                        <div>
                            <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 ease-in-out transform hover:-translate-y-0.5">
                                {{ __('Envoyer le lien de réinitialisation') }}
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Pied de page -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                    <a class="text-sm text-gray-600 hover:text-blue-600 font-medium transition duration-200" href="{{ route('login') }}">
                        <span class="flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('Retour à la connexion') }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection