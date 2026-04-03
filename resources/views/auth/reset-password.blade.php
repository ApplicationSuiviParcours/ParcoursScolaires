<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <div class="inline-flex items-center justify-center w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg mb-5">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900">Réinitialiser le mot de passe</h2>
        <p class="mt-2 text-sm text-gray-500">Créez un nouveau mot de passe sécurisé pour votre compte</p>
    </div>

    <!-- Info box -->
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-xl flex items-start gap-3">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-emerald-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h4 class="font-semibold text-emerald-900 text-sm">Conseil de sécurité</h4>
            <p class="text-xs text-emerald-700 mt-0.5">Utilisez au moins 12 caractères, incluant majuscules, chiffres et symboles pour une sécurité optimale.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Adresse email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required readonly
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-600 text-sm focus:outline-none cursor-not-allowed">
            </div>
        </div>

        <!-- New Password -->
        <div x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Nouveau mot de passe</label>
            <div class="relative">
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       x-bind:type="show ? 'text' : 'password'"
                       class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 focus:ring-1 transition shadow-sm"
                       placeholder="Entrez votre mot de passe">
                
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>

                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <!-- Strength Meter -->
            <div class="mt-3">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-medium text-gray-500">Force du mot de passe</span>
                    <span id="strengthLabel" class="text-xs font-bold text-gray-400">—</span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div id="strengthMeter" class="h-full rounded-full transition-all duration-300 ease-out" style="width: 0%"></div>
                </div>
                <div id="criteriaGrid" class="grid grid-cols-2 sm:grid-cols-4 gap-2 mt-3">
                    <div class="flex items-center gap-1.5" data-criteria="length">
                        <span class="criteria-dot w-2 h-2 rounded-full bg-gray-300 transition-colors"></span>
                        <span class="text-xs text-gray-500">12+ chars</span>
                    </div>
                    <div class="flex items-center gap-1.5" data-criteria="uppercase">
                        <span class="criteria-dot w-2 h-2 rounded-full bg-gray-300 transition-colors"></span>
                        <span class="text-xs text-gray-500">Majuscule</span>
                    </div>
                    <div class="flex items-center gap-1.5" data-criteria="number">
                        <span class="criteria-dot w-2 h-2 rounded-full bg-gray-300 transition-colors"></span>
                        <span class="text-xs text-gray-500">Chiffre</span>
                    </div>
                    <div class="flex items-center gap-1.5" data-criteria="special">
                        <span class="criteria-dot w-2 h-2 rounded-full bg-gray-300 transition-colors"></span>
                        <span class="text-xs text-gray-500">Symbole</span>
                    </div>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ show: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmer le mot de passe</label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                       x-bind:type="show ? 'text' : 'password'"
                       class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 focus:ring-1 transition shadow-sm"
                       placeholder="Répétez le mot de passe">

                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <div id="matchIndicator" class="text-xs mt-2 h-4"></div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Actions -->
        <div class="pt-2 space-y-3">
            <button type="submit" 
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition duration-150 ease-in-out flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <span>Mettre à jour le mot de passe</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </button>

            <a href="{{ route('login') }}" class="block text-center w-full text-sm text-gray-600 hover:text-gray-900 py-2 transition">
                <span class="flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la connexion
                </span>
            </a>
        </div>
    </form>

    @push('scripts')
        <script>
            // === PASSWORD STRENGTH LOGIC ===
            const passwordInput = document.getElementById('password');
            const strengthMeter = document.getElementById('strengthMeter');
            const strengthLabel = document.getElementById('strengthLabel');
            const criteriaItems = document.querySelectorAll('[data-criteria]');

            passwordInput.addEventListener('input', () => {
                const val = passwordInput.value;
                let score = 0;

                const checks = {
                    length: val.length >= 12,
                    uppercase: /[A-Z]/.test(val),
                    number: /[0-9]/.test(val),
                    special: /[^A-Za-z0-9]/.test(val) // Symbole
                };

                // Update UI criteria dots
                criteriaItems.forEach(item => {
                    const type = item.getAttribute('data-criteria');
                    const dot = item.querySelector('.criteria-dot');
                    if (checks[type]) {
                        score++;
                        dot.classList.remove('bg-gray-300');
                        dot.classList.add('bg-emerald-500');
                    } else {
                        dot.classList.add('bg-gray-300');
                        dot.classList.remove('bg-emerald-500');
                    }
                });

                // Update Meter Bar
                // Max score is 4
                const percent = (score / 4) * 100;
                strengthMeter.style.width = percent + '%';

                if (val.length === 0) {
                    strengthLabel.textContent = '—';
                    strengthLabel.className = 'text-xs font-bold text-gray-400';
                    strengthMeter.style.width = '0%';
                } else if (score <= 1) {
                    strengthMeter.className = 'h-full rounded-full transition-all duration-300 bg-red-500';
                    strengthLabel.textContent = 'Faible';
                    strengthLabel.className = 'text-xs font-bold text-red-500';
                } else if (score <= 2) {
                    strengthMeter.className = 'h-full rounded-full transition-all duration-300 bg-orange-400';
                    strengthLabel.textContent = 'Moyen';
                    strengthLabel.className = 'text-xs font-bold text-orange-500';
                } else if (score <= 3) {
                    strengthMeter.className = 'h-full rounded-full transition-all duration-300 bg-emerald-400';
                    strengthLabel.textContent = 'Bon';
                    strengthLabel.className = 'text-xs font-bold text-emerald-600';
                } else {
                    strengthMeter.className = 'h-full rounded-full transition-all duration-300 bg-emerald-600';
                    strengthLabel.textContent = 'Excellent';
                    strengthLabel.className = 'text-xs font-bold text-emerald-700';
                }
            });

            // === PASSWORD MATCH LOGIC ===
            const confirmInput = document.getElementById('password_confirmation');
            const matchIndicator = document.getElementById('matchIndicator');

            confirmInput.addEventListener('input', () => {
                const val1 = passwordInput.value;
                const val2 = confirmInput.value;

                if (val2.length === 0) {
                    matchIndicator.innerHTML = '';
                    return;
                }

                if (val1 === val2) {
                    matchIndicator.innerHTML = '<span class="flex items-center gap-1 text-emerald-600"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Les mots de passe correspondent</span>';
                } else {
                    matchIndicator.innerHTML = '<span class="flex items-center gap-1 text-red-500"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg> Ne correspondent pas</span>';
                }
            });
        </script>
    @endpush
</x-guest-layout>