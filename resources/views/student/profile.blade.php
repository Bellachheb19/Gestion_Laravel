@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-slate-50 p-8" x-data="{ editing: false }">
        <div class="max-w-4xl mx-auto">
            <header class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                    <i class="fas fa-user-circle text-indigo-600"></i>
                    Mon Profil Étudiant
                </h1>
                <div class="flex gap-4">
                    <button @click="editing = !editing"
                        class="px-4 py-2 bg-white border border-slate-200 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                        <i :class="editing ? 'fas fa-times mr-2' : 'fas fa-edit mr-2'"></i>
                        <span x-text="editing ? 'Annuler' : 'Modifier le profil'"></span>
                    </button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-red-500 hover:text-red-600 font-semibold px-4 py-2 hover:bg-red-50 rounded-xl transition">
                            <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </header>

            @if(session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-2xl mb-8 flex items-center gap-3">
                    <i class="fas fa-check-circle text-lg"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="premium-card rounded-3xl overflow-hidden shadow-xl bg-white">
                <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-500"></div>

                <div class="p-8 -mt-16 sm:flex items-end gap-6 text-center sm:text-left">
                    <div class="relative inline-block">
                        @if(Auth::user()->photo)
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}"
                                class="w-32 h-32 rounded-2xl border-4 border-white shadow-lg object-cover mx-auto"
                                alt="Profile">
                        @else
                            <div
                                class="w-32 h-32 rounded-2xl border-4 border-white shadow-lg bg-slate-200 flex items-center justify-center mx-auto text-slate-400">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 mt-4 sm:mt-0 pb-2">
                        <h2 class="text-3xl font-bold text-slate-900">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}
                        </h2>
                        <div class="flex items-center justify-center sm:justify-start gap-2 mt-1">
                            <span
                                class="bg-indigo-50 text-indigo-700 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">Apogée:
                                {{ Auth::user()->apogee ?? 'N/A' }}</span>
                            <span
                                class="bg-slate-100 text-slate-600 font-bold px-3 py-1 rounded-lg text-xs uppercase tracking-wider">Étudiant</span>
                        </div>
                    </div>
                </div>

                <!-- View Mode -->
                <div x-show="!editing" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translateY-4" x-transition:enter-end="opacity-100 translateY-0"
                    class="p-8 grid grid-cols-1 md:grid-cols-2 gap-12 border-t border-slate-100 mt-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-id-card text-indigo-500"></i> Informations Personnelles
                        </h3>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 shrink-0">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-black tracking-widest mb-0.5">E-mail
                                        Institutionnel</p>
                                    <p class="text-slate-700 font-medium">{{ Auth::user()->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                                <div
                                    class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 shrink-0">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400 uppercase font-black tracking-widest mb-0.5">Numéro de
                                        téléphone</p>
                                    <p class="text-slate-700 font-medium">{{ Auth::user()->phone ?? 'Non renseigné' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fas fa-graduation-cap text-indigo-500"></i> Statut Académique
                        </h3>
                        <div
                            class="p-6 rounded-3xl bg-gradient-to-br from-indigo-50 to-purple-50 border border-indigo-100 relative overflow-hidden group">
                            <i
                                class="fas fa-certificate absolute -right-4 -bottom-4 text-8xl text-indigo-200/40 transform rotate-12 group-hover:scale-110 transition duration-500"></i>
                            <p class="text-slate-700 font-medium relative z-10 leading-relaxed text-sm">
                                Votre compte est actif. Vous avez accès aux services numériques de l'établissement. Votre
                                numéro Apogée est définitif et ne peut être modifié que par l'administration.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div x-show="editing" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translateY-4" x-transition:enter-end="opacity-100 translateY-0"
                    style="display: none;" class="p-8 border-t border-slate-100 mt-6 bg-slate-50/30">
                    <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Identité</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Nom</label>
                                        <div class="relative">
                                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="text" name="nom" value="{{ Auth::user()->nom }}" required
                                                class="w-full input-premium pl-11 pr-4 py-3 rounded-xl" placeholder="Votre nom">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Prénom</label>
                                        <div class="relative">
                                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                            <input type="text" name="prenom" value="{{ Auth::user()->prenom }}" required
                                                class="w-full input-premium pl-11 pr-4 py-3 rounded-xl" placeholder="Votre prénom">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Email</label>
                                    <div class="relative">
                                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="email" name="email" value="{{ Auth::user()->email }}" required
                                            class="w-full input-premium pl-11 pr-4 py-3 rounded-xl" placeholder="Email">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Téléphone</label>
                                    <div class="relative">
                                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                                            class="w-full input-premium pl-11 pr-4 py-3 rounded-xl" placeholder="Ex: 06 00 00 00 00">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-1 ml-1">Numéro Apogée
                                        (Verrouillé)</label>
                                    <div
                                        class="w-full px-4 py-3 rounded-xl bg-slate-200/50 text-slate-500 flex items-center gap-2 cursor-not-allowed border border-slate-200">
                                        <i class="fas fa-lock text-xs"></i>
                                        <span class="font-medium">{{ Auth::user()->apogee }}</span>
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-1 ml-1">*L'Apogée doit être modifié par
                                        l'administrateur.</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Sécurité & Photo
                                </h4>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2 ml-1">Photo de profil</label>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl border border-dashed border-slate-300 bg-white shadow-inner">
                                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://ui-avatars.com/api/?name=' . Auth::user()->nom . '+' . Auth::user()->prenom }}"
                                            class="w-12 h-12 rounded-lg object-cover">
                                        <input type="file" name="photo"
                                            class="text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition">
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-slate-100">
                                    <label class="block text-xs font-bold text-slate-500 mb-2 ml-1 text-indigo-600">Changer
                                        le mot de passe</label>
                                    <div class="relative mb-4">
                                        <i class="fas fa-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="password" name="password"
                                            class="w-full input-premium pl-11 pr-4 py-3 rounded-xl"
                                            placeholder="Nouveau mot de passe">
                                    </div>
                                    <div class="relative">
                                        <i class="fas fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="password" name="password_confirmation"
                                            class="w-full input-premium pl-11 pr-4 py-3 rounded-xl"
                                            placeholder="Confirmer le nouveau mot de passe">
                                    </div>
                                    <p class="text-[10px] text-slate-400 mt-2 italic ml-1">*Laissez vide pour conserver
                                        votre mot de passe actuel.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <button type="submit"
                                class="w-full btn-brand text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection