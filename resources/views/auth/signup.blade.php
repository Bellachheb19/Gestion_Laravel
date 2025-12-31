@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-12 px-4 bg-slate-50 flex items-center justify-center">
        <div class="max-w-2xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-slate-900 mb-2">Créer un compte</h1>
                <p class="text-slate-500">Rejoignez notre plateforme de gestion aujourd'hui</p>
            </div>

            <div class="premium-card p-8 rounded-3xl">
                <form action="{{ route('signup') }}" method="POST" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nom</label>
                            <input type="text" name="nom" value="{{ old('nom') }}" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Votre nom">
                            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom</label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Votre prénom">
                            @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="nom@exemple.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="06 00 00 00 00">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Apogée</label>
                            <input type="text" name="apogee" value="{{ old('apogee') }}"
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="Numéro Apogée">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Photo de profil</label>
                            <input type="file" name="photo"
                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                            <input type="password" name="password" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="••••••••">
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full input-premium px-4 py-3 rounded-xl" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="md:col-span-2 pt-4">
                        <button type="submit"
                            class="w-full btn-brand text-white font-bold py-3 px-4 rounded-xl transition duration-200">
                            Créer mon compte
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
@endsection