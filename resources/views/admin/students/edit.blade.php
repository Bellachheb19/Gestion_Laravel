@extends('layouts.admin')

@section('admin_title', 'Modifier l\'Étudiant')

@section('admin_content')
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('admin.students.index') }}"
                class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition">
                <i class="fas fa-arrow-left text-sm"></i>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Modifier l'Étudiant</h2>
        </div>

        <div class="premium-card p-8 rounded-3xl">
            <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nom</label>
                        <input type="text" name="nom" value="{{ $student->nom }}" required
                            class="w-full input-premium px-4 py-3 rounded-xl">
                        @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Prénom</label>
                        <input type="text" name="prenom" value="{{ $student->prenom }}" required
                            class="w-full input-premium px-4 py-3 rounded-xl">
                        @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $student->email }}" required
                            class="w-full input-premium px-4 py-3 rounded-xl">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe <span
                                class="text-xs text-slate-400">(vide pour ne pas changer)</span></label>
                        <input type="password" name="password" class="w-full input-premium px-4 py-3 rounded-xl"
                            placeholder="••••••••">
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Numéro Apogée</label>
                        <input type="text" name="apogee" value="{{ $student->apogee }}"
                            class="w-full input-premium px-4 py-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" value="{{ $student->phone }}"
                            class="w-full input-premium px-4 py-3 rounded-xl">
                    </div>
                </div>

                <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-2xl">
                    <div class="flex-shrink-0">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}"
                                class="w-20 h-20 rounded-xl object-cover border-2 border-white shadow-sm" alt="">
                        @else
                            <div class="w-20 h-20 rounded-xl bg-slate-200 flex items-center justify-center text-slate-400">
                                <i class="fas fa-user-graduate text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-700">Photo de profil</p>
                        <p class="text-xs text-slate-500">L'administrateur n'est pas autorisé à modifier la photo de
                            l'étudiant.</p>
                    </div>
                </div>

                <button type="submit"
                    class="w-full btn-brand text-white font-bold py-4 rounded-xl shadow-lg shadow-indigo-200 transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Mettre à jour l'étudiant
                </button>
            </form>
        </div>
    </div>
@endsection