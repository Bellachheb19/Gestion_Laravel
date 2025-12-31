@extends('layouts.admin')

@section('admin_title', 'Liste des Étudiants')

@section('admin_content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800">Liste des Étudiants</h2>
        <a href="{{ route('admin.students.create') }}"
            class="btn-brand text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-indigo-200">
            <i class="fas fa-plus mr-2"></i> Ajouter un étudiant
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="premium-card rounded-2xl overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Photo</th>
                    <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Nom & Prénom</th>
                    <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Apogée</th>
                    <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500">Email</th>
                    <th class="px-6 py-4 text-xs uppercase font-bold text-slate-500 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($students as $student)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}"
                                    class="w-10 h-10 rounded-lg object-cover border border-slate-200 shadow-sm" alt="">
                            @else
                                <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700">{{ $student->prenom }} {{ $student->nom }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-indigo-600 font-semibold">{{ $student->apogee ?? '---' }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            {{ $student->email }}
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.students.edit', $student) }}"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition font-semibold text-xs">
                                    <i class="fas fa-edit"></i>
                                    Modifier
                                </a>
                                <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition font-semibold text-xs">
                                        <i class="fas fa-trash"></i>
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-users-slash text-4xl mb-4 opacity-20"></i>
                            <p>Aucun étudiant trouvé.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4 bg-slate-50">
            {{ $students->links() }}
        </div>
    </div>
@endsection