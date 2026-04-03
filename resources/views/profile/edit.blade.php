@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-4 sm:py-6 md:py-8 overflow-x-hidden">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête - Responsive -->
        <div class="mb-4 sm:mb-5 md:mb-6">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Modifier mon profil</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Mettez à jour vos informations personnelles</p>
        </div>

        <!-- Messages de notification - Responsive -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-3 sm:mb-4 shadow-sm" role="alert">
                <p class="text-sm sm:text-base">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-3 sm:mb-4 shadow-sm" role="alert">
                <ul class="list-disc list-inside text-sm sm:text-base">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire d'édition - Responsive -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('profile.update') }}" class="p-4 sm:p-5 md:p-6">
                @csrf
                @method('PATCH')

                <div class="space-y-4 sm:space-y-5 md:space-y-6">
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror text-sm sm:text-base"
                               required>
                        @error('name')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Adresse email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror text-sm sm:text-base"
                               required>
                        @error('email')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                            <p class="mt-2 text-xs sm:text-sm text-yellow-600">
                                Votre email n'est pas vérifié.
                                <a href="{{ route('verification.notice') }}" class="text-purple-600 hover:text-purple-700 underline">
                                    Renvoyer l'email de vérification
                                </a>
                            </p>
                        @endif
                    </div>

                    <!-- Boutons d'action - Responsive -->
                    <div class="flex flex-col-reverse sm:flex-row items-center justify-end space-y-2 space-y-reverse sm:space-y-0 sm:space-x-3 md:space-x-4 pt-4 sm:pt-5 md:pt-6 border-t">
                        <a href="{{ route('profile.show') }}"
                           class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-1.5 sm:py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 text-center text-sm sm:text-base">
                            Annuler
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-1.5 sm:py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200 text-sm sm:text-base">
                            Mettre à jour
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Informations supplémentaires - Responsive -->
        <div class="mt-4 sm:mt-5 md:mt-6 bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
            <div class="flex items-start">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs sm:text-sm text-blue-700 leading-relaxed">
                    <span class="font-medium">Note :</span> Si vous modifiez votre adresse email, vous devrez la vérifier à nouveau.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Styles pour éviter le débordement horizontal */
    * {
        max-width: 100%;
        box-sizing: border-box;
    }
    
    body, html {
        overflow-x: hidden;
        width: 100%;
        position: relative;
    }
    
    .container {
        overflow-x: hidden;
    }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        /* Ajuster les tailles de police sur mobile */
        .text-sm {
            font-size: 0.8rem;
        }
        
        /* Réduire les paddings */
        .px-4 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .py-8 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    }
    
    /* Transition fluide pour les inputs */
    input, button, a {
        transition: all 0.2s ease;
    }
    
    /* Effet de focus amélioré */
    input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
    }
    
    /* Amélioration de la lisibilité sur mobile */
    @media (max-width: 640px) {
        .max-w-3xl {
            width: 100%;
        }
        
        .space-y-6 {
            margin-top: 1rem;
        }
    }
</style>
@endpush