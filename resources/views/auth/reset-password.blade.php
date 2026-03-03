{{-- resources/views/auth/reset-password.blade.php --}}
<x-guest-layout>
    <!-- Header avec design moderne -->
    <div class="text-center mb-8">
        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-600 to-pink-600 mb-5 shadow-xl shadow-purple-200 transform hover:scale-105 transition-transform duration-300">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
        </div>
        
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Nouveau mot de passe</h2>
        <p class="text-sm text-gray-500">Choisissez un mot de passe sécurisé</p>
        
        <!-- Badge de sécurité -->
        <div class="inline-flex items-center px-3 py-1 mt-3 bg-purple-50 rounded-full">
            <svg class="w-3 h-3 text-purple-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <span class="text-xs font-medium text-purple-700">Réinitialisation sécurisée</span>
        </div>
    </div>

    <!-- Message d'information -->
    <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 border-l-4 border-purple-500 rounded-r-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-purple-700 leading-relaxed">
                    Veuillez choisir un nouveau mot de passe sécurisé pour votre compte.
                </p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="space-y-1">
            <label for="email" class="block text-sm font-semibold text-gray-700">
                Adresse email <span class="text-red-500">*</span>
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" 
                       type="email" 
                       name="email" 
                       value="{{ old('email', $request->email) }}" 
                       required 
                       readonly
                       class="pl-10 w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-600 cursor-not-allowed @error('email') border-red-400 bg-red-50 @enderror" 
                       placeholder="vous@exemple.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                Nouveau mot de passe <span class="text-red-500">*</span>
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password" 
                       type="password" 
                       name="password" 
                       required 
                       autocomplete="new-password" 
                       class="pl-10 w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 @error('password') border-red-400 bg-red-50 @enderror" 
                       placeholder="••••••••">
                
                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg id="eyeIcon-password" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Force du mot de passe -->
            <div class="mt-2">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs text-gray-500">Force du mot de passe</span>
                    <span id="passwordStrength" class="text-xs font-medium text-gray-500">Faible</span>
                </div>
                <div class="h-1.5 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div id="passwordStrengthBar" class="h-full w-0 bg-red-500 rounded-full transition-all duration-300"></div>
                </div>
                <ul id="passwordRequirements" class="mt-2 text-xs text-gray-500 space-y-1">
                    <li id="length" class="flex items-center">
                        <span class="mr-1">•</span> Au moins 8 caractères
                    </li>
                    <li id="uppercase" class="flex items-center">
                        <span class="mr-1">•</span> Au moins une majuscule
                    </li>
                    <li id="lowercase" class="flex items-center">
                        <span class="mr-1">•</span> Au moins une minuscule
                    </li>
                    <li id="number" class="flex items-center">
                        <span class="mr-1">•</span> Au moins un chiffre
                    </li>
                </ul>
            </div>
            
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                Confirmer le mot de passe <span class="text-red-500">*</span>
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <input id="password_confirmation" 
                       type="password" 
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password" 
                       class="pl-10 w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all duration-200 @error('password_confirmation') border-red-400 bg-red-50 @enderror" 
                       placeholder="••••••••">
                
                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg id="eyeIcon-password_confirmation" class="h-5 w-5 text-gray-400 hover:text-gray-600 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Indicateur de correspondance -->
            <div id="passwordMatch" class="text-xs mt-1 hidden">
                <span class="text-green-600">✓ Les mots de passe correspondent</span>
            </div>
            
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Conseils de sécurité -->
        <div class="flex items-center space-x-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
            <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Ce lien de réinitialisation expirera après 60 minutes</span>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-4">
            <a href="{{ route('login') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 group">
                <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Annuler
            </a>
            
            <button type="submit" 
                    class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 focus:outline-none focus:ring-4 focus:ring-purple-200 transition-all duration-200 transform hover:scale-[1.02] group">
                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Réinitialiser le mot de passe
            </button>
        </div>
    </form>

    <!-- Aide supplémentaire -->
    <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h4 class="text-sm font-semibold text-gray-700 mb-1">Conseils de sécurité</h4>
                <ul class="text-xs text-gray-500 space-y-1 list-disc list-inside">
                    <li>Utilisez un mot de passe unique que vous n'utilisez pas ailleurs</li>
                    <li>Mélangez lettres majuscules, minuscules et chiffres</li>
                    <li>Évitez les informations personnelles (date de naissance, prénom, etc.)</li>
                    <li>Plus le mot de passe est long, plus il est sécurisé</li>
                </ul>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(`eyeIcon-${fieldId}`);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                `;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                `;
            }
        }

        // Vérification de la force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrength');
            
            // Vérifier les critères
            const hasLength = password.length >= 8;
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            
            // Mettre à jour les icônes des critères
            document.getElementById('length').innerHTML = `<span class="mr-1 ${hasLength ? 'text-green-600' : 'text-gray-500'}">${hasLength ? '✓' : '•'}</span> Au moins 8 caractères`;
            document.getElementById('uppercase').innerHTML = `<span class="mr-1 ${hasUpperCase ? 'text-green-600' : 'text-gray-500'}">${hasUpperCase ? '✓' : '•'}</span> Au moins une majuscule`;
            document.getElementById('lowercase').innerHTML = `<span class="mr-1 ${hasLowerCase ? 'text-green-600' : 'text-gray-500'}">${hasLowerCase ? '✓' : '•'}</span> Au moins une minuscule`;
            document.getElementById('number').innerHTML = `<span class="mr-1 ${hasNumber ? 'text-green-600' : 'text-gray-500'}">${hasNumber ? '✓' : '•'}</span> Au moins un chiffre`;
            
            // Calculer la force
            const score = [hasLength, hasUpperCase, hasLowerCase, hasNumber].filter(Boolean).length;
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.className = 'h-full bg-gray-500 rounded-full';
                strengthText.textContent = 'Faible';
                strengthText.className = 'text-xs font-medium text-gray-500';
            } else if (score <= 1) {
                strengthBar.style.width = '25%';
                strengthBar.className = 'h-full bg-red-500 rounded-full';
                strengthText.textContent = 'Faible';
                strengthText.className = 'text-xs font-medium text-red-600';
            } else if (score === 2) {
                strengthBar.style.width = '50%';
                strengthBar.className = 'h-full bg-yellow-500 rounded-full';
                strengthText.textContent = 'Moyen';
                strengthText.className = 'text-xs font-medium text-yellow-600';
            } else if (score === 3) {
                strengthBar.style.width = '75%';
                strengthBar.className = 'h-full bg-blue-500 rounded-full';
                strengthText.textContent = 'Bon';
                strengthText.className = 'text-xs font-medium text-blue-600';
            } else {
                strengthBar.style.width = '100%';
                strengthBar.className = 'h-full bg-green-500 rounded-full';
                strengthText.textContent = 'Fort';
                strengthText.className = 'text-xs font-medium text-green-600';
            }
        });

        // Vérifier la correspondance des mots de passe
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirm = this.value;
            const matchIndicator = document.getElementById('passwordMatch');
            
            if (confirm.length > 0) {
                matchIndicator.classList.remove('hidden');
                if (password === confirm) {
                    matchIndicator.innerHTML = '<span class="text-green-600">✓ Les mots de passe correspondent</span>';
                } else {
                    matchIndicator.innerHTML = '<span class="text-red-600">✗ Les mots de passe ne correspondent pas</span>';
                }
            } else {
                matchIndicator.classList.add('hidden');
            }
        });
    </script>
    @endpush

    @push('styles')
    <style>
        /* Animations personnalisées */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-slideDown {
            animation: slideDown 0.3s ease-out;
        }
        
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }
        
        .group:hover .group-hover\:-translate-x-1 {
            transform: translateX(-0.25rem);
        }
        
        .group:hover .group-hover\:scale-110 {
            transform: scale(1.1);
        }
        
        /* Transition pour tous les éléments */
        .transition {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 200ms;
        }
        
        /* Style pour le focus */
        .focus\:ring-4:focus {
            --tw-ring-offset-width: 0px;
        }
        
        /* Style pour les inputs */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px white inset;
            transition: background-color 5000s ease-in-out 0s;
        }
        
        /* Style pour les inputs readonly */
        input[readonly] {
            background-color: #f3f4f6;
            cursor: not-allowed;
        }
        
        /* Animation de pulse */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
    </style>
    @endpush
</x-guest-layout>