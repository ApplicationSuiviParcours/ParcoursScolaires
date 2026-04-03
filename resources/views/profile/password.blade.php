@extends('layouts.app')

@section('title', 'Changer mon mot de passe')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-4 sm:py-6 md:py-8 overflow-x-hidden">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête - Responsive -->
        <div class="mb-4 sm:mb-5 md:mb-6">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800">Changer mon mot de passe</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Modifiez votre mot de passe pour sécuriser votre compte</p>
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

        <!-- Formulaire de changement de mot de passe - Responsive -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('profile.password.update') }}" class="p-4 sm:p-5 md:p-6">
                @csrf
                @method('PUT')

                <div class="space-y-4 sm:space-y-5 md:space-y-6">
                    <!-- Mot de passe actuel -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Mot de passe actuel <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('current_password') border-red-500 @enderror text-sm sm:text-base"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="new_password"
                               id="new_password"
                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('new_password') border-red-500 @enderror text-sm sm:text-base"
                               required>
                        @error('new_password')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Indicateur de force du mot de passe - Responsive -->
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-1.5 sm:h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div id="passwordStrength" class="h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <span id="passwordStrengthText" class="text-[10px] sm:text-xs text-gray-600 font-medium">Faible</span>
                            </div>
                            <p class="text-[10px] sm:text-xs text-gray-500 mt-1 leading-relaxed">
                                Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                            </p>
                        </div>
                    </div>

                    <!-- Confirmation du nouveau mot de passe -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">
                            Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="new_password_confirmation"
                               id="new_password_confirmation"
                               class="w-full px-3 sm:px-4 py-1.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm sm:text-base"
                               required>
                    </div>

                    <!-- Boutons d'action - Responsive -->
                    <div class="flex flex-col-reverse sm:flex-row items-center justify-end space-y-2 space-y-reverse sm:space-y-0 sm:space-x-3 md:space-x-4 pt-4 sm:pt-5 md:pt-6 border-t">
                        <a href="{{ route('profile.show') }}"
                           class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-1.5 sm:py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 text-center text-sm sm:text-base">
                            Annuler
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto px-4 sm:px-5 md:px-6 py-1.5 sm:py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200 text-sm sm:text-base">
                            Changer le mot de passe
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Conseils de sécurité - Responsive -->
        <div class="mt-4 sm:mt-5 md:mt-6 grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
            <!-- Bonnes pratiques -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 sm:p-4">
                <h3 class="font-medium text-green-800 mb-2 text-sm sm:text-base">✅ Bonnes pratiques</h3>
                <ul class="text-xs sm:text-sm text-green-700 space-y-1 list-disc list-inside">
                    <li>Utilisez un mot de passe unique</li>
                    <li>Mélangez lettres, chiffres et symboles</li>
                    <li>Changez votre mot de passe régulièrement</li>
                </ul>
            </div>

            <!-- À éviter -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-3 sm:p-4">
                <h3 class="font-medium text-red-800 mb-2 text-sm sm:text-base">❌ À éviter</h3>
                <ul class="text-xs sm:text-sm text-red-700 space-y-1 list-disc list-inside">
                    <li>N'utilisez pas d'informations personnelles</li>
                    <li>Évitez les mots de passe trop simples</li>
                    <li>Ne réutilisez pas d'anciens mots de passe</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const passwordInput = document.getElementById('new_password');
    const strengthBar = document.getElementById('passwordStrength');
    const strengthText = document.getElementById('passwordStrengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let color = '#ef4444'; // Rouge par défaut

        // Vérifications
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]+/)) strength += 25;
        if (password.match(/[A-Z]+/)) strength += 25;
        if (password.match(/[0-9]+/)) strength += 25;

        // Couleur en fonction de la force
        if (strength <= 25) {
            color = '#ef4444'; // Rouge
            strengthText.textContent = 'Faible';
        } else if (strength <= 50) {
            color = '#f59e0b'; // Orange
            strengthText.textContent = 'Moyen';
        } else if (strength <= 75) {
            color = '#3b82f6'; // Bleu
            strengthText.textContent = 'Bon';
        } else {
            color = '#10b981'; // Vert
            strengthText.textContent = 'Fort';
        }

        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
    });
</script>
@endpush

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
    
    /* Transition fluide pour la barre de force */
    #passwordStrength {
        transition: width 0.3s ease, background-color 0.3s ease;
    }
    
    /* Ajustement pour les très petits écrans */
    @media (max-width: 480px) {
        .container {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
        }
        
        /* Ajuster les tailles de police sur mobile */
        .text-sm {
            font-size: 0.75rem;
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
        
        /* Ajuster les listes */
        .list-inside {
            padding-left: 0.5rem;
        }
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
        
        /* Ajuster les titres */
        h1 {
            line-height: 1.3;
        }
    }
</style>
@endpush
@endsection