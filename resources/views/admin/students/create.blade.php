@extends('layouts.admin')

@section('admin_title', 'Ajouter un Étudiant')

@section('admin_content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.students.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Ajouter un Étudiant</h2>
        </div>

        <div class="premium-card p-8 rounded-3xl">
            <form action="{{ route('admin.students.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nom</label>
                        <input type="text" name="nom" required class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="Nom de l'étudiant">
                        @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom</label>
                        <input type="text" name="prenom" required class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="Prénom de l'étudiant">
                        @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="email@exemple.com">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                        <input type="password" name="password" required class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="••••••••">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Numéro Apogée</label>
                        <input type="text" name="apogee" class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="CP123456">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="06XXXXXXXX">
                    </div>
                </div>



                <button type="submit"
                    class="w-full btn-brand text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Créer l'étudiant
                </button>
            </form>
        </div>
    </div>
@endsection