@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-12 px-4 bg-slate-50 flex items-center justify-center" 
        x-data="{
            loading: false,
            error: '',
            nom: '{{ old('nom') }}',
            prenom: '{{ old('prenom') }}',
            email: '{{ old('email') }}',
            phone: '{{ old('phone') }}',
            apogee: '{{ old('apogee') }}',
            password: '',
            password_confirmation: '',

            handleSignup() {
                if (this.password !== this.password_confirmation) {
                    this.error = 'Les mots de passe ne correspondent pas.';
                    return;
                }
                this.loading = true;
                this.error = '';

                firebase.auth().createUserWithEmailAndPassword(this.email, this.password)
                    .then((userCredential) => {
                        this.submitToLaravel(userCredential.user.uid);
                    })
                    .catch((error) => {
                        console.error(error);
                        this.loading = false;
                        this.error = 'Erreur Firebase: ' + error.message;
                    });
            },

            submitToLaravel(firebaseUid) {
                const formData = new FormData(document.getElementById('signup-form'));
                formData.append('google_id', firebaseUid);

                fetch('{{ route('signup') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(async response => {
                    const data = await response.json();
                    if (response.ok) {
                        window.location.href = data.redirect || '/student/profile';
                    } else {
                        this.loading = false;
                        this.error = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Erreur serveur');
                    }
                })
                .catch(err => {
                    console.error(err);
                    this.loading = false;
                    this.error = 'Erreur de communication avec le serveur.';
                });
            }
        }">
        <div class="max-w-2xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Créer un compte</h1>
                <p class="text-slate-500">Rejoignez notre plateforme de gestion aujourd'hui</p>
            </div>

            <div class="premium-card p-8 rounded-3xl">
                <template x-if="error">
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-sm font-medium">
                        <i class="fas fa-exclamation-circle mr-2"></i> <span x-text="error"></span>
                    </div>
                </template>

                <form id="signup-form" @submit.prevent="handleSignup" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nom</label>
                            <input type="text" name="nom" x-model="nom" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Votre nom">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" x-model="prenom" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Votre prénom">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" x-model="email" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="nom@exemple.com">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                            <input type="text" name="phone" x-model="phone"
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="06 00 00 00 00">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Apogée</label>
                            <input type="text" name="apogee" x-model="apogee"
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Numéro Apogée">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Photo de profil</label>
                            <input type="file" name="photo"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                            <input type="password" name="password" x-model="password" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="••••••••">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" x-model="password_confirmation" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button type="submit" :disabled="loading"
                            class="w-full btn-brand text-white font-bold py-3 px-4 rounded-xl transition duration-200 disabled:opacity-50 flex items-center justify-center gap-2">
                            <span x-show="loading" class="animate-spin text-lg"><i class="fas fa-circle-notch"></i></span>
                            <span x-text="loading ? 'Création en cours...' : 'Créer mon compte'"></span>
                        </button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-slate-500">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700">Se connecter</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Firebase Scripts -->
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
    <script>
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
    </script>
@endsection