@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4 bg-slate-50">
        <div class="max-w-md w-full">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Bon retour</h1>
                <p class="text-slate-500">Connectez-vous pour gérer vos études</p>
            </div>

            <div class="premium-card p-8 rounded-2xl" x-data="{
                        showResetModal: false,
                        resetEmail: '',
                        resetLoading: false,
                        resetMessage: '',
                        resetError: '',
                        loginEmail: '',
                        loginPassword: '',
                        loginLoading: false,
                        loginError: '',

                        handleManualLogin() {
                            this.loginLoading = true;
                            this.loginError = '';

                            firebase.auth().signInWithEmailAndPassword(this.loginEmail, this.loginPassword)
                                .then((userCredential) => {
                                    const user = userCredential.user;
                                    // Envoyer les infos au backend pour créer la session Laravel
                                    this.syncWithLaravel(user);
                                })
                                .catch((error) => {
                                    console.error(error);
                                    this.loginLoading = false;
                                    this.loginError = 'Email ou mot de passe incorrect (Firebase).';
                                });
                        },

                        syncWithLaravel(firebaseUser) {
                            fetch('/auth/google', { // On réutilise la même route de synchro
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    userData: {
                                        email: firebaseUser.email,
                                        nom: firebaseUser.displayName || firebaseUser.email.split('@')[0],
                                        google_id: firebaseUser.uid,
                                        photo: firebaseUser.photoURL
                                    }
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if(data.success) {
                                    window.location.href = data.redirect;
                                }
                            });
                        },

                        doFirebaseReset() {
                            if (!this.resetEmail) {
                                alert('Veuillez entrer votre email.');
                                return;
                            }
                            this.resetLoading = true;
                            this.resetError = '';
                            this.resetMessage = '';

                            firebase.auth().sendPasswordResetEmail(this.resetEmail)
                                .then(() => {
                                    this.resetMessage = 'Lien envoyé ! Vérifiez votre boîte mail.';
                                    this.resetLoading = false;
                                })
                                .catch((error) => {
                                    console.error(error);
                                    this.resetError = 'Erreur: ' + error.message;
                                    this.resetLoading = false;
                                });
                        }
                    }">
                <form @submit.prevent="handleManualLogin" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" x-model="loginEmail" required class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="nom@exemple.com">
                        <template x-if="loginError">
                            <p class="text-red-500 text-xs mt-1" x-text="loginError"></p>
                        </template>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-semibold text-slate-700">Mot de passe</label>
                            <a href="#" @click.prevent="showResetModal = true"
                                class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">Mot de passe
                                oublié ?</a>
                        </div>
                        <input type="password" x-model="loginPassword" required
                            class="w-full input-premium px-4 py-3 rounded-xl" placeholder="••••••••">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label class="ml-2 block text-sm text-slate-600">Se souvenir de moi</label>
                    </div>

                    <button type="submit" :disabled="loginLoading"
                        class="w-full btn-brand text-white font-bold py-3 px-4 rounded-xl transition duration-200 disabled:opacity-50">
                        <span x-show="!loginLoading">Se connecter</span>
                        <span x-show="loginLoading">Vérification...</span>
                    </button>

                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center">
                            <span class="w-full border-t border-slate-200"></span>
                        </div>
                        <div class="relative flex justify-center text-xs uppercase">
                            <span class="bg-white px-2 text-slate-400">Ou continuer avec</span>
                        </div>
                    </div>

                    <button type="button" id="google-login-btn"
                        class="w-full flex items-center justify-center gap-3 bg-white border border-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl hover:bg-slate-50 transition duration-200">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-5 h-5"
                            alt="Google">
                        Google
                    </button>
                </form>

                <!-- Forgot Password Modal -->
                <div x-show="showResetModal"
                    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                    <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl" @click.away="showResetModal = false">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Réinitialiser le mot de passe</h3>
                        <p class="text-slate-500 text-sm mb-6">Entrez votre email pour recevoir un lien de réinitialisation
                            via Firebase.</p>

                        <div class="space-y-4">
                            <input type="email" x-model="resetEmail" class="w-full input-premium px-4 py-3 rounded-xl"
                                placeholder="votre@email.com">

                            <div x-show="resetMessage" class="text-green-600 text-sm font-medium" x-text="resetMessage">
                            </div>
                            <div x-show="resetError" class="text-red-500 text-sm font-medium" x-text="resetError"></div>

                            <div class="flex gap-3 pt-2">
                                <button @click="showResetModal = false"
                                    class="flex-1 px-4 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition">
                                    Annuler
                                </button>
                                <button @click="doFirebaseReset()" :disabled="resetLoading"
                                    class="flex-1 px-4 py-3 rounded-xl btn-brand text-white font-bold disabled:opacity-50">
                                    <span x-show="!resetLoading">Envoyer</span>
                                    <span x-show="resetLoading">Envoi...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mt-8 text-center text-sm text-slate-500">
                    Pas encore de compte ?
                    <a href="{{ route('signup') }}" class="font-bold text-indigo-600 hover:text-indigo-700">S'inscrire</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Firebase Scripts -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
    <script>
        // Config Firebase (User will need to fill this or I use a placeholder)
        const firebaseConfig = {
            apiKey: "AIzaSyAY1cgHEVRYDXvnjMgGI__Riq00yk-FRGQ",
            authDomain: "gestion-578e6.firebaseapp.com",
            projectId: "gestion-578e6",
            storageBucket: "gestion-578e6.firebasestorage.app",
            messagingSenderId: "335984300936",
            appId: "1:335984300936:web:610a3a0e8b60cb5ad3a03d",
            measurementId: "G-8T5M70KZPH"
        };

        firebase.initializeApp(firebaseConfig);

        document.getElementById('google-login-btn').addEventListener('click', () => {
            const provider = new firebase.auth.GoogleAuthProvider();
            firebase.auth().signInWithPopup(provider).then((result) => {
                const user = result.user;
                // Send user data to Laravel backend
                fetch('/auth/google', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        userData: {
                            email: user.email,
                            nom: user.displayName,
                            google_id: user.uid,
                            photo: user.photoURL
                        }
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.redirect;
                        }
                    });
            }).catch((error) => {
                console.error(error);
                alert("Erreur de connexion Google: " + error.message);
            });
        });
    </script>
@endsection