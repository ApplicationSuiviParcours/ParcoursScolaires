@extends('layouts.app')

@section('title', 'Changer mon mot de passe')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- En-tête -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Changer mon mot de passe</h1>
            <p class="text-gray-600">Modifiez votre mot de passe pour sécuriser votre compte</p>
        </div>

        <!-- Messages de notification -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded mb-4 shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded mb-4 shadow-sm" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire de changement de mot de passe -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <form method="POST" action="{{ route('profile.password.update') }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Mot de passe actuel -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe actuel <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="current_password"
                               id="current_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                               required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="new_password"
                               id="new_password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('new_password') border-red-500 @enderror"
                               required>
                        @error('new_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Indicateur de force du mot de passe -->
                        <div class="mt-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex-1 h-2 bg-gray-200 rounded-full">
                                    <div id="passwordStrength" class="h-2 rounded-full" style="width: 0%"></div>
                                </div>
                                <span id="passwordStrengthText" class="text-xs text-gray-600">Faible</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.
                            </p>
                        </div>
                    </div>

                    <!-- Confirmation du nouveau mot de passe -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le nouveau mot de passe <span class="text-red-500">*</span>
                        </label>
                        <input type="password"
                               name="new_password_confirmation"
                               id="new_password_confirmation"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               required>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                        <a href="{{ route('profile.show') }}"
                           class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200">
                            Annuler
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-200">
                            Changer le mot de passe
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Conseils de sécurité -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <h3 class="font-medium text-green-800 mb-2">✅ Bonnes pratiques</h3>
                <ul class="text-sm text-green-700 space-y-1 list-disc list-inside">
                    <li>Utilisez un mot de passe unique</li>
                    <li>Mélangez lettres, chiffres et symboles</li>
                    <li>Changez votre mot de passe régulièrement</li>
                </ul>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="font-medium text-red-800 mb-2">❌ À éviter</h3>
                <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
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
@endsection
