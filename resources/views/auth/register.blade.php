<x-guest-layout>
    <!-- Header Ultra Compact -->
    <div class="mb-3 text-center">
        <div class="inline-flex items-center justify-center w-10 h-10 mb-1 rounded-full shadow bg-gradient-to-br from-green-600 to-emerald-500">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900">Créer un compte</h2>
        <p class="text-[11px] text-gray-500">Rejoignez GEST'PARC</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-2">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-[11px] font-medium text-gray-600 mb-0.5">Nom complet</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                       class="pl-8 w-full px-2.5 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-100 transition-all outline-none @error('name') border-red-400 @enderror"
                       placeholder="Jean Dupont">
            </div>
            <x-input-error :messages="$errors->get('name')" class="text-[10px] mt-px text-red-500" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-[11px] font-medium text-gray-600 mb-0.5">Adresse email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                       class="pl-8 w-full px-2.5 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-100 transition-all outline-none @error('email') border-red-400 @enderror"
                       placeholder="vous@exemple.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="text-[10px] mt-px text-red-500" />
        </div>

        <!-- Role -->
        <div>
            <label for="role" class="block text-[11px] font-medium text-gray-600 mb-0.5">Rôle <span class="text-red-500">*</span></label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4 -16m0 0l5.5 5.5M14 4l5.5 5.5"></path>
                    </svg>
                </div>
                <select id="role" name="role" required class="pl-8 w-full px-2.5 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-100 transition-all outline-none @error('role') border-red-400 @enderror">
                    <option value="">Choisir un rôle</option>
                    <option value="eleve" {{ old('role') == 'eleve' ? 'selected' : '' }} >Élève</option>
                    <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Parent</option>
                    <option value="enseignant" {{ old('role') == 'enseignant' ? 'selected' : '' }}>Enseignant</option>

                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7 -7"></path>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="text-[10px] mt-px text-red-500" />
            <p class="text-[10px] text-gray-500 mt-0.5">Choisissez votre rôle : Élève, Parent ou Enseignant.</p>

        </div>

        <!-- Password -->
        <div x-data="{ showPassword: false }">
            <label for="password" class="block text-[11px] font-medium text-gray-600 mb-0.5">Mot de passe</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                       class="pl-8 pr-8 w-full px-2.5 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-100 transition-all outline-none @error('password') border-red-400 @enderror"
                       placeholder="••••••••">

                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 hover:text-green-600 focus:outline-none">
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showPassword" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>

            <!-- Force du mot de passe (Une seule ligne) -->
            <div class="flex items-center gap-2 mt-1">
                <div class="flex-1 h-1 overflow-hidden bg-gray-200 rounded-full">
                    <div id="passwordStrengthBar" class="w-0 h-full transition-all duration-300 bg-red-500 rounded-full"></div>
                </div>
                <span id="passwordStrength" class="text-[10px] font-bold text-gray-400 w-8 text-right">-</span>
            </div>
            <x-input-error :messages="$errors->get('password')" class="text-[10px] mt-px text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ showConfirmPassword: false }">
            <label for="password_confirmation" class="block text-[11px] font-medium text-gray-600 mb-0.5">Confirmer</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required
                       class="pl-8 pr-8 w-full px-2.5 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:border-green-500 focus:ring-1 focus:ring-green-100 transition-all outline-none"
                       placeholder="••••••••">

                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-2 text-gray-400 hover:text-green-600 focus:outline-none">
                    <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showConfirmPassword" class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>
            <div id="passwordMatch" class="text-[10px] mt-px h-3"></div>
        </div>

        <!-- Terms -->
        <div class="flex items-center mt-1">
            <input id="terms" type="checkbox" name="terms" required
                   class="w-3 h-3 text-green-600 border-gray-300 rounded cursor-pointer bg-gray-50 focus:ring-1 focus:ring-green-300">
            <label for="terms" class="ml-1.5 text-[10px] text-gray-600 cursor-pointer">
                J'accepte les <a href="#" class="font-medium text-green-600 hover:underline">conditions</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold text-white transition-all border border-transparent rounded-lg shadow-sm bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 focus:outline-none">
            <svg class="w-4 h-4 mr-1.5 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Créer mon compte
        </button>

        <!-- Login Link -->
        <div class="pt-2 mt-3 text-center border-t border-gray-100">
            <p class="text-[11px] text-gray-500">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:underline">Se connecter</a>
            </p>
        </div>
    </form>

    @once
        @push('scripts')
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @endpush
    @endonce

    @push('scripts')
    <script>
        // Vérification du mot de passe (Compact)
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('passwordStrength');

            const score = [password.length >= 8, /[A-Z]/.test(password), /[0-9]/.test(password)].filter(Boolean).length;

            if (password.length === 0) {
                strengthBar.style.width = '0%'; strengthBar.className = 'h-full bg-gray-200 rounded-full';
                strengthText.textContent = '-'; strengthText.className = 'text-[10px] font-bold text-gray-400 w-8 text-right';
            } else if (score <= 1) {
                strengthBar.style.width = '33%'; strengthBar.className = 'h-full bg-red-500 rounded-full';
                strengthText.textContent = 'Faible'; strengthText.className = 'text-[10px] font-bold text-red-500 w-8 text-right';
            } else if (score === 2) {
                strengthBar.style.width = '66%'; strengthBar.className = 'h-full bg-yellow-500 rounded-full';
                strengthText.textContent = 'Moyen'; strengthText.className = 'text-[10px] font-bold text-yellow-600 w-8 text-right';
            } else {
                strengthBar.style.width = '100%'; strengthBar.className = 'h-full bg-green-500 rounded-full';
                strengthText.textContent = 'Fort'; strengthText.className = 'text-[10px] font-bold text-green-600 w-8 text-right';
            }
        });

        // Vérification de correspondance
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const matchIndicator = document.getElementById('passwordMatch');

            if (this.value.length > 0) {
                matchIndicator.innerHTML = password === this.value ?
                    '<span class="font-medium text-green-600">✓ Identiques</span>' :
                    '<span class="font-medium text-red-500">✗ Différents</span>';
            } else {
                matchIndicator.innerHTML = '';
            }
        });
    </script>
    @endpush
</x-guest-layout>
