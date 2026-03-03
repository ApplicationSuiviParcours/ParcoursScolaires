{{-- resources/views/auth/verify-email.blade.php --}}
<x-guest-layout>
    <!-- Header avec design moderne -->
    <div class="text-center mb-8">
        <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-yellow-500 to-orange-600 mb-5 shadow-xl shadow-yellow-200 transform hover:scale-105 transition-transform duration-300">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
            </svg>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
        </div>
        
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Vérifiez votre email</h2>
        <p class="text-sm text-gray-500">Activez votre compte pour commencer</p>
        
        <!-- Badge de statut -->
        <div class="inline-flex items-center px-3 py-1 mt-3 bg-yellow-50 rounded-full">
            <svg class="w-3 h-3 text-yellow-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span class="text-xs font-medium text-yellow-700">En attente de vérification</span>
        </div>
    </div>

    <!-- Message principal -->
    <div class="mb-6 p-5 bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-500 rounded-r-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700 leading-relaxed">
                    {{ __('Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Message de succès -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg animate-slideDown">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">
                        {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse email que vous avez fournie lors de l\'inscription.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Conseils et astuces -->
    <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
        <h4 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
            <svg class="w-4 h-4 mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Vous n'avez pas reçu l'email ?
        </h4>
        <ul class="text-xs text-gray-500 space-y-2 list-disc list-inside ml-5">
            <li>Vérifiez votre dossier de courriers indésirables ou spam</li>
            <li>Assurez-vous d'avoir saisi la bonne adresse email</li>
            <li>Attendez quelques minutes, l'email peut prendre du temps à arriver</li>
            <li>Si le problème persiste, cliquez sur le bouton ci-dessous pour renvoyer l'email</li>
        </ul>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 focus:outline-none focus:ring-4 focus:ring-yellow-200 transition-all duration-200 transform hover:scale-[1.02] group">
                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('Renvoyer l\'email de vérification') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                @csrf
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-100 transition-all duration-200 group">
                    <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Support -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-400">
            Besoin d'aide ? 
            <a href="#" class="text-yellow-600 hover:text-yellow-800 font-medium hover:underline">
                Contactez le support
            </a>
        </p>
    </div>

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
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
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
        
        .group:hover .group-hover\:rotate-12 {
            transform: rotate(12deg);
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

    <!-- Script pour rafraîchissement automatique (optionnel) -->
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Compter le nombre de renvois pour éviter les abus (optionnel)
            let resendCount = 0;
            const resendButton = document.querySelector('button[type="submit"][formaction*="verification.send"]');
            
            if (resendButton) {
                resendButton.addEventListener('click', function() {
                    resendCount++;
                    
                    // Désactiver temporairement le bouton après 3 essais
                    if (resendCount >= 3) {
                        this.disabled = true;
                        this.classList.add('opacity-50', 'cursor-not-allowed');
                        
                        // Créer un message d'avertissement
                        const warningDiv = document.createElement('div');
                        warningDiv.className = 'mt-3 p-2 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-xs text-red-700';
                        warningDiv.innerHTML = 'Trop de tentatives. Veuillez patienter 5 minutes avant de réessayer.';
                        
                        this.closest('form').after(warningDiv);
                        
                        // Réactiver après 5 minutes
                        setTimeout(() => {
                            this.disabled = false;
                            this.classList.remove('opacity-50', 'cursor-not-allowed');
                            warningDiv.remove();
                            resendCount = 0;
                        }, 300000); // 5 minutes
                    }
                });
            }
        });
    </script>
    @endpush
</x-guest-layout>